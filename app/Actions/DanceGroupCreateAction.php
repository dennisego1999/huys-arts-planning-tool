<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupCreateAction
{
    public function handle(array $data)
    {
        $model = DanceGroup::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        // Add media when necessary
        if($data['new_image']) {
            $model->addMedia($data['new_image'])->toMediaCollection('dance-group-assets', 'assets');
        }

        // Sync members
        $memberIds = collect($data['members'])->pluck('id');
        $model->members()->sync($memberIds);
    }
}
