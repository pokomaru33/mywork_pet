<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RakutenRws_Client;
use Illuminate\Support\Facades\DB;
use App\Models\Food;

class FoodController extends Controller
{
    //    //
    public function index()
    {
        //楽天API
        $client = new RakutenRws_Client();
        define("RAKUTEN_APPLICATION_ID", config('app.rakuten_id'));
        define("RAKUTEN_APPLICATION_SEACRET", config('app.rakuten_key'));
        define("RAKUTEN_AFFILIATED", config('app.rakuten_affiliated'));
        $client->setApplicationId(RAKUTEN_APPLICATION_ID);
        $client->setAffiliateId(RAKUTEN_AFFILIATED);


        //ユーザーのフード取得
        $user = auth()->user()->id;
        $user_foods = Food::where('user_id', $user)->get();


        $foods = [];
        foreach ($user_foods as $each) {
            //リクエストから検索キーワードを取り出し
            $keyword = $each->name;
            if (!empty($keyword)) {

                //楽天API
                $response = $client->execute('IchibaItemSearch', array(
                    'keyword' => $keyword,
                ));
                // レスポンスが正しいかを isOk() で確認することができます
                if ($response->isOk()) {
                    $rakuten_items = [];
                    $rakuten_lowest_item = [];
                    foreach ($response as $key => $item) {
                        //画像サイズを変えたかったのでURLを整形します
                        $str = str_replace("_ex=128x128", "_ex=175x175", $item['mediumImageUrls'][0]['imageUrl']);
                        $item_name_40 = mb_substr($item['itemName'], 40) . ' .....';
                        $rakuten_items[] = [
                            'itemName' => $item_name_40,
                            'itemPrice' => $item['itemPrice'],
                            'itemUrl' => $item['itemUrl'],
                            'mediumImageUrls' => $str,
                        ];
                    }
                    if ($rakuten_items) {
                        usort($rakuten_items, function ($a, $b) {
                            return $a['itemPrice'] > $b['itemPrice'];
                        });
                        $rakuten_lowest_item = $rakuten_items[0];
                    }

                    // return dd($response);
                }


                //YAHOO API
                $yahoo_id = config('app.yahoo_id');
                $yahoo_keyword = urlencode($keyword);
                $yahoo_key_product = '&query=' . $yahoo_keyword;
                $yahoo_key_sort = mb_convert_encoding('&sort=%2Bprice', 'UTF-8');
                $yahoo_url = 'https://shopping.yahooapis.jp/ShoppingWebService/V3/itemSearch?appid=' . $yahoo_id . $yahoo_key_product . $yahoo_key_sort;
                $yahoo_json = file_get_contents($yahoo_url);
                $yahoo_json = json_decode($yahoo_json, true);

                $yahoo_items = array();
                foreach ($yahoo_json['hits'] as $row) {
                    if ($row) {
                        $row_name_40 = mb_substr($row['name'], 0, 40) . ' .....';
                        $yahoo_items[] = [
                            'itemName' => $row_name_40,
                            'itemPrice' => $row['price'],
                            'itemUrl' => $row['url'],
                            'itemImg' => $row['image']['medium'],
                        ];
                    }
                }
            }
            if (!$rakuten_lowest_item) {
                $rakuten_lowest_item = '';
            }
            if (!$yahoo_items) {
                $yahoo_items[0] = '';
            }

            $foods[] = ['food_id' => $each->id, 'food_name' => $each->name, 'food_gram' => $each->gram, 'food_note' => $each->note, 'food_time' => $each->flg_time, 'rakuten' => $rakuten_lowest_item, 'yahoo' => $yahoo_items[0]];
        }
        $now = date('G');
        if ($now > 3 && $now < 12) {
            $nowHour = '朝';
        } elseif ($now >= 12 && $now < 17) {
            $nowHour = '昼';
        } else {
            $nowHour = '夜';
        }
        $alldata[] = ['foods' => $foods, 'nowHour' => $nowHour];
        return $alldata;
    }

    public function store(Request $request)
    {

        //登録
        $user = auth()->user()->id;

        $this->validate($request, [
            'name' => 'required',
            'gram' => 'max:10',
            'note' => '',
        ]);
        $data = new Food;
        $data->user_id = $user;
        $data->flg_time = $request->flg_time;
        $data->name = $request->name;
        $data->gram = $request->gram;
        $data->note = $request->note;
        $data->save();

        //登録成功メッセージ
        $mes = ['mes' => $request->food_name . 'を追加しました!'];
        if ($data->save()) {
            return $mes;
        } else {
            return ['error' => '入力に誤りがあります。!'];
        }
    }
    public function destroy(Request $request, Food $food)
    {
        //flg_timeに値が複数ある場合は特定の値のみ削除
        $times = $food['flg_time'];
        if (strpos($times, ',')) {
            $arr = explode(',', $times);
            $new_arr = [];
            foreach ($arr as $val) {
                if ($val != $request->thetime) {
                    $new_arr[] = $val;
                }
            }
            $new_times = implode(',', $new_arr);
            $user = auth()->user()->id;
            if ($user == $food->user_id) {
                // $data = Food::find($food);
                // $data->flg_time = $new_arr;
                // $data->save()
                DB::table('food')->where('id', $food->id)->update([
                    'flg_time' => $new_times
                ]);
            } else {
                $error = "失敗しました。";
            };
        } else {
            $food->delete();
        }
        return $food;
    }
}
