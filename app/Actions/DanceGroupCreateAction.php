<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupCreateAction
{
    public function handle(array $data): void
    {
        $model = DanceGroup::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Add media when necessary
        if(isset($data['new_image'])) {
            $model->addMedia($data['new_image'])->toMediaCollection('dance-group-assets', 'assets');
        }

        // Sync members
        if(isset($data['members'])) {
            $memberIds = collect($data['members'])->pluck('id');
            $model->members()->sync($memberIds);
        }
    }
}
