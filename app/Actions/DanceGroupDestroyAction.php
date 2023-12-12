<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupDestroyAction
{
    public function handle(DanceGroup $danceGroup): void
    {
        // Delete dance group
        $danceGroup->delete();
    }
}
