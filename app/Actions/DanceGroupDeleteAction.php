<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupDeleteAction
{
    public function handle(DanceGroup $danceGroup): void
    {
        // Delete dance group
        $danceGroup->delete();
    }
}
