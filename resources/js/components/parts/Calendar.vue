<template>
  <div class="relative">
    <v-calendar
    title-position="center" 
    >
    <template slot='header-title' slot-scope='props'>
      {{props.yearLabel}}年{{props.monthLabel}}
    </template>
    <template slot='day-content' slot-scope='props'>
      <div class="cell-header">
        {{props.day.day}}
      </div>
      <div class="cell-content">
        <template v-if="dateList.some(date => date.ymd === dateToYYYYMMDD(props.day.date))">
        <div v-for="each_col in eColor" :key="each_col.color">
          <div class="cell-content-line" v-for="content in getContentFromKey(dateToYYYYMMDD(props.day.date))" :key="content">
            <span v-if="content == each_col.title" class="text-white mb-1 " :style="{background: each_col.color}" @click='showModal(dateToYYYYMMDD(props.day.date), content)' >{{content}}</span>
          </div>
        </div>
        </template>
      </div>
    </template>
    </v-calendar>
    <div id="modal_content_back" v-show="modal" @click="modal = false">
    </div>
    <div id="modal_content" v-show="modal">
        <p class="text-right">
          <button @click='closeModal()' class="p-1 my-2">
            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 24px; height: 24px; opacity: 1;" xml:space="preserve">
              <g>
                <polygon points="511.998,70.682 441.315,0 256.002,185.313 70.685,0 0.002,70.692 185.316,256.006 0.002,441.318 
                  70.69,512 256.002,326.688 441.315,512 511.998,441.318 326.684,256.006 	" style="fill: rgb(75, 75, 75);"></polygon>
              </g>
            </svg>
          </button>
        </p>
        <div>
        <p class="text-gray-700 text-lg">{{modal_get_date_show}}</p>
        <p class="text-gray-700 text-lg">{{modal_get_title}}</p>
        </div>
        <p class="overflow-hidden"><button @click='deleteItem()' class="bg-red-500 text-white p-1 my-2 w-2/5 float-right">削除</button></p>
      </div>
  </div>
</template>

<script>
export default {
  props: ['theDates', 'pets', 'pet_id', 'eColor'],
  data() {
    return {
      dateList: [],
      child_pets: [],
      modal: false,
      modal_get_date: "",
      modal_get_date_show: "",
      modal_get_title: "",
    }
  },
  created() {
  },
  watch:{
    pets(newValue){
      this.child_pets=newValue;
      let pet_id=this.pet_id;
      let petId = this.child_pets[pet_id]['id']; //16
      let arr = this.theDates[petId];
      let datalists = [];
      $.each(arr, function(key, val){
          const events = 
            {
              ymd: key,
              contents: val['title'],
              event_color: val['color'],
            }
          ;
          datalists.push(events);
      });
      this.dateList = datalists;
    },
    pet_id(newVal){
      this.dateList = [];
      let petId = this.child_pets[newVal]['id']; //16
      let arr = this.theDates[petId];
      let datalists = [];
      $.each(arr, function(key, val){
          const events = 
            {
              ymd: key,
              contents: val['title'],
              color: val['color'],
            }
          ;
          datalists.push(events);
      });
      this.dateList = datalists;
    },
  },
  methods: {
     dateToYYYYMMDD: function(date) {
      let y = date.getFullYear()
      let m = ('00' + (date.getMonth()+1)).slice(-2)
      let d = ('00' + date.getDate()).slice(-2)
      let result = y + '' + m + '' + d
      return result
    },
    getContentFromKey: function(key) {
      const target = this.dateList.find((date) => {
        return (date.ymd === key)
      });
      return target.contents;
    },
    showModal: function(select_date, select_title){
      let date_y = select_date.slice(0, 4);
      let date_m = select_date.slice(4, 6);
      let date_d = select_date.slice(6, 8);
      const y = '年';
      const m = '月';
      const d = '日';
      this.modal_get_date = select_date;
      this.modal_get_date_show = date_y + y + date_m + m + date_d + d;
      this.modal_get_title = select_title;
      this.modal = true;
    },
    closeModal: function(){
      this.modal_get_date = "";
      this.modal_get_title = "";
      this.modal = false;
    },
    deleteItem: function(){
      let postdata = new FormData();
      postdata.append("pet_id", this.pet_id);
      postdata.append("get_date", this.modal_get_date);
      postdata.append("get_title", this.modal_get_title);
      axios.post('/json/date_n_title', postdata)
        .then((res) => {
          this.$emit('afterDelDate', this.pet_id);
          this.modal_get_date = "";
          this.modal_get_date_show = "";
          this.modal_get_title = "";
          this.modal = false;
        });
    },
  },
};
</script>


<style scoped>
div.relative div.vc-container{
  width:100%;
}
.cell-content {
  text-align:left;
  padding-bottom: 2px;
  width: 13vw;
  height: 50px;
  font-size: 50%;
  /* border: 1px solid #efefef; */
}
.cell-content-line span{
  font-size: 14px;
  padding: 1px 2px;
  border-radius: 3px;
  font-weight: bold;
}
@media(max-width:520px){
  .cell-content-line span{
    font-size: 2.9vw;
  }
}

#modal_content_back{
  animation: fadeIn 0.2s ease 0s 1 normal;
  z-index:1;
  width:100%;
  height:100%;
  position: absolute;
  top:0;
  background: rgba(0,0,0,.7);
}
#modal_content{
  animation: fadeIn 0.6s ease 0s 1 normal;
  z-index:2;
  width:200px;
  height:180px;
  padding: .2em 1em 1em;
  background:#fff;
  color:gray;
    position: absolute;
    top: 46%;
    left: 50%;
    transform: translate(-50%, -50%);
    -webkit-transform: translate(-50%, -50%);
    -ms-transform: translate(-50%, -50%);
}

@keyframes fadeIn {
  0% {opacity: 0}
  100% {opacity: 1}
}
</style>
