<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\User;
use App\Models\Animal;
use App\Models\Weight;

class AnimalController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user()->id;

        //created_atを使いやすくする
        function date_arrange($array)
        {
            foreach ($array as $row) {
                foreach ($row as $each) {
                    if ($each->created_at) {
                        $each->newdate = Carbon::createFromFormat('Y-m-d H:i:s', $each->created_at)->format('Y年m月d日');
                    }
                }
            }
        }

        //ユーザーのペット取得
        $user_pets = Animal::where('user_id', $user)->orderBy('flg_alive')->orderBy('birth', 'desc')->get();

        //ユーザーのペットの体重取得
        $user_pets_weight = [];
        foreach ($user_pets as $each) {
            $id = $each->id;
            $user_pets_weight[$id] = Weight::where('animal_id', $id)->get();
        }
        date_arrange($user_pets_weight);


        $send_pet_data = [];
        foreach ($user_pets as $row) {
            $birth_y = substr($row->birth, 0, 4);
            $birth_m = substr($row->birth, 4, 2);
            $birth_d = substr($row->birth, 6);
            if ($row->pass_age) {
                $row->age = $row->pass_age;
            } else {
                if ($birth_m < 13 && $birth_d < 32) {
                    $birth_age = $birth_y . '-' . $birth_m . '-' . $birth_d;
                    $dob = Carbon::parse($birth_age);
                    $row->age = $dob->age;
                } else {
                    $row->age = '誕生日がへんです';
                }
            }
            $birth = $birth_y . '年' . $birth_m . '月' . $birth_d . '日';
            $row->birth_n = $birth;

            $send_pet_data[] = ['id' => $row->id, 'name' => $row->name, 'kind_name' => $row->kind_name, 'kind_animal' => $row->flg_animal_kind, 'img' => $row->img, 'micro_id' => $row->micro_id, 'age' => $row->age, 'birth' => $row->birth_n];
        }
        return ['user_pets' => $user_pets, 'weights' => $user_pets_weight];
    }


    public function update(Request $request, $animal)
    {
        if(auth()->user()->id == 11){
            $mes = ['mes' => 'デモではペット修正できません'];
            return $mes;
        }
        $this->validate($request, [
            'name' => 'required',
            'kind_name' => 'required|min:1',
            'flg_animal_kind' => 'required|min:1',
            'birth' => 'min:7|numeric',
        ]);

        // imgの処理
        if (request('img')) {
            $unique = uniqid(sprintf('%02x', random_int(0, 255)));
            $img_name = auth()->user()->id . '_' . $unique . '.png';
            request('img')->storeAs('images', $img_name);

            $img_path = storage_path('app/public/images/' . $img_name);
            $img = \Image::make($img_path);

            $img_w = $img->width();
            $img_h = $img->height();
            if ($img_w <= $img_h) {
                $img->resize(150, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->fit(100)->save();
            } else {
                $img->resize(null, 150, function ($constraint) {
                    $constraint->aspectRatio();
                })->fit(100)->save();
            }
        }

        //animal_id取得
        $user = auth()->user()->id;

        $data = Animal::find($animal);
        if ($data->user_id == $user) {
            $data->name = $request->name;
            $data->kind_name = $request->kind_name;
            $data->flg_animal_kind = $request->flg_animal_kind;
            $data->birth = $request->birth;
            if (request('img')) {
                $data->img = $img_name;
            }
            if (request('micro_id')) {
                $data->micro_id = $request->micro_id;
            }
            if ($request->flg_alive == 1) {
                $data->flg_alive = '1';
                $data->pass_age = $request->pass_age;
            } else {
                $data->flg_alive = '0';
                $data->pass_age = '';
            }
            $data->save();
        }

        $mes = ['mes' => $data->name . 'を編集しました!'];
        if ($data->save()) {
            return $mes;
        } else {
            return ['error' => '入力に誤りがあります。!'];
        }
    }



    public function destroy(Animal $animal)
    {
        $animal->delete();
        return $animal;
    }
}
