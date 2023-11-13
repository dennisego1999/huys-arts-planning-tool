<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupUpdateAction
{
    public function handle(array $data, DanceGroup $danceGroup)
    {
        DanceGroup::updateOrCreate(['id' => $danceGroup->id], [
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Sync members
        $memberIds = collect($data['members'])->pluck('id');
        $danceGroup->members()->sync($memberIds);

        // Add media when necessary
        if($data['new_image']) {
            $danceGroup->addMedia($data['new_image'])->toMediaCollection('dance-group-assets', 'assets');

            return;
        }

        // Remove media
        $danceGroup
            ->getFirstMedia('dance-group-assets')
            ->delete();
    }
}
