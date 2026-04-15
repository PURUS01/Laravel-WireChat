<?php

namespace App\Services\Wirechat;

use App\Models\User;

class EnsurePrivateConversations
{
    private const INITIAL_MESSAGE = 'Chat started. You can message here anytime.';

    public function forUser(User $user): void
    {
        User::query()
            ->whereKeyNot($user->getKey())
            ->orderBy('id')
            ->chunk(200, function ($peers) use ($user): void {
                foreach ($peers as $peer) {
                    // Pass an initial message so new conversations are visible in sidebar.
                    $user->createConversationWith($peer, self::INITIAL_MESSAGE);
                }
            });
    }
}
