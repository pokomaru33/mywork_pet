<template>
    <div class="relative min-h-screen flex items-center justify-center bg-gray-200 py-4 px-4 relative items-center">
        <div class="shaddow-lg max-w-md w-full space-y-8 p-6 bg-white rounded-xl z-10">
            <div class="flex justify-left mx-2 mt-6 overflow-x-scroll scroll_bar">
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
            <button @click="upload" type="submit" class="h-12 w-full text-sm font-semibold text-center text-white rounded-md bg-blue-600">編集する</button>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        getId: Number
    },
    data: function () {
        return {
            pets: [],
            img_src: "/storage/images/",
            pet_id: "",
            title: "",
            body: "",
            flg_type: false,
            isValid_note: true,
            errors_note: [], 
        }
    },
    created(){
        this.getDatas();
    },
    watch: {
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
    },
    methods: {
        // JSONデータ取得
        getDatas() {
            axios.get('/json/alldata/')
            .then((resPets) => {
                this.pets = resPets.data.alives;

                axios.get('/json/note/' + this.getId)
                .then((resNote) => {
                    this.title = resNote.data.title;
                    this.body = resNote.data.body;
                    this.flg_type = resNote.data.flg_type == 1 ? true : false ;

                    //pet_idに初期値を入れる
                    const pets = resPets.data.alives;
                    const get_petId = resNote.data.animal_id;
                    for(let i = 0; i<pets.length; i++ ){
                        let pets_id =  pets[i]['id'];
                        if(get_petId == pets_id){
                            this.pet_id = i;
                        }
                    }
                });
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
        validLength: function (inputdata, errors, max, min) {
            if( inputdata.length > max || inputdata.length < min ){
                if(!errors.some(error => error.message == min + "文字以上" + max + "文字以下で入力してください。" )){
                    errors.push({ message: min + "文字以上" + max + "文字以下で入力してください。" });
                }
            }
        },
        // データPOST
        upload() {
            let postdata = new FormData();
            postdata.append("id", this.getId);
            postdata.append("pet_id", this.pet_id);
            postdata.append("title", this.title);
            postdata.append("body", this.body);
            this.flg_type == 1 ? postdata.append("flg_type", 1) : postdata.append("flg_type", 0);
            let config = {
                headers: {'content-type': 'multipart/form-data'}
            };
            axios.post("/json/note/" + this.getId, postdata, config)
                .then(res => {
                    this.$router.push({name: 'alldata'});
                })
                .catch(err => {
                    this.posted_message = '編集に失敗しました。';
                });
        },
    }
}
</script>

<style scope>
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
button:focus{
    outline: none !important;
}
</style>