<?php

namespace App\Http\Controllers;

use App\Actions\DanceGroupCreateAction;
use App\Actions\DanceGroupDestroyAction;
use App\Actions\DanceGroupUpdateAction;
use App\Http\Requests\CreateDanceGroupRequest;
use App\Http\Requests\UpdateDanceGroupRequest;
use App\Http\Resources\DanceGroupResource;
use App\Models\DanceGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DanceGroupController extends Controller
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
        return Inertia::render('Dashboard/DanceGroups/Create', [
            'users' => User::all(),
        ]);
    }

    public function store(CreateDanceGroupRequest $request, DanceGroupCreateAction $danceGroupCreateAction)
    {
        // Authorize
        $this->authorize('create', DanceGroup::class);

        // Create the dance group
        $formData = $request->validated();
        $danceGroupCreateAction->handle($formData);

        return redirect()->route('dance-groups.index')->with('success', trans('spa.toasts.description.dance_group_created'));
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
        // Authorize
        $this->authorize('update', DanceGroup::class);

        // Update the dance group
        $formData = $request->validated();
        $danceGroupUpdateAction->handle($formData, $danceGroup);

        return redirect()->route('dance-groups.show', [
            'dance_group' => $danceGroup
        ])->with('success', trans('spa.toasts.description.dance_group_updated'));
    }

    public function destroy(DanceGroupDestroyAction $danceGroupDestroyAction, DanceGroup $danceGroup)
    {
        // Authorize
        $this->authorize('delete', DanceGroup::class);

        // Delete the dance group
        $danceGroupDestroyAction->handle($danceGroup);

        return redirect()->back();
    }
}
