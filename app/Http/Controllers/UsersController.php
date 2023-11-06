<?php

namespace App\Http\Controllers;

use App\Actions\UserDestroyAction;
use App\Actions\UserUpdateAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where(fn($subQuery) => $subQuery
                    ->where('first_name', 'like', $request->input('search') . '%')
                    ->orWhere('last_name', 'like', $request->input('search') . '%'));
            })
            ->paginate(6);

        return Inertia::render('Admin/Users/Index', [
            'users' => $users,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(User $user)
    {
        return Inertia::render('Admin/Users/Show', [
            'user' => $user
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, UserUpdateAction $userUpdateAction, User $user)
    {
        $formData = $request->validated();
        $userUpdateAction->handle($formData, $user);

        return redirect()->route('users.index');
    }

    public function destroy(UserDestroyAction $userDestroyAction, User $user)
    {
        $this->authorize('manage-users', User::class);

        $userDestroyAction->handle($user);

        return redirect()->back();
    }
}
