<?php

namespace App\Http\Controllers\General;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class GeneralChatController extends Controller
{
    public function index(Request $request)
    {
        // Generate or retrieve chat session UUID from cookie
        $sessionId = $request->cookie('chat_session_id');

        if (! $sessionId) {
            $sessionId = Str::uuid()->toString();
        }

        // Only get messages for the current session
        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Store session ID in session for Chrome compatibility
        $request->session()->put('chat_session_id', $sessionId);

        return response()->view('general.pages.chat.index', [
            'title' => 'Live Chat',
            'messages' => $messages,
            'currentSessionId' => $sessionId,
        ])->cookie('chat_session_id', $sessionId, 60 * 24 * 30); // 30 days
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'file' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,txt,zip,rar', // 10MB max
        ]);

        // Ensure either message or file is provided
        if (! $request->message && ! $request->hasFile('file')) {
            return response()->json([
                'success' => false,
                'error' => 'Silakan ketik pesan atau upload file.',
            ], 422);
        }

        // XSS Protection for message if provided
        $message = '';
        if ($request->message) {
            $message = $this->sanitizeMessage($request->message);

            if ($this->containsXSS($message)) {
                return response()->json([
                    'success' => false,
                    'error' => 'Pesan mengandung konten yang tidak diizinkan.',
                ], 422);
            }
        }

        // Get session ID from cookie or generate new one
        $sessionId = $request->cookie('chat_session_id');

        if (! $sessionId) {
            $sessionId = Str::uuid()->toString();
        }

        // Generate a consistent user name based on session
        $userName = 'Pengguna '.substr($sessionId, -6);

        // Handle file upload
        $filePath = null;
        $fileName = null;
        $fileType = null;
        $fileSize = null;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $fileType = $file->getMimeType();
            $fileSize = $file->getSize();

            // Store file in storage/app/public/chat-files
            $filePath = $file->store('chat-files', 'public');

            // If no message provided, set a default message for file
            if (! $message) {
                if (str_starts_with($fileType, 'image/')) {
                    $message = '📷 Mengirim gambar';
                } else {
                    $message = '📎 Mengirim file';
                }
            }
        }

        $chatMessage = ChatMessage::create([
            'user_name' => $userName,
            'message' => $message,
            'is_admin' => false,
            'session_id' => $sessionId,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        broadcast(new MessageSent($chatMessage));

        return response()->json([
            'success' => true,
            'message' => $chatMessage,
        ])->cookie('chat_session_id', $sessionId, 60 * 24 * 30); // 30 days
    }

    /**
     * Sanitize message to prevent XSS
     */
    private function sanitizeMessage($message)
    {
        // Remove HTML tags except safe ones
        $allowedTags = '<b><i><u><em><strong>';
        $message = strip_tags($message, $allowedTags);

        // Convert special characters to HTML entities
        $message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

        // Remove potential JavaScript protocols
        $message = preg_replace('/javascript:/i', '', $message);
        $message = preg_replace('/vbscript:/i', '', $message);
        $message = preg_replace('/onload/i', '', $message);
        $message = preg_replace('/onerror/i', '', $message);

        return trim($message);
    }

    /**
     * Check if message contains XSS patterns
     */
    private function containsXSS($message)
    {
        $xssPatterns = [
            '/<script\b[^<]*(?:(?!<\/script>)<[^<]*)*<\/script>/mi',
            '/<iframe\b[^<]*(?:(?!<\/iframe>)<[^<]*)*<\/iframe>/mi',
            '/javascript:/i',
            '/vbscript:/i',
            '/on\w+\s*=/i',
            '/<object\b[^<]*(?:(?!<\/object>)<[^<]*)*<\/object>/mi',
            '/<embed\b[^<]*(?:(?!<\/embed>)<[^<]*)*<\/embed>/mi',
            '/<form\b[^<]*(?:(?!<\/form>)<[^<]*)*<\/form>/mi',
            '/expression\s*\(/i',
            '/url\s*\(/i',
            '/@import/i',
        ];

        foreach ($xssPatterns as $pattern) {
            if (preg_match($pattern, $message)) {
                return true;
            }
        }

        return false;
    }

    public function loadMessages()
    {
        $messages = ChatMessage::latest()->take(50)->get()->reverse()->values();

        return response()->json($messages);
    }
}
