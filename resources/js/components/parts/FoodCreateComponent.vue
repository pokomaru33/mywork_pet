<template>
    <div class="py-8 px-4 mb-6 bg-gray-100">
            <div class="mb-4">
                <!-- <label class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2"
                :class="[flg_time[option.value] ? 'text-white bg-blue-500 ring-blue-500' : 'ring-gray-400']" 
                v-for="option in options_time"
                :key="option.id">
                    <input type="checkbox"
                    class="form-radio hidden"
                    :value="option.name" 
                    v-model="flg_time">
                    <span>{{option.name}}</span>
                </label>
                <div class="my-2">
                    <p>選択中の時間帯</p>
                    <p>{{flg_time}}</p>
                </div> -->

                
                <label id="create_food_01" class=" inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2 ring-gray-400" :class="{day_checked: checked_m}">
                    <input type="checkbox"
                    class="form-radio hidden"
                    value="朝" 
                    v-model="flg_time">
                    <span>朝</span>
                </label>
                <label id="create_food_02" class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2 ring-gray-400" :class="{day_checked: checked_l}">
                    <input type="checkbox"
                    class="form-radio hidden"
                    value="昼" 
                    v-model="flg_time">
                    <span>昼</span>
                </label>
                <label id="create_food_03" class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2 ring-gray-400" :class="{day_checked: checked_n}">
                    <input type="checkbox"
                    class="form-radio hidden"
                    value="夜" 
                    v-model="flg_time">
                    <span>夜</span>
                </label>
                <label id="create_food_04" class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2 ring-gray-400" :class="{day_checked: checked_o}">
                    <input type="checkbox"
                    class="form-radio hidden"
                    value="その他" 
                    v-model="flg_time">
                    <span>その他</span>
                </label>
            </div>
            <div class="mb-4">
                <label class="block">
                    <span class="text-gray-700">商品名<span class="text-red-600">(必須)</span></span>
                    <input type="text" 
                        class="form-input mt-1 block w-3/4 rounded-md" 
                        :class="[errors_name.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
                        placeholder="例: チャオチュールPURE" 
                        v-model="name">
                </label>
                <ul v-show="!isValid_name" class="mt-2">
                    <li v-for="error in errors_name" :key="error.message" class="text-red-600">{{ error.message }}</li>
                </ul>
            </div>
            <div class="mb-4">
                <label class="block">
                    <span class="text-gray-700">量(任意)</span>
                    <div class="flex">
                        <input type="number" 
                            class="form-input mt-1 block w-1/4 rounded-md mr-2" 
                            placeholder="例: 100" 
                            v-model="gram">

                        <select v-model="gram_unit">
                            <option v-for="option in options_unit" 
                                :value="option.value" 
                                :key="option.id">
                            {{ option.name }}
                            </option>
                        </select>
                    </div>
                </label>
            </div>
            <div class="mb-4">
                <label class="block">
                    <span class="text-gray-700">メモ(任意)</span>
                    <input type="text" 
                        class="form-input mt-1 block w-3/4 rounded-md" 
                        placeholder="例: 2日に1回10g" 
                        v-model="note">
                </label>
            </div>
            <button @click="upload" type="submit" class="h-12 w-full text-sm font-semibold text-center text-white rounded-md bg-blue-600">登録する</button>
    </div>
</template>
<script>
export default {
    data: function () {
        return {
            name: "",
            gram: "",
            gram_unit: "g",
            flg_time: [],
            note: "",
            isValid_name: true,
            errors_name: [],
            options_time: [
                { id: '0', name: '朝', value: 1 },
                { id: '1', name: '昼', value: 2 },
                { id: '2', name: '夜', value: 3 },
                { id: '3', name: 'その他', value: 4 },
            ],
            options_unit: [
                { id: '0', name: 'グラム', value: 'g' },
                { id: '1', name: 'ミリリットル', value: 'ml' },
                { id: '2', name: '個', value: '個' },
            ], 
            checked_m: false,
            checked_l: false,
            checked_n: false,
            checked_o: false,
        }
    },
    watch: {
      name: function () {
        this.errors_name = [];
        this.isValid_name = true;
        if (!this.validNull(this.name, this.errors_name)) {
          this.isValid_name = false;
        }
      },
      flg_time: function(){
          this.flg_time.includes('朝') ? this.checked_m = true: this.checked_m = false;
          this.flg_time.includes('昼') ? this.checked_l = true: this.checked_l = false;
          this.flg_time.includes('夜') ? this.checked_n = true: this.checked_n = false;
          this.flg_time.includes('その他') ? this.checked_o = true: this.checked_o = false;
      }
    },
    methods: {
        upload(){
            let postdata = new FormData();
            postdata.append("name", this.name);
            if(this.gram && this.gram_unit){
                if(this.gram_unit == 'g' || this.gram_unit == '個' || this.gram_unit == 'ml'){
                    postdata.append("gram", this.gram + this.gram_unit);
                }
            }
            if(this.note){
                postdata.append("note", this.note);
            }
            if(this.flg_time){
                postdata.append("flg_time", this.flg_time);
            }
            let config = {
                headers: {'content-type': 'multipart/form-data'}
            };
            axios.post("/json/foods", postdata, config)
                .then(res => {
                    this.$emit('uploaded');
                })
                .catch(err => {
                    this.posted_message = "エラー";
                });
        },
        // 入力直後のバリデーションチェック
        validNull: function (inputdata, errors) {
            let result = true;
            if (!inputdata) {
                if(!errors.some(error => error.message == "入力してください。")){
                    errors.push({ message: "入力してください。" });
                    result = false;
                }
            }
            return result;
        },
    }
}
</script>

<style scope>
.day_checked{
    color: rgba(255, 255, 255);
    background: rgba(59, 130, 246);
    border: 1px solid rgba(59, 130, 246) !important;
}
</style>