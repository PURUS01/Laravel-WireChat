<?php

namespace App\Services\Wirechat;

use App\Models\User;
use Wirechat\Wirechat\Enums\ConversationType;
use Wirechat\Wirechat\Enums\ParticipantRole;
use Wirechat\Wirechat\Models\Conversation;
use Wirechat\Wirechat\Models\Participant;

class EnsureGeneralConversation
{
    public function forUser(User $user): void
    {
        $conversation = Conversation::query()
            ->where('type', ConversationType::GROUP)
            ->whereHas('group', fn ($query) => $query->where('name', 'General'))
            ->first();

        if (! $conversation) {
            $owner = User::query()->orderBy('id')->first() ?? $user;
            $conversation = $owner->createGroup('General', 'Default chat for all registered users');
        }

        Participant::query()->firstOrCreate(
            [
                'conversation_id' => $conversation->getKey(),
                'participantable_id' => $user->getKey(),
                'participantable_type' => User::class,
            ],
            ['role' => ParticipantRole::PARTICIPANT]
        );
    }
}
