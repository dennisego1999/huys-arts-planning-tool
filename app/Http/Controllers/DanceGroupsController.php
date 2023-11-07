<?php

namespace App\Http\Controllers;

use App\Actions\DanceGroupUpdateAction;
use App\Http\Requests\UpdateDanceGroupRequest;
use App\Http\Resources\DanceGroupResource;
use App\Models\DanceGroup;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DanceGroupsController extends Controller
{
    public function index()
    {
        return Inertia::render('DanceGroups/Index', [
            'groups' => DanceGroupResource::collection(DanceGroup::all()),
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
        return Inertia::render('DanceGroups/Show', [
            'group' => new DanceGroupResource($danceGroup),
        ]);
    }

    public function edit(DanceGroup $danceGroup)
    {
        return Inertia::render('DanceGroups/Edit', [
            'group' => new DanceGroupResource($danceGroup),
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
