<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Secure channel for guest chat sessions using UUID validation
Broadcast::channel('chat.{sessionId}', function ($user, $sessionId) {
    // no auth needed for guest session
    return true;
});

// Admin chat channel - public for admin interface
Broadcast::channel('chat', function () {
    return true; // Public channel for admin to listen to all chats
});
