<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use App\Models\Animal;
use App\Models\Note;

class NoteController extends Controller
{
    //
    public function show(Note $note)
    {
        $name = $note->animal->name;
        $note = Arr::add($note, 'name', $name);
        return $note;
    }

    public function update(Request $request, $note)
    {
        //animal_id取得
        $user = auth()->user()->id;
        $get_pet_id = request('pet_id');
        if (isset($get_pet_id)) {
            $user_pets_alive = Animal::where('user_id', $user)->where('flg_alive', 0)->get();
            $animal_id = $user_pets_alive[$request['pet_id']]->id;
        }

        $data = Note::find($note);
        $data->animal_id = $animal_id;
        $data->title = $request->title;
        $data->body = $request->body;
        $data->flg_type = $request->flg_type;
        $data->save();
    }



    public function destroy(Note $note)
    {
        $note->delete();
        return $note;
    }
}
