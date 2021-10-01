<template>
    <div class="container px-4 py-6">
        <div class="flex items-center justify-left mt-4 mb-4">
            <h2 class="text-3xl leading-6 font-medium text-black mr-2">FOODS</h2>
            <button class="hover:bg-blue-200 hover:text-blue-800 group flex items-center rounded-md bg-blue-100 text-blue-600 text-sm font-medium px-4 py-2" @click="create_field = !create_field">
            <svg class="group-hover:text-blue-600 text-blue-500 mr-2" width="12" height="20" fill="currentColor">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M6 5a1 1 0 011 1v3h3a1 1 0 110 2H7v3a1 1 0 11-2 0v-3H2a1 1 0 110-2h3V6a1 1 0 011-1z"/>
            </svg>
            New
            </button>
        </div>
        <FoodCreateComponent v-show="create_field"  @uploaded="getDatas"></FoodCreateComponent>


        <div class="flex justify-around mb-8">
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md mr-1" 
                @click="flg_times = '朝'"
                :class="[flg_times == '朝' ? 'bg-blue-600': 'bg-gray-500']">
                朝
            </p>
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md mr-1" 
                @click="flg_times = '昼'"
                :class="[flg_times == '昼' ? 'bg-blue-600': 'bg-gray-500']">
                昼
            </p>
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md mr-1" 
                @click="flg_times = '夜'"
                :class="[flg_times == '夜' ? 'bg-blue-600': 'bg-gray-500']">
                    夜
            </p>
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                @click="flg_times = 'その他'"
                :class="[flg_times == 'その他' ? 'bg-blue-600': 'bg-gray-500']">
                    その他
            </p>
        </div>
        <div class="mt-6 mb-10">
            <template>
                <div class="intro-y overflow-auto lg:overflow-visible mt-8 sm:mt-0">
                    <table class="table table-report sm:mt-2">
                        <thead>
                            <tr>
                                <th class="whitespace-nowrap text-gray-700 text-lg pb-4">イメージ</th>
                                <th class="whitespace-nowrap text-left pl-3 text-gray-700 text-lg pb-4">名前(コメント)</th>
                                <th class="text-center whitespace-nowrap text-gray-700 px-6 text-lg pb-4">量</th>
                                <th class="text-center whitespace-nowrap text-gray-700 text-lg pb-4">削除</th>
                            </tr>
                        </thead>
                        <tbody>
                        <template v-for="food in foods">
                            <tr :key="food.food_id" v-if="food.food_time.includes(flg_times)" class="intro-x">
                                <td class="pb-3">
                                    <img :src="food.yahoo.itemImg" style="width:100px">
                                </td>
                                <td class="pl-3 pb-3">
                                    <p class="font-medium whitespace-nowrap">{{food.food_name}}</p>
                                    <p class="text-gray-600 text-xs whitespace-nowrap mt-0.5">{{food.food_note}}</p>
                                </td>
                                <td class="text-center pb-3">{{food.food_gram}}</td>
                                <td class="pb-3">
                                    <button @dblclick="delFood(food.food_id)" class="h-8 w-20 text-xs font-semibold text-center text-white rounded-md bg-red-500 float-right">タップx2</button>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>
            </template>
        </div>
        <div class="box_shop_links">
            <h3 class="text-center bg-blue-500 text-lg py-1 text-white mb-4 rounded-md">最安値商品↓</h3>
            <template v-for="food in foods" >
            <div v-if="food.food_time.includes(flg_times)" :key="food.food_id">
                <div class="bg-white rounded-lg pt-6 pb-2 px-3 mb-6" style="box-shadow:0 0px 10px 3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)">
                    <p class="text-md font-medium text-gray-700 mb-2 py-1 text-center bg-blue-100">{{food.food_name}}</p>
                    <hooper style="height: auto" :autoPlay="true" :playSpeed="10000" infiniteScroll="true">
                        <slide>
                            <div class="flex w-full border-4 border-gray-500 border-opacity-50 rounded-lg mb-4">
                                <div class="flex-none w-28 ml-1 mt-6 relative">
                                    <img :src="food.rakuten.mediumImageUrls" alt="" class="absolute object-cover h-3/4 w-full rounded-l-sm" />
                                </div>
                                <div class="flex-auto py-6 pt-4 px-4">
                                    <h1 class="flex-auto text-md font-semibold">{{food.rakuten.itemName}}</h1>
                                    <div class="text-xl font-semibold text-gray-500">{{food.rakuten.itemPrice}}円</div>
                                    <div class="flex space-x-3 mb-4 text-sm font-medium mt-2">
                                        <a :href="food.rakuten.itemUrl" class="w-full h-10 flex items-center justify-center rounded-md bg-red-600 text-white block">楽天市場</a>
                                    </div>
                                </div>
                            </div>
                        </slide>
                        <slide>
                            <div class="flex w-full border-4 border-gray-500 border-opacity-50 rounded-lg mb-4">
                                    <div class="flex-none w-28 ml-1 mt-6 relative">
                                        <img :src="food.yahoo.itemImg" alt="" class="absolute object-cover h-3/4 w-full rounded-l-sm" />
                                    </div>
                                    <div class="flex-auto py-6 pt-4 px-4">
                                        <h1 class="flex-auto text-md font-semibold">{{food.yahoo.itemName}}</h1>
                                        <div class="text-xl font-semibold text-gray-500">{{food.yahoo.itemPrice}}円</div>
                                        <div class="flex space-x-3 mb-4 text-sm font-medium mt-2">
                                            <a :href="food.yahoo.itemUrl" class="w-full h-10 flex items-center justify-center rounded-md bg-yellow-500 text-white block">Yahooショッピング</a>
                                        </div>
                                    </div>
                            </div>
                        </slide>
                    </hooper>
                </div>
            </div>
            </template>
        </div>
  <Loading :isLoading="isLoading"></Loading>
    </div>
</template>

<script>
import Loading from './parts/Loading';
import FoodCreateComponent from "./parts/FoodCreateComponent.vue";
import{
    Hooper, 
    Slide,
}from 'hooper';
import 'hooper/dist/hooper.css';

export default {
    components: {
        FoodCreateComponent,
        Loading,
        Hooper,
        Slide,
    },
    data: function () {
        return {
            isLoading: true,
            foods: [],
            flg_times: '',
            create_field: false,
        }
    },
    created(){
        this.getDatas();
    },
    methods: {
        // JSONデータ取得
        getDatas() {
            axios.get('/json/foods').then((res) => {
                this.isLoading = true;
                this.foods = res.data[0]['foods'];
                this.create_field = false;

                res.data[0]['foods'].forEach(el => {
                    if(el['food_time'].includes(res.data[0]['nowHour'])){
                        this.flg_times = res.data[0]['nowHour'];
                    }else if(!el['food_time'].includes(res.data[0]['nowHour']) && res.data[0]['nowHour'] == '朝'){
                        this.flg_times = '昼';
                    }else if(!el['food_time'].includes(res.data[0]['nowHour']) && res.data[0]['nowHour'] == '昼'){
                        this.flg_times = '夜';
                    }else if(!el['food_time'].includes(res.data[0]['nowHour']) && res.data[0]['nowHour'] == '夜'){
                        this.flg_times = '朝';
                    }
                })
                this.isLoading = false;
            });
        },
        delFood(id) {
            let postdata = new FormData();
            postdata.append("thetime", this.flg_times);

            axios.post('/json/foods/' + id , postdata)
            .then((res) => {
                this.getDatas();
            });
        },
    }
}
</script>