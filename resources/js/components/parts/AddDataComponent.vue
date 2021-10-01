<template>
    <div>
        <div class="flex justify-around mb-8">
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                @click="addtype = 'addweight'"
                :class="[addtype == 'addweight' ? 'bg-blue-600': 'bg-gray-500']">
                    体重
            </p>
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                @click="addtype = 'addnote'"
                :class="[addtype == 'addnote' ? 'bg-blue-600': 'bg-gray-500']">
                メモ
            </p>
            <p class="h-10 w-1/4 items-center justify-center inline-flex text-sm font-semibold text-white rounded-md" 
                @click="addtype = 'adddate'"
                :class="[addtype == 'adddate' ? 'bg-blue-600': 'bg-gray-500']">
                    日付
            </p>
        </div>

        <div class="flex justify-left mx-2 my-2 overflow-x-scroll scroll_bar">
            <div v-for="(pet, key_a) in pets" :key="key_a" class="mr-2 mb-2" style="min-width:100px">
                <label class="cats-icon relative">
                    <input type="radio" class="hidden" :value="key_a" v-model="pet_id">
                    <img :src="img_src + pet.img" class="rounded-full svg-elem-1" :class="[pet_id == key_a ? 'checked_img' : '']">
                    <span v-show="pet_id == key_a" class="absolute absolute_center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 65 46.45" width="65" height="46.45000076293945">
                            <g id="レイヤー_2" data-name="レイヤー 2">
                                <g id="レイヤー_1-2" data-name="レイヤー 1">
                                <polygon points="0 18.4 9.06 9.64 27.9 28.48 56.38 0 65 8.62 27.9 46.45 0 18.4" style="fill: rgb(0, 137, 244);" class="svg-elem-1"></polygon>
                                </g>
                            </g>
                        </svg>
                    </span>
                </label>
            </div>
        </div>


        <template v-if="addtype=='addweight'">
            <div class="mt-8 mb-8">
                <label class="block">
                    <span class="text-gray-700">体重(kg)<span class="text-red-600">(必須)</span></span>
                    <input type="number" 
                        class="form-input mt-1 block w-3/4 rounded-md" 
                        :class="[errors_weight.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
                        placeholder="例: 4.5" 
                        v-model="weight">
                </label>
                <ul v-show="!isValid_weight" class="mt-2">
                    <li v-for="error in errors_weight" :key="error.message" class="text-red-600">{{ error.message }}</li>
                </ul>
            </div>
        </template>

        <template v-if="addtype=='addnote'">
            <div class="my-8">
                <div class="mb-4">
                    <label class="block">
                        <span class="text-gray-700">タイトル<span class="text-red-600">(必須)</span></span>
                        <input type="text" 
                            class="form-input mt-1 block w-3/4 rounded-md" 
                            :class="[errors_title.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
                            placeholder="例: ○○医院のメモ" 
                            v-model="title">
                    </label>
                    <ul v-show="!isValid_title" class="mt-2">
                        <li v-for="error in errors_title" :key="error.message" class="text-red-600">{{ error.message }}</li>
                    </ul>
                </div>
                <div class="mb-4">
                    <label class="block">
                        <span class="text-gray-700">内容<span class="text-red-600">(必須)</span></span>
                        <textarea class="form-textarea mt-1 block w-full" 
                            :class="[errors_body.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
                            rows="8" 
                            placeholder="内容を入力してください" 
                            v-model="body">
                        </textarea>
                    </label>
                    <ul v-show="!isValid_body" class="mt-2">
                        <li v-for="error in errors_body" :key="error.message" class="text-red-600">{{ error.message }}</li>
                    </ul>
                </div>
                <div class="flex">
                    <label class="flex items-center">
                        <input type="checkbox" class="form-checkbox" :value="1" v-model="flg_type">
                        <span class="ml-2">病院からのメモ</span>
                    </label>
                </div>
            </div>
        </template>

        <template v-if="addtype=='adddate'">
            <div class="my-8">
                <div class="mb-4">
                    <div class="">
                        <span class="text-gray-700">項目を選択してください<span class="text-red-600">(必須)</span></span>
                        <div class="mt-4">
                            <label class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2"
                                :class="[the_title_date == option.title_date ? 'text-white bg-blue-500 ring-blue-500' : 'ring-gray-400']" 
                                v-for="option in theDateTitles" 
                                :key="option.id">
                                <input type="radio"
                                    class="form-radio hidden"
                                    :value="option.title_date" 
                                    v-model="the_title_date">
                                <span>{{option.title_date}}</span>
                            </label>
                            <label class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2" 
                                :class="[the_title_date == 'other' ? 'text-white bg-blue-500 ring-blue-500' : 'ring-gray-400']" >
                                <input type="radio" 
                                    class="form-radio hidden"
                                    value="other" 
                                    v-model="the_title_date">
                                <span>その他</span>
                            </label>
                        </div>
                    </div>
                    <div class="mt-4" v-show="the_title_date == 'other'">
                        <label class="block">
                            <span class="text-gray-700">項目を入力してください<span class="text-red-600">(必須)</span></span>
                            <input type="text" 
                                class="form-input mt-1 block w-full rounded-md"
                                :class="[errors_the_title_date_other.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
                                placeholder="例: 注射日・脱走日など" v-model="the_title_date_other">
                        </label>
                        <ul v-show="!isValid_the_title_date_other" class="mt-2">
                            <li v-for="error in errors_the_title_date_other" :key="error.message" class="text-red-600">{{ error.message }}</li>
                    </ul>
                    </div>
                </div>
                <div class="mb-4">
                    <p class="">日付を入力してください。<span class="text-red-600">(必須)</span></p>
                    <div class="my-2 flex flex-wrap">
                        <button
                            v-for="item in the_date" :key="item.index"
                            class="flex items-center bg-indigo-100 hover:bg-indigo-200 text-sm text-indigo-600 font-semibold h-8 px-2 m-1 rounded-lg border-2 border-transparent focus:border-indigo-600 focus:outline-none"
                            ref="button"
                            @click.stop="removeDate(item)">
                            {{item}}
                            <svg
                                class="w-4 h-4 text-gray-600 hover:text-indigo-600 ml-1 -mr-1"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                                stroke-width="2">
                                <path d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <div class="">
                        <v-calendar :attributes="attributes" @dayclick="onDayClick" />
                    </div>
                </div>
            </div>
        </template>
        <button @click="uploadData" type="submit" class="h-12 w-full text-sm font-semibold text-center text-white rounded-md bg-blue-600">登録する</button>
    </div>
</template>


<script>

export default {
    props: {
        pets: {
            type: Array,
        },
        theDateTitles: {
            type: Array,
        },
    },
    data: function () {
        return {
            img_src: "/storage/images/",
            addtype: "addweight",
            addComponentType: "AddAnimalComponent",
            pet_id:"0",
            weight: "",
            title: "",
            body: "",
            flg_type: "",
            the_date: [],
            the_title_date: "",
            the_title_date_other: "",
            isValid_weight: true,
            isValid_title: true,
            isValid_body: true,
            isValid_the_title_date_other: true,
            errors_weight: [], 
            errors_title: [], 
            errors_body: [], 
            errors_the_title_date_other: [], 
        }
    },
    computed: {
        vc_dates() {
            return this.the_date.map(day => day.date);
        },
        attributes() {
            return this.the_date.map(date => ({
                highlight: true,
                dates: date,
            }));
        },
    },
    watch: {
      weight: function () {
        this.errors_weight = [];
        this.isValid_weight = true;
        if (!this.validNull(this.weight, this.errors_weight) || !this.validLength(this.weight, this.errors_weight, 4, 1)) {
          this.isValid_weight = false;
        }
      },
      title: function () {
        this.errors_title = [];
        this.isValid_title = true;
        if (!this.validNull(this.title, this.errors_title) || !this.validLength(this.title, this.errors_title, 30, 2)) {
          this.isValid_title = false;
        }
      },
      body: function () {
        this.errors_body = [];
        this.isValid_body = true;
        if (!this.validNull(this.body, this.errors_body) || !this.validLength(this.body, this.errors_body, 400, 2)) {
          this.isValid_body = false;
        }
      },
      the_title_date_other: function () {
        this.errors_the_title_date_other = [];
        this.isValid_the_title_date_other = true;
        if (!this.validNull(this.the_title_date_other, this.errors_the_title_date_other) || !this.validLength(this.the_title_date_other, this.errors_the_title_date_other, 20, 1)) {
          this.isValid_the_title_date_other = false;
        }
      },
    },
    methods: {
        onDayClick(day) {
            const idx = this.the_date.findIndex(d => d.id === day.id);
            if (idx >= 0) {
                this.the_date.splice(idx, 1);
            } else {
                this.the_date.push(day.id);
                this.the_date.sort();
            }
        },
        removeDate(date) {
            this.the_date = this.the_date.filter((d) => d !== date); 
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
        validLength: function (inputdata, errors, max, min) {
            if( inputdata.length > max || inputdata.length < min ){
                if(!errors.some(error => error.message == min + "文字以上" + max + "文字以下で入力してください。" )){
                    errors.push({ message: min + "文字以上" + max + "文字以下で入力してください。" });
                }
            }
        },
        // データPOST
        uploadData() {
            let postdata = new FormData();
                postdata.append("pet_id", this.pet_id);
                if(this.addtype == 'addweight'){
                    postdata.append("addtype", "addweight");
                    postdata.append("weight", this.weight);
                }
                if(this.addtype == 'addnote'){
                    postdata.append("addtype", "addnote");
                    postdata.append("title", this.title);
                    postdata.append("body", this.body);
                    this.flg_type == 1 ? postdata.append("flg_type", 1) : postdata.append("flg_type", 0);
                }
                if(this.addtype == 'adddate'){
                    postdata.append("addtype", "adddate");
                    postdata.append("the_date", this.the_date);
                    postdata.append("the_title_date", this.the_title_date);
                    if(this.the_title_date == 'other'){
                        postdata.append("the_title_date_other", this.the_title_date_other);
                    } 
                }
            this.$emit('upload', postdata)
        },
    }
}
</script>


<style scoped>

  .scroll_bar::-webkit-scrollbar {
    display:none;
  }
  .scroll_bar {
    -ms-overflow-style: none;  /* これを追加 */
  }

  @keyframes animate-svg-fill-1 {
  0% {
    fill: transparent;
  }

  100% {
    fill: rgb(0, 137, 244);
  }
}
.svg-elem-1 {
  animation: animate-svg-fill-1 0.4s ease-in-out 0.2s both;
}
.absolute_center{
    top: 30px;
    left: 20px;
}
.checked_img{
    filter: brightness(0.5)
}
</style>