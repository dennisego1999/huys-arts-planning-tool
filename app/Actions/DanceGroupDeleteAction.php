<?php

namespace App\Actions;

use App\Models\DanceGroup;

class DanceGroupDeleteAction
{
    public function handle(DanceGroup $danceGroup)
    {
        // Delete dance group
        $danceGroup->delete();
    }
}
