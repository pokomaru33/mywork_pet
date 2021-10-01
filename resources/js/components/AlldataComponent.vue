<template>
  <div class="container">
    <div class="flex justify-left mx-2 mt-6 overflow-x-scroll scroll_bar">
      <div v-for="(pet, key_a) in pets" :key="key_a" class="mr-2 mb-2" style="min-width:100px">
        <label class="cats-icon relative">
          <input type="radio" class="hidden" :value="key_a" v-model="pet_id" />
          <img
            :src="img_src + pet.img"
            class="rounded-full svg-elem-1"
            :class="[pet_id == key_a ? 'checked_img' : '']"
          />
          <span v-show="pet_id == key_a" class="absolute absolute_center">
            <svg
              xmlns="http://www.w3.org/2000/svg"
              viewBox="0 0 65 46.45"
              width="65"
              height="46.45000076293945"
            >
              <g id="" data-name="">
                  <polygon
                    points="0 18.4 9.06 9.64 27.9 28.48 56.38 0 65 8.62 27.9 46.45 0 18.4"
                    style="fill: rgb(0, 137, 244);"
                    class="svg-elem-1"
                  ></polygon>
              </g>
            </svg>
          </span>
        </label>
      </div>
    </div>
    <hooper :settings="hooperSettings" style="height: auto">
      <hooper-navigation slot="hooper-addons"></hooper-navigation>
      <slide>
        <h3 class="text-center w-3/5 bg-gray-100 py-2 rounded" style="margin: 30px auto;">
          体重データ
        </h3>
        <div class="my-8 mx-2 small">
          <line-chart
            :chart-data="datacollection"
            :option="options"
            :styles="myChartStyle"
          ></line-chart>
        </div>

        <div class="border-2 border-gray-400 weight_table_box">
          <p class="text-center pt-2">編集する項目を選択してください</p>
          <template v-for="(eachweights, key_w) in weights_r">
            <div :key="key_w" class="weight_table scroll_bar px-8">
              <table v-if="key_w == pet_id">
                  <tr v-for="(weight, key_ww) in eachweights" :key="key_ww" class="hover:bg-blue-300">
                    <th scope="">
                      <router-link v-bind:to="{ name: 'weight.edit', params: { getId: weight.id }}" class="text-lg text-gray-700">
                        {{ weight.newdate }}
                      </router-link>
                    </th>
                    <td class="pl-4">
                      <router-link v-bind:to="{ name: 'weight.edit', params: { getId: weight.id }}" class="text-gray-700">
                        {{ weight.weight }}
                      </router-link>
                    </td>
                  </tr>
              </table>
            </div>
          </template>
        </div>
      </slide>
      <slide>
        <h3 class="text-center w-3/5 bg-gray-100 py-2 rounded" style="margin: 30px auto;">メモ</h3>
        <div v-for="(eachnotes, key_n) in notes" :key="eachnotes.id" class="mx-2">
          <table class="mx-auto w-full table-auto" v-if="key_n == pet_id">
            <thead class="thead-light">
              <tr class="border-b-2 border-primary-green">
                <th scope="col" class="py-2 text-lg w-40">日付</th>
                <th scope="col" class="py-2 text-lg">タイトル</th>
              </tr>
            </thead>
            <tbody class="">
              <tr v-for="(note, key_nn) in eachnotes" :key="key_nn">
                <td scope="row" class="text-lg pt-2"><router-link v-bind:to="{ name: 'note.show', params: { getId: note.id } }">{{ note.newdate }}</router-link></td>
                <td class="focus:bg-blue-200 text-lg pt-2">
                  <router-link v-bind:to="{ name: 'note.show', params: { getId: note.id } }">{{
                    note.title
                  }}</router-link>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </slide>
      <slide>
        <h3 class="text-center w-3/5 bg-gray-100 py-2 rounded" style="margin: 30px auto;">
          出来事カレンダー
        </h3>
        <div class="my-8 mx-2">
          <Calendar :theDates="theDates" :pet_id="pet_id" :pets="pets" :eColor="eColor" @afterDelDate="getDatas" />
        </div>
      </slide>
    </hooper>
  <Loading :isLoading="isLoading"></Loading>
  </div>
</template>

<script>
import Loading from './parts/Loading';
import Calendar from './parts/Calendar';
import LineChart from './parts/GraphLine';
import { Hooper, Slide, Navigation as HooperNavigation } from 'hooper';
import 'hooper/dist/hooper.css';

export default {
  components: {
    Loading,
    Calendar,
    LineChart,
    Hooper,
    Slide,
    HooperNavigation,
  },
  data: function() {
    return {
      isLoading: true,
      pets: [],
      weights: [],
      weights_r: [],
      notes: [],
      theDates: [],
      eColor: [],
      img_src: 'storage/images/',
      pet_id: null,
      datacollection: null,
      chart_width: '',
      options: {
        legend: {
          display: false,
        },
        scales: {
          bounds: 'ticks',
          yAxes: [
            {
              ticks: {
                beginAtZero: true,
              },
            },
          ],
        },
      },
      hooperSettings: {
        centerMode: true,
        touchDrag: false,
        mouseDrag: false,
      },
    };
  },
  created() {
    this.getDatas(0);
  },
  watch: {
    pet_id(newVal) {
      let get_labels = [];
      let get_weight = [];
      $.each(this.weights[newVal], function(key, val) {
        get_labels.push(val.newdate);
        get_weight.push(val.weight);
      });
      const chart_width_num = get_labels.length * 50 + 60;
      if (chart_width_num < 300) {
        this.chart_width = 300;
      } else {
        this.chart_width = chart_width_num;
      }
      this.datacollection = '';
      this.datacollection = {
        labels: get_labels,
        datasets: [
          {
            // lineTension: 0,
            borderColor: 'orange',
            backgroundColor: 'rgba(255,165,0,0.2)',
            label: 'Data One',
            data: get_weight,
          },
        ],
      };
    },
  },
  methods: {
    getDatas(id) {
      axios.get('/json/alldata').then(res => {
        if(!res.data.alives.length){
          return this.$router.push({name: 'alldata.create'});
        }
        this.isLoading = true;
        this.pets = res.data.alives;
        this.weights = res.data.weights;
        this.weights_r = res.data.weights_r;
        this.notes = res.data.notes;
        this.theDates = res.data.dates;
        this.eColor = res.data.event_color;
        this.pet_id = id;
        
        this.isLoading = false;
      });
    },
    delDate(id) {
      axios.delete('/json/date/' + id).then(res => {
        this.getDatas(this.pet_id);
      });
    },
  },
  computed: {
    myChartStyle() {
      return {
        width: `${this.chart_width}px`,
        position: 'relative',
      };
    },
  },
};
</script>



<style scoped>
label.cats-icon input:checked + label.cats-icon img {
  filter: drop-shadow(2px 4px 6px black);
}
.small {
  display: block;
  overflow: scroll;
  white-space: nowrap;
  background-color: rgba(0, 0, 0, 0.1);
  padding: 10px;
  border-radius: 16px;
}
.scroll_bar::-webkit-scrollbar {
  display: none;
}
.scroll_bar {
  -ms-overflow-style: none; /* これを追加 */
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
.absolute_center {
  top: 30px;
  left: 20px;
}
.checked_img {
  filter: brightness(0.5);
}
button:focus {
  outline: none !important;
}

.weight_table_box{
  height:160px;
  width:280px;
  margin: 0 auto 20px;
  position: relative;
}
.weight_table{
  height:120px;
  overflow-y: scroll;
  position: absolute;
  top: 40px;
}
</style>
