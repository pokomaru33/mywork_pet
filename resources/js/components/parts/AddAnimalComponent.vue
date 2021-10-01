<template>
  <div>
    <div class="my-8">
      <div class="mb-8">
        <label class="block">
          <span class="text-gray-700">お名前<span class="text-red-600">(必須)</span></span>
          <input type="text" 
            class="form-input mt-1 block w-full rounded-md" 
            :class="[errors_animal_name.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
            placeholder="例: たろう" 
            v-model="animal_name">
        </label>
        <ul v-show="!isValid_animal_name" class="mt-2">
          <li v-for="error in errors_animal_name" :key="error.message" class="text-red-600">{{ error.message }}</li>
        </ul>
      </div>
      <div class="mb-8">
        <label class="block">
          <span class="text-gray-700">種別<span class="text-red-600">(必須)</span></span>
          <input type="text" 
            class="form-input mt-1 block w-full rounded-md" 
            :class="[errors_kind_name.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
            placeholder="例: チワワ、マンチカン、雑種など" 
            v-model="kind_name">
        </label>
        <ul v-show="!isValid_kind_name" class="mt-2">
          <li v-for="error in errors_kind_name" :key="error.message" class="text-red-600">{{ error.message }}</li>
        </ul>
      </div>
      <div class="mb-8">
        <div>
          <span class="text-gray-700">種類を選択してください<span class="text-red-600">(必須)</span></span>
          <div class="mt-4">
            <label class="inline-flex items-center ring-2 rounded-sm mr-2 mb-2 py-1 px-2"
              :class="[flg_animal_kind == option.value ? 'text-white bg-blue-500 ring-blue-500' : 'ring-gray-400']" 
              v-for="option in options_flg_animal_kind"
              :key="option.id">
              <input type="radio"
                class="form-radio hidden"
                :value="option.value" 
                v-model="flg_animal_kind">
              <span>{{option.name}}</span>
            </label>
          </div>
        </div>
        <div class="mt-4" v-show="flg_animal_kind == 'other'">
          <label class="block">
            <span class="text-gray-700">種類を入力してください<span class="text-red-600">(必須)</span></span>
            <input type="text" 
              class="form-input mt-1 block w-full rounded-md"
              :class="[errors_flg_animal_kind_other.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
              placeholder="例: ハムスター、モモンガなど" v-model="flg_animal_kind_other">
          </label>
          <ul v-show="!isValid_flg_animal_kind_other" class="mt-2">
            <li v-for="error in errors_flg_animal_kind_other" :key="error.message" class="text-red-600">{{ error.message }}</li>
          </ul>
        </div>
      </div>
      <div class="mb-8">
        <span class="text-gray-700 block mb-1">写真をアップロード(任意)</span>
        <div class="box_label_img">
          <label class="block label_img">
            <input type="file" @change="confirmImg" ref="imgPreview">
            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 90px; height: 90px; opacity: 1;" xml:space="preserve">
              <g>
                <path d="M0,45.178v421.644h512V45.178H0z M471.841,426.662H40.159V85.329h431.682V426.662z" style="fill: rgb(75, 75, 75);"></path>
                <path d="M326.128,207.728c-4.148-6.289-11.183-10.077-18.72-10.069c-7.544,0.007-14.57,3.803-18.71,10.1
                  l-72.226,109.914l-39.862-45.178c-4.619-5.238-11.426-8.022-18.397-7.52c-6.971,0.486-13.308,4.211-17.142,10.053L74.17,376.96
                  h363.659L326.128,207.728z" style="fill: rgb(75, 75, 75);"></path>
                <path d="M174.972,230.713c25.102,0,45.453-20.35,45.453-45.461c0-25.102-20.35-45.452-45.453-45.452
                  c-25.11,0-45.46,20.35-45.46,45.452C129.511,210.363,149.862,230.713,174.972,230.713z" style="fill: rgb(75, 75, 75);"></path>
              </g>
            </svg>
          </label>
          <p v-if="confirmedImg" class="pl-4">
            <img class="object-cover rounded-full" style="width:100px; height:100px" :src="confirmedImg" />
          </p>
        </div>
        <p class="text-red-500 mt-2" v-if="error_img">{{ error_img }}</p>

      </div>
      <div class="mb-8">
        <label class="block">
          <span class="text-gray-700">マイクロチップID(任意)</span>
          <input type="text" 
            class="form-input mt-1 block w-full rounded-md focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600" 
            placeholder="例: vjoivvdneo" 
            v-model="microId">
        </label>
      </div>
      <div class="mb-8">
        <label class="block">
          <span class="text-gray-700">誕生日・家族になった日(数字8桁のみ・ハイフンなし)<span class="text-red-600">(必須)</span></span>
          <input type="number" 
            class="form-input mt-1 block w-full rounded-md" 
            :class="[errors_birth.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
            placeholder="例: 20190101" 
            v-model="birth">
        </label>
        <ul v-show="!isValid_birth" class="mt-2">
          <li v-for="error in errors_birth" :key="error.message" class="text-red-600">{{ error.message }}</li>
        </ul>
      </div>
      <div class="flex mb-2">
        <label class="flex items-center">
          <input type="checkbox" class="form-checkbox" :value="1" v-model="flg_alive">
          <span class="ml-2">お亡くなりの場合チェック</span>
        </label>
      </div>
      <div class="mb-8" v-show="flg_alive == 1">
        <label class="block">
          <span class="text-gray-700">お亡くなりになられた年齢<span class="text-red-600">(必須)</span></span>
          <input type="number" 
            class="form-input mt-1 block w-1/4 rounded-md" 
            :class="[errors_pass_age.length ? 'focus:border-red-500 focus:text-red-500 border-red-500 text-red-500 focus:ring-0' : 'focus:ring-1 focus:border-blue-500 focus:text-blue-500 border-gray-500 text-blue-600']"
            placeholder="例: 18" 
            v-model="pass_age">
        </label>
        <ul v-show="!isValid_pass_age" class="mt-2">
          <li v-for="error in errors_pass_age" :key="error.message" class="text-red-600">{{ error.message }}</li>
        </ul>
      </div>
    </div>

    <button @click="uploadAnimal" type="submit" class="h-12 w-full text-sm font-semibold text-center text-white rounded-md bg-blue-600">登録する</button>
  </div>
</template>

<script>
export default {
  data: function() {
    return {
      animal_name: '',
      kind_name: '',
      flg_animal_kind: '',
      flg_animal_kind_other: '',
      img: '',
      confirmedImg: '',
      error_img: '',
      microId: '',
      birth: '',
      pass_age: '',
      flg_alive: '',
      isValid_animal_name: true,
      isValid_kind_name: true,
      isValid_flg_animal_kind_other: true,
      isValid_birth: true,
      isValid_pass_age: true,
      errors_animal_name: [], 
      errors_kind_name: [], 
      errors_flg_animal_kind_other: [], 
      errors_pass_age: [], 
      errors_birth: [], 
      

      options_flg_animal_kind: [
        { id: '0', name: 'ネコ', value: 'cat' },
        { id: '1', name: 'イヌ', value: 'dog' },
        { id: '2', name: 'ウサギ', value: 'rabbit' },
        { id: '3', name: 'トリ', value: 'bird' },
        { id: '4', name: 'カメ', value: 'turtle' },
        { id: '5', name: 'その他', value: 'other' },
      ],
    };
  },
  watch: {
    animal_name: function () {
      this.errors_animal_name = [];
      this.isValid_animal_name = true;
      if (!this.validNull(this.animal_name, this.errors_animal_name) || !this.validLength(this.animal_name, this.errors_animal_name, 20, 1)) {
        this.isValid_animal_name = false;
      }
    },
    kind_name: function () {
      this.errors_kind_name = [];
      this.isValid_kind_name = true;
      if (!this.validNull(this.kind_name, this.errors_kind_name) || !this.validLength(this.kind_name, this.errors_kind_name, 30, 1)) {
        this.isValid_kind_name = false;
      }
    },
    flg_animal_kind_other: function () {
      this.errors_flg_animal_kind_other = [];
      this.isValid_flg_animal_kind_other = true;
      if (!this.validNull(this.flg_animal_kind_other, this.errors_flg_animal_kind_other) || !this.validLength(this.flg_animal_kind_other, this.errors_flg_animal_kind_other, 20, 1)) {
        this.isValid_flg_animal_kind_other = false;
      }
    },
    birth: function () {
      this.errors_birth = [];
      this.isValid_birth = true;
      if (!this.validNull(this.birth, this.errors_birth) || !this.validLengthJust(this.birth, this.errors_birth, 8)) {
        this.isValid_birth = false;
      }
    },
    pass_age: function () {
      this.errors_pass_age = [];
      this.isValid_pass_age = true;
      if (!this.validNull(this.pass_age, this.errors_pass_age) || !this.validLength(this.pass_age, this.errors_pass_age, 3, 1)) {
        this.isValid_pass_age = false;
      }
    },
  },
  methods: {
    confirmImg(e) {
      this.message = '';
      this.img = e.target.files[0];
      this.confirmedImg = URL.createObjectURL(e.target.files[0]);
      if (!this.img.type.match("image.*")) {
          this.error_img = "画像ファイルを選択して下さい";
          this.confirmedImg = "";
          return;
      }
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
    validLengthJust: function (inputdata, errors, limit) {
      if( inputdata.length != limit ){
        if(!errors.some(error => error.message == limit + "文字で入力してください。" )){
          errors.push({ message: limit + "文字で入力してください。" });
        }
      }
    },
    // データPOST
    uploadAnimal() {
      let postdata = new FormData();
        postdata.append("addtype", "addanimal");
        postdata.append("name", this.animal_name);
        postdata.append("kind_name", this.kind_name);
        postdata.append("img", this.img);
        postdata.append("birth", this.birth);
        if(this.microId){
          postdata.append("micro_id", this.microId);
        }
        this.flg_animal_kind == 'other' ? postdata.append("flg_animal_kind", this.flg_animal_kind_other) : postdata.append("flg_animal_kind", this.flg_animal_kind);
        this.flg_alive == 1 ? postdata.append("flg_alive", 1) : postdata.append("flg_alive", 0);
        if(this.flg_alive == 1){
          postdata.append("pass_age", this.pass_age);
        };

        this.$emit('upload', postdata)

    },
  },
};
</script>

<style scoped>
.box_label_img{
  display: flex;
}
.label_img{
  cursor: pointer;
}
.label_img input[type="file"]{
  display: none;
}

</style>
