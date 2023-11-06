<?php

namespace App\Http\Controllers;

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

    public function edit($id)
    {
        return Inertia::render('Admin/UserManagement/Edit', [
            'user' => User::find($id),
        ]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
