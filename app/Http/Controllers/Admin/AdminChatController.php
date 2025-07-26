<?php

namespace App\Http\Controllers\Admin;

use App\Events\MessageSent;
use App\Http\Controllers\Controller;
use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminChatController extends Controller
{
    public function index()
    {
        // Get all sessions with latest message and user info
        $sessions = ChatMessage::select([
            'session_id',
            DB::raw('MAX(created_at) as latest_message_time'),
            DB::raw('COUNT(*) as message_count'),
            DB::raw('SUM(CASE WHEN is_admin = 0 AND is_seen_by_admin = 0 THEN 1 ELSE 0 END) as unread_count'),
        ])
            ->whereNotNull('session_id')
            ->groupBy('session_id')
            ->orderBy('latest_message_time', 'desc')
            ->get();

        // Get messages for the first session (if any)
        $messages = collect();
        $firstSessionId = null;

        if ($sessions->count() > 0) {
            $firstSessionId = $sessions->first()->session_id;
            $messages = ChatMessage::where('session_id', $firstSessionId)
                ->orderBy('created_at', 'asc')
                ->get();

            // Mark messages as read for the first session
            ChatMessage::where('session_id', $firstSessionId)
                ->where('is_admin', false)
                ->where('is_seen_by_admin', false)
                ->update([
                    'is_seen_by_admin' => true,
                    'seen_at' => now()
                ]);
        }

        return view('admin.pages.chat.index', [
            'title' => 'Live Chat Admin',
            'sessions' => $sessions,
            'messages' => $messages,
            'firstSessionId' => $firstSessionId,
        ]);
    }

    public function getSession($sessionId)
    {
        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        // Mark all unread messages from users as read
        ChatMessage::where('session_id', $sessionId)
            ->where('is_admin', false)
            ->where('is_seen_by_admin', false)
            ->update([
                'is_seen_by_admin' => true,
                'seen_at' => now()
            ]);

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function getUnreadCount()
    {
        $totalUnread = ChatMessage::unreadByAdmin()->count();
        
        return response()->json([
            'success' => true,
            'unread_count' => $totalUnread,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'nullable|string|max:1000',
            'session_id' => 'nullable|string',
            'file' => 'nullable|file|max:10240|mimes:jpeg,jpg,png,gif,webp,pdf,doc,docx,txt,zip,rar', // 10MB max
        ]);

        // Ensure either message or file is provided
        if (!$request->message && !$request->hasFile('file')) {
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
            if (!$message) {
                if (str_starts_with($fileType, 'image/')) {
                    $message = '📷 Admin mengirim gambar';
                } else {
                    $message = '📎 Admin mengirim file';
                }
            }
        }

        $chatMessage = ChatMessage::create([
            'user_name' => 'Admin',
            'message' => $message,
            'is_admin' => true,
            'session_id' => $request->session_id,
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'file_size' => $fileSize,
        ]);

        broadcast(new MessageSent($chatMessage));

        return response()->json([
            'success' => true,
            'message' => $chatMessage,
        ]);
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

    public function clear()
    {
        ChatMessage::truncate();

        return response()->json([
            'success' => true,
            'message' => 'All chats have been cleared.',
        ]);
    }
}
