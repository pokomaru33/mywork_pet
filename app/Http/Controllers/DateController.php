<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use App\Models\Animal;
use App\Models\Thedate;
use App\Models\Thedatetitle;
use App\Models\Thedate_thedatetitle;
use Carbon\Carbon;

class DateController extends Controller
{
    //
    public function destroy(Request $request, Thedate $thedate)
    {
        if ($request->get_date) {

            $user = auth()->user()->id;
            $user_pets_alive = Animal::where('user_id', $user)->where('flg_alive', 0)->get();

            // //選択中のペットIDを取得
            $get_pet_id = $user_pets_alive[$request->pet_id]->id;

            // //受け取った日付にハイフン入れる
            $the_date = Carbon::createFromFormat('Ymd', $request->get_date)->format('Y-m-d');

            // //DBから選択されたタイトルのIDを取得
            $DB_the_title = Thedatetitle::where('title_date', $request->get_title)->get();
            $the_title_id = $DB_the_title[0]->id;

            $the_date = Thedate::where('animal_id', $get_pet_id)->where('the_date', $the_date)->get();

            foreach ($the_date as $key => $val) {
                $the_between_db = DB::table('thedate_thedatetitle')->where('thedate_id', $val['id'])->get();
                if ($the_between_db[0]->thedatetitle_id == $the_title_id) {

                    DB::table('thedate_thedatetitle')->where('thedate_id', $val['id'])->where('thedatetitle_id', $the_between_db[0]->thedatetitle_id)->delete();
                    Thedate::where('id', $val['id'])->delete();
                    $mes = 'けせた';
                } else {
                    $mes = '失敗';
                }
            }
            return $mes;
        }
    }
}
