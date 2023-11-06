<?php

namespace App\Http\Controllers;

use App\Actions\UserUpdateAction;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserManagementController extends Controller
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

        return Inertia::render('Admin/UserManagement/Index', [
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

    public function show($id)
    {
        //
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/UserManagement/Edit', [
            'user' => $user,
        ]);
    }

    public function update(UpdateUserRequest $request, UserUpdateAction $userUpdateAction, User $user)
    {
        $formData = $request->validated();
        $userUpdateAction->handle($formData, $user);

        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
