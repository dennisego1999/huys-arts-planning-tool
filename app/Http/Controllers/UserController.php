<?php

namespace App\Http\Controllers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Actions\Jetstream\DeleteUser;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->input('search'), function ($query) use ($request) {
                $query
                    ->where('first_name', 'like', $request->input('search') . '%')
                    ->orWhere('last_name', 'like', $request->input('search') . '%');
            })
            ->with(['roles'])
            ->paginate(10);

        return Inertia::render('Dashboard/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        return Inertia::render('Dashboard/Users/Create', [
            'roles' => Role::all(),
        ]);
    }

    public function store(Request $request, CreateNewUser $createNewUser)
    {
        // Authorize
        $this->authorize('create', User::class);

        // Create new user
        $createNewUser->create($request->all());

        return redirect()->route('users.index')->with('success', trans('spa.toasts.description.user_created'));
    }

    public function show(User $user)
    {
        return Inertia::render('Dashboard/Users/Show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Dashboard/Users/Edit', [
            'user' => $user->loadMissing(['roles']),
            'roles' => Role::all(),
        ]);
    }

    public function update(Request $request, UpdateUserProfileInformation $updateUserProfileInformation, User $user)
    {
        // Authorize
        $this->authorize('update', $user);

        // Update user profile information
        $updateUserProfileInformation->update($user, $request->all());

        return redirect()->route('users.index')->with('success', trans('spa.toasts.description.user_updated'));
    }

    public function destroy(DeleteUser $deleteUserAction, User $user)
    {
        // Authorize
        $this->authorize('delete', $user);

        // Delete the user
        $deleteUserAction->delete($user);

        return redirect()->back()->with('success', trans('spa.toasts.description.user_deleted'));
    }
}
