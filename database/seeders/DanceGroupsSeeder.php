<?php

namespace Database\Seeders;

use App\Models\DanceGroup;
use Illuminate\Database\Seeder;

class DanceGroupsSeeder extends Seeder
{
    private array $groups = [
        'Peuterdans',
        'Dance4Kids',
        'Streetdance',
        'HipHop',
        'Hedendaags / Modern Dance',
        'Jazz',
        'Pointes',
        'Body in Ballance',
        'Ballet pre-professional',
        'Klassiek Ballet',
        'Showdance',
        'Koppeldans',
        '55+ Fit',
        'G-dans',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createDanceGroups();
    }

    private function createDanceGroups(): void
    {
        foreach ($this->groups as $group) {
            // Create the dance group
            $model = DanceGroup::factory()->create([
                'name' => $group,
            ]);

            // Save the dance group
            $model->saveQuietly();
        }
    }
}
