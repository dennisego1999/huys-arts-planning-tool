<?php

namespace App\Actions;

use App\Models\DanceGroup;
use App\Models\User;
use App\Notifications\DanceGroupInvitationNotification;

class DanceGroupUpdateAction
{
    public function handle(array $data, DanceGroup $danceGroup): void
    {
        DanceGroup::updateOrCreate(['id' => $danceGroup->id], [
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
        if($data['new_image']) {
            $danceGroup->addMedia($data['new_image'])->toMediaCollection('dance-group-assets', 'assets');

            return;
        }

        // Remove media
        $danceGroup
            ->getFirstMedia('dance-group-assets')
            ?->delete();
    }
}
