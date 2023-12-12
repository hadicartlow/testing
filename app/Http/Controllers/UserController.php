<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $stores = Stores::with('regions')->get();
        return view('home', compact('stores'));
    }
    public function store(Request $request)
    {
        $regions  = [1, 2, 3];

        $stores = new Stores();
        $stores->name = $request->input('store_name');
        $stores->save();
        $stores->regions()->attach($regions);
    }
    
    public function update(Request $request, $id)
    {
        $regions  = [4, 5];
        $stores = Stores::find($id);
        $stores->regions()->sync($regions);
    }
    public function destroy($id)
    {
        $stores = Stores::find($id);
        $stores->regions()->detach();

        $stores->delete();
    }
}
