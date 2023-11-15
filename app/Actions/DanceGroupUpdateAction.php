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

        if(isset($data['members'])) {
            // Get the member ids
            $memberIds = collect($data['members'])->pluck('id');

            // Check which members are new
            $existingMemberIds = collect($danceGroup->members)->pluck('id');
            $newMemberIds = array_diff($memberIds->toArray(), $existingMemberIds->toArray());

            if(count($memberIds) !== 0) {
                foreach ($newMemberIds as $newMemberId) {
                    // Get the user model
                    $userModel = User::find($newMemberId);

                    // Notify the new member
                    $userModel->notify(new DanceGroupInvitationNotification($danceGroup));
                }
            }

            // Sync members
            $danceGroup->members()->sync($memberIds);
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
