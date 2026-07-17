<?php

namespace App\Http\Controllers;

use App\Models\Facility;
use App\Http\Requests\FacilityStoreRequest;
use App\Http\Requests\FacilityUpdateRequest;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;


class FacilityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $filters = Request::only(['type', 'search', 'trashed']);
        $facilities = Facility::query()->orderBy('name')->filter($filters)->paginate(10)->appends(Request::all());

        return Inertia::render('dashboard', [
            'facilities' => $facilities,
            'filters' => $filters
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('facilities/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(FacilityStoreRequest $request)
    {
        Facility::factory()->create([
            'name' => $request->name,
            'description' => $request->description,
            'type' => $request->type,
            'capacity' => $request->capacity,
            'location' => $request->location
        ]);

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Facility created.')]);
        return to_route('dashboard');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Facility $facility)
    {
        return Inertia::render('facilities/edit', [
            'facility' => $facility,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Facility $facility, FacilityUpdateRequest $request)
    {
        $facility->name = $request->name;
        $facility->description = $request->description;
        $facility->type = $request->type;
        $facility->capacity = $request->capacity;
        $facility->location = $request->location;
        $facility->save();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Facility updated.')]);
        return to_route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Facility $facility)
    {
        $facility->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => __('Facility deleted.')]);
        return to_route('dashboard');
    }
}
