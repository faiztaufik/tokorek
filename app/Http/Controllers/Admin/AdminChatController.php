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
            DB::raw('SUM(CASE WHEN is_admin = 0 THEN 1 ELSE 0 END) as unread_count'),
        ])
            ->whereNotNull('session_id')
            ->groupBy('session_id')
            ->orderBy('latest_message_time', 'desc')
            ->get();

        // Get messages for the first session (if any)
        $activeSession = $sessions->first();
        $messages = collect();

        if ($activeSession) {
            $messages = ChatMessage::where('session_id', $activeSession->session_id)
                ->orderBy('created_at', 'asc')
                ->get();
        }

        return view('admin.pages.chat.index', [
            'title' => 'Live Chat Admin',
            'sessions' => $sessions,
            'messages' => $messages,
            'activeSession' => $activeSession,
        ]);
    }

    public function getSession($sessionId)
    {
        $messages = ChatMessage::where('session_id', $sessionId)
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'messages' => $messages,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
            'session_id' => 'nullable|string',
        ]);

        // XSS Protection - Remove script tags and dangerous HTML
        $message = $this->sanitizeMessage($request->message);

        // Additional validation for XSS patterns
        if ($this->containsXSS($message)) {
            return response()->json([
                'success' => false,
                'error' => 'Pesan mengandung konten yang tidak diizinkan.',
            ], 422);
        }

        $chatMessage = ChatMessage::create([
            'user_name' => 'Admin',
            'message' => $message,
            'is_admin' => true,
            'session_id' => $request->session_id,
        ]);

        broadcast(new MessageSent($chatMessage))->toOthers();

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
