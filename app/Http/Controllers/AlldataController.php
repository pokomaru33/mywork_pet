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
use App\Models\Note;
use App\Models\Thedate;
use App\Models\Thedatetitle;


class AlldataController extends Controller
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
        $user_pets = Animal::where('user_id', $user)->get();

        //ユーザーの生きているペット取得
        $user_pets_alive = Animal::where('user_id', $user)->where('flg_alive', 0)->get();

        //ユーザーの生きているペットの体重取得
        $user_pets_weight = [];
        foreach ($user_pets_alive as $each) {
            $id = $each->id;
            $user_pets_weight[] = Weight::where('animal_id', $id)->get();
        }
        date_arrange($user_pets_weight);

        //ユーザーの生きているペットの体重取得
        $user_pets_weight_r = [];
        foreach ($user_pets_alive as $each) {
            $id = $each->id;
            $user_pets_weight_r[] = Weight::latest()->where('animal_id', $id)->get();
        }
        date_arrange($user_pets_weight_r);

        //ユーザーの生きているペットのメモ取得
        $user_pets_note = [];
        foreach ($user_pets_alive as $each) {
            $id = $each->id;
            $user_pets_note[] = Note::where('animal_id', $id)->get();
        }
        date_arrange($user_pets_note);


        //ユーザーの生きているペットの日付取得
        $user_pets_alldate = [];
        foreach ($user_pets_alive as $each) {
            $id = $each->id;
            $user_pets_alldate[] = DB::table('thedates')
                ->join('thedate_thedatetitle', 'thedates.id', '=', 'thedate_thedatetitle.thedate_id')
                ->join('thedatetitles', 'thedate_thedatetitle.thedatetitle_id', '=', 'thedatetitles.id')
                ->where('animal_id', $id)
                ->get();
        }

        //eventの色分け
        $colors = ['navy', 'teal', 'green', 'red', 'olive', 'orange', 'purple', 'maroon'];

        //eventと色の配列
        $event_n_color = [];
        $theEvent = Thedatetitle::all();
        foreach ($theEvent as $key => $aEvent) {
            $event_n_color[] = ['title' => $aEvent->title_date, 'color' => $colors[$key]];
        }

        $user_pets_date = [];
        foreach ($user_pets_alldate as $row) {
            foreach ($row as $each) {
                $user_pets_date[$each->animal_id][] = ['animal_id' => $each->animal_id, 'the_date' => $each->the_date, 'title' => $each->title_date];
            }
        }


        //colorを配列に追加
        $user_pets_date_c = [];
        $sort_arr_date = [];
        foreach ($user_pets_date as $main_c) {
            foreach ($main_c as $main) {
                foreach ($event_n_color as $sub) {
                    if ($main['title'] == $sub['title']) {
                        if ($main['the_date']) {
                            //日付をカレンダー用へ
                            $calendar_date = Carbon::createFromFormat('Y-m-d', $main['the_date'])->format('Ymd');

                            $sort_arr_date[$main['animal_id']][] = ['the_date' => $calendar_date];
                            //日付の登録があるかチェック
                            // 登録があればtitleを追加
                            //　無ければ日付
                            if (isset($user_pets_date_c[$main['animal_id']][$calendar_date])) {
                                array_push($user_pets_date_c[$main['animal_id']][$calendar_date]['title'], $sub['title']);
                            } else {
                                $user_pets_date_c[$main['animal_id']][$calendar_date] = ['the_date' => $calendar_date, 'title' => [$sub['title']]];
                            }
                        }
                    }
                }
            }
        }


        $all_pets_data = ['alives' => $user_pets_alive, 'weights' => $user_pets_weight, 'weights_r' => $user_pets_weight_r, 'notes' => $user_pets_note, 'dates' => $user_pets_date_c, 'the_date_title' => $theEvent, 'event_color' => $event_n_color];

        return $all_pets_data;
    }

    public function store(Request $request)
    {

        //登録
        $user = auth()->user()->id;

        $get_pet_id = request('pet_id');
        if (isset($get_pet_id)) {
            $user_pets_alive = Animal::where('user_id', $user)->where('flg_alive', 0)->get();
            $animal_id = $user_pets_alive[$request['pet_id']]->id;
            $animal_name = $user_pets_alive[$request['pet_id']]->name;
        }

        if ($request->addtype == 'addweight') {
            $this->validate($request, [
                'pet_id' => 'required|numeric',
                'weight' => 'required|max:5|min:1',
            ]);
            $data = new Weight;
            $data->animal_id = $animal_id;
            $data->weight = $request->weight;
            $data->save();

            //登録成功メッセージ
            $mes = ['mes' => $animal_name . 'の体重を登録しました!'];
        }

        if ($request->addtype == 'addnote') {
            $this->validate($request, [
                'pet_id' => 'required|numeric',
                'title' => 'required|max:30',
                'body' => 'required|max:200',
            ]);
            $data = new Note;
            $data->animal_id = $animal_id;
            $data->title = $request->title;
            $data->body = $request->body;
            $data->flg_type = $request->flg_type;
            $data->save();

            //登録成功メッセージ
            $mes = ['mes' => $animal_name . 'のメモを登録しました!'];
        }

        if ($request->addtype == 'adddate') {

            $this->validate($request, [
                'pet_id' => 'required|numeric',
                'the_date' => 'required',
                'the_title_date' => 'required',
            ]);

            // 日付追加(複数選択可)
            $the_date_arr = explode(',', $request->the_date);
            for ($i = 0; $i < count($the_date_arr); $i++) {
                $data = new Thedate();
                $data->animal_id = $animal_id;
                $data->the_date = $the_date_arr[$i];
                $data->save();
            }

            // その他選択でタイトル登録
            if ($request->the_title_date == 'other') {
                $data_2 = new Thedatetitle;
                $data_2->title_date = $request->the_title_date_other;
                $data_2->save();
            }

            //最新のcreated_at取得、
            $thedate_latest = Thedate::latest()->first()->get();
            foreach ($thedate_latest as $item_date) {
                $thedate_latest_created_at = $item_date->created_at;
            }
            //その日付と同じもののIDを配列で取得
            $arr_latest_dates = Thedate::where('created_at', $thedate_latest_created_at)->get();
            $arr_latest_date_id = [];
            foreach ($arr_latest_dates as $item_date) {
                $arr_latest_date_id[] = $item_date->id;
            }
            //thedatetitle取得
            if ($request->the_title_date == 'other') {
                $thedatetitle = Thedatetitle::where('title_date', $request->the_title_date_other)->get();
            } else {
                $thedatetitle = Thedatetitle::where('title_date', $request->the_title_date)->get();
            }
            foreach ($thedatetitle as $item_title) {
                $thetitle_latest_id = $item_title->id;
            }
            //多対多で入れ込み
            foreach ($arr_latest_date_id as $latest_date_id) {
                $theDate = TheDate::find($latest_date_id);
                $theDate->thedatetitle()->attach($thetitle_latest_id);
            }

            //登録成功メッセージ
            $mes = ['mes' => $animal_name . 'の日付を登録しました!'];
        }

        if ($request->addtype == 'addanimal') {

            //demo
            if ($user == 11) {
                $mes = ['mes' => 'デモではペットの登録はできません。'];
                return $mes;
            } 

            $this->validate($request, [
                'name' => 'required',
                'kind_name' => 'required|min:1',
                'flg_animal_kind' => 'required|min:1',
                'img' => '',
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
                $img = $img_name;
            } else {
                $img = 'no_petimg.png';
            }
            $data = new Animal;
            $data->user_id = $user;
            $data->img = $img;
            $data->name = $request->name;
            $data->kind_name = $request->kind_name;
            $data->flg_animal_kind = $request->flg_animal_kind;
            $data->micro_id = $request->micro_id;
            $data->birth = $request->birth;
            if ($request->flg_alive == 1) {
                $data->flg_alive = '1';
                $data->pass_age = $request->pass_age;
            } else {
                $data->flg_alive = '0';
            }
            $data->save();

            // 登録成功メッセージ
            $mes = ['mes' => $data->name . 'を登録しました!'];
        }

        if ($data->save()) {
            return $mes;
        } else {
            return ['error' => '入力に誤りがあります。!'];
        }
    }
}
