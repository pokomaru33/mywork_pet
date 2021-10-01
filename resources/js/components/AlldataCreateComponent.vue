<template>
    <div class="relative flex items-center justify-center bg-gray-200 py-4 px-4 relative items-center">
        <div class="shaddow-lg max-w-md w-full space-y-8 py-6 px-2 bg-white rounded-xl z-10">

            <p v-if="posted_message" class="border-solid h-16 flex-1 rounded-md border-4 border-indigo-500 border-opacity-100 font-extrabold text-indigo-600 flex justify-center items-center">{{posted_message}}</p>

            <div class="flex justify-around mb-6">
                <p class="h-12 w-5/12 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                    @click="addComponentType = 'AddDataComponent'"
                    :class="[addComponentType == 'AddDataComponent' ? 'bg-blue-600': 'bg-gray-500']">
                    既存家族データ追加
                </p>
                <p class="h-12 w-5/12 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                    @click="addComponentType = 'AddAnimalComponent'" 
                    :class="[addComponentType == 'AddAnimalComponent' ? 'bg-blue-600': 'bg-gray-500']">
                    家族追加
                </p>
            </div>

            <keep-alive>
                <compnent :is="addComponentType" :pets="pets" :theDateTitles="theDateTitles" @upload="uploadAfter"></compnent>
            </keep-alive>
        </div>
    </div>
</template>

<script>
import AddAnimalComponent from "./parts/AddAnimalComponent.vue";
import AddDataComponent from "./parts/AddDataComponent.vue";

export default {
    components: {
        AddAnimalComponent,
        AddDataComponent,
    },
    data: function () {
        return {
            pets: [],
            theDateTitles: [],
            addComponentType: "",
            posted_message: "",
        }
    },
    created(){
        this.getDatas();
    },
    methods: {
        // JSONデータ取得
        getDatas() {
            axios.get('/json/alldata')
            .then((res) => {
                res.data.alives.length ? this.addComponentType = "AddDataComponent" : this.addComponentType = "AddAnimalComponent";
                this.pets = res.data.alives;
                this.theDateTitles = res.data.the_date_title;
            });
        },
        uploadAfter(postdata){
            let config = {
                headers: {'content-type': 'multipart/form-data'}
            };
            axios.post("/json/alldata", postdata, config)
                .then(res => {
                    this.posted_message = res.data.mes;
                    pet_id = "0";
                })
                .catch(err => {
                    this.posted_message = err.response.data.error;
                });
            
            //スクロールトップ
            const duration = 400;  // 移動速度
            const interval = 10;    // 移動間
            const step = -window.scrollY / Math.ceil(duration / interval); // 1回の移動距離
            const timer = setInterval(() => {
                window.scrollBy(0, step);   // スクロール位置を移動
                if(window.scrollY <= 0) {
                    clearInterval(timer);
                }
            }, interval);
        }
    }
}
</script>