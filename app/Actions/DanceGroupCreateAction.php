<?php

namespace App\Actions;

use App\Models\DanceGroup;
use App\Models\User;
use App\Notifications\DanceGroupInvitationNotification;

class DanceGroupCreateAction
{
    public function handle(array $data): void
    {
        $danceGroup = DanceGroup::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Sync members
        if(isset($data['members'])) {
            $memberIds = collect($data['members'])->pluck('id');
            $danceGroup->members()->sync($memberIds);

            // Notify the new members
            foreach ($data['members'] as $member) {
                $userModel = User::find($member['id']);
                $userModel->notify(new DanceGroupInvitationNotification($danceGroup));
            }
        }

        // Add media when necessary
        if(isset($data['new_image'])) {
            $danceGroup->addMedia($data['new_image'])->toMediaCollection('dance-group-assets', 'assets');
        }
    }
}
