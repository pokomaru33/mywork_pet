<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Animal;
use App\Models\Weight;

class WeightController extends Controller
{
    //
    public function show(Weight $weight)
    {
        $name = $weight->animal->name;
        $weight = Arr::add($weight, 'name', $name);
        return $weight;
    }

    public function update(Request $request, $weight)
    {
        //animal_id取得
        $user = auth()->user()->id;
        $get_pet_id = request('pet_id');
        if (isset($get_pet_id)) {
            $user_pets_alive = Animal::where('user_id', $user)->where('flg_alive', 0)->get();
            $animal_id = $user_pets_alive[$request['pet_id']]->id;
        }

        $data = Weight::find($weight);
        $data->animal_id = $animal_id;
        $data->weight = $request->weight;
        $data->save();
        // return dd($weight);
    }



    public function destroy(Weight $weight)
    {
        $weight->delete();
        return $weight;
    }
}
