<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;

class InternalUserSeeder extends Seeder
{
    private array $teams = [
        'Modern',
        'Hiphop',
        'Ballet',
        'Circus',
    ];

    private array $users = [
        [
            'first_name' => 'Dennis',
            'last_name' => 'Ego',
            'email' => 'dennis.ego@artcoresociety.com',
            'password' => 'Arty007*',
            'roles' => ['admin'],
            'teams' => ['Modern', 'Hiphop'],
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->seedTeams();
        $this->createUsers();
    }

    private function seedTeams(): void
    {
        foreach ($this->teams as $team) {
            $team = Team::updateOrCreate(
                ['name' => $team],
                ['user_id' => 1]
            );
        }
    }

    private function createUsers(): void
    {
        // Get the teams
        $teams = Team::query()
            ->select(['id', 'name'])
            ->get();

        foreach ($this->users as $user) {
            // Skip if the user already exists
            if (User::where('email', $user['email'])->exists()) {
                continue;
            }

            // Create the user
            $this->createUser($user, $teams);
        }
    }

    private function createUser(array $user, Collection $teams = null): void
    {
        // Create the user
        $userModel = User::factory()->create([
            'first_name' => $user['first_name'],
            'last_name' => $user['last_name'] ?? null,
            'email' => $user['email'],
            'password' => Hash::make($user['password']),
        ]);

        // Give the user the correct roles
        $userModel->syncRoles($user['roles'] ?? []);

        // Retrieve the teams of the user in reverse order
        if (isset($user['teams'])) {
            $teams = Team::query()
                ->select('id')
                ->whereIn('name', $user['teams'])
                ->get()
                ->reverse();
        }

        // Abort without teams
        if (blank($teams)) {
            return;
        }

        // Give the user the teams
        $userModel->teams()->sync($teams->pluck('id'));

        // Ensure the user has a current team
        $userModel->setAttribute('current_team_id', $teams->first()?->id);
        $userModel->saveQuietly();
    }
}
