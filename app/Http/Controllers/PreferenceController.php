<?php

namespace App\Http\Controllers;

use App\Models\Preference;
use Illuminate\Http\Request;
use App\Http\Resources\PreferenceResource;
use App\Http\Requests\StorePreferenceRequest;

class PreferenceController extends Controller
{
    public function index()
    {
        return PreferenceResource::collection(Preference::all());
    }

    public function store(StorePreferenceRequest $request)
    {
        $preference = Preference::create($request->validated());
        return new PreferenceResource($preference);
    }

    public function show($id)
    {
        return new PreferenceResource(Preference::findOrFail($id));
    }

    public function update(StorePreferenceRequest $request, $id)
    {
        $preference = Preference::findOrFail($id);
        $preference->update($request->validated());
        return new PreferenceResource($preference);
    }

    public function destroy($id)
    {
        Preference::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
