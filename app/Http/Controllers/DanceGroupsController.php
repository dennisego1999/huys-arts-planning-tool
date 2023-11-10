<?php

namespace App\Http\Controllers;

use App\Actions\DanceGroupUpdateAction;
use App\Http\Requests\UpdateDanceGroupRequest;
use App\Http\Resources\DanceGroupResource;
use App\Models\DanceGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DanceGroupsController extends Controller
{
    public function index(Request $request)
    {
        $danceGroups = DanceGroup::query()
            ->when($request->input('search'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->input('search') . '%');
            })
            ->paginate(8);

        return Inertia::render('Dashboard/DanceGroups/Index', [
            'groups' => DanceGroupResource::collection($danceGroups),
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

    public function show(DanceGroup $danceGroup)
    {
        return Inertia::render('Dashboard/DanceGroups/Show', [
            'group' => new DanceGroupResource($danceGroup),
        ]);
    }

    public function edit(DanceGroup $danceGroup)
    {
        return Inertia::render('Dashboard/DanceGroups/Edit', [
            'group' => new DanceGroupResource($danceGroup),
            'users' => User::all(),
        ]);
    }

    public function update(UpdateDanceGroupRequest $request, DanceGroupUpdateAction $danceGroupUpdateAction, DanceGroup $danceGroup)
    {
        $formData = $request->validated();
        $danceGroupUpdateAction->handle($formData, $danceGroup);

        return redirect()->back();
    }

    public function destroy($id)
    {
        //
    }
}
