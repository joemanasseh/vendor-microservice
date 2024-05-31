<?php

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    public function index()
    {
        return Vendor::all();
    }

    public function store(Request $request)
    {
        $vendor = Vendor::create($request->all());
        return response()->json($vendor, 201);
    }

    public function show($id)
    {
        return Vendor::findOrFail($id);
    }

    public function update(Request $request, $id)
    {
        $vendor = Vendor::findOrFail($id);
        $vendor->update($request->all());
        return response()->json($vendor, 200);
    }

    public function destroy($id)
    {
        Vendor::findOrFail($id)->delete();
        return response()->json(null, 204);
    }
}
