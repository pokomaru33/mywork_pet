export const create_validation = {
    methods: {
        // JSONデータ取得
        getDatas() {
            axios.get('/json/alldata')
            .then((res) => {
                this.pets = res.data.alives;
                this.theDateTitles = res.data.the_date_title;
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
        }
    }
};