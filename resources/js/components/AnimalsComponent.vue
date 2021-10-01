<template>
    <div class="container relative" ref="conteiner">
        <div class="overflow-x-scroll px-4 py-6">
            <table class="mx-auto table-auto" style="width:800px">
                <thead class="thead-light">
                <tr class="border-b-2 border-primary-green">
                    <th scope="col" class="py-2" style="width:102px"></th>
                    <th scope="col" class="py-2 text-center">名前</th>
                    <th scope="col" class="py-2 text-center">種</th>
                    <th scope="col" class="py-2 text-center">マイクロチップID</th>
                    <th scope="col" class="py-2 text-center">誕生日</th>
                    <th scope="col" class="py-2 text-center">年齢</th>
                    <th scope="col" class="py-2 text-center">編集</th>
                </tr>
                </thead>
                <tbody class="divide-y divide light-blue-400">
                        <tr v-for="(pet, index) in pets" :key="index" class="border-b border-gray-400" ref="petRow">
                            <th scope="row" class="py-2">
                                <img :src="img_src + pet.img" class="rounded-full" @click='showModal(pet.id, index)' style="cursor: pointer">
                            </th>
                            <td class="text-center text-xl">{{ pet.name }}</td>
                            <td class="text-center">{{ pet.kind_name }}</td>
                            <td class="text-center" v-if="pet.micro_id">{{ pet.micro_id }}</td>
                            <td class="text-center" v-else>登録なし</td>
                            <td class="text-center">{{ pet.birth_n }}</td>
                            <td class="text-center">{{ pet.age }}才</td>
                            <td class="text-center">
                                <router-link v-bind:to="{name: 'pets.edit', params: {getId: pet.id }}">
                                    <button class="bg-green-400 text-gray-100 px-4 py-2 rounded-md">Edit</button>
                                </router-link>
                            </td>
                        </tr>
                </tbody>
            </table>
        </div>
        <div id="modal_content_back" v-show="modal" @click="modal = false" :style="conteiner_h"></div>
        <div id="modal_content" v-show="modal" :style="{top: petRow_h}">
                <p class="text-right"><button @click='closeModal()' class="p-1 my-2">
                    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 24px; height: 24px; opacity: 1;" xml:space="preserve"><g><polygon points="511.998,70.682 441.315,0 256.002,185.313 70.685,0 0.002,70.692 185.316,256.006 0.002,441.318 
                        70.69,512 256.002,326.688 441.315,512 511.998,441.318 326.684,256.006 	" style="fill: rgb(75, 75, 75);"></polygon></g></svg></button>
                </p>
                <div>
                    <div class="my-8 mx-2 small">
                    <line-chart
                        :chart-data="datacollection"
                        :option="options"
                        :styles="myChartStyle"
                    ></line-chart>
                    </div>
                </div>
            </div>
        <Loading :isLoading="isLoading"></Loading>
    </div>
</template>

<script>
import Loading from './parts/Loading';
import LineChart from './parts/GraphLine';

export default {
    components: {
        Loading,
        LineChart,
    },
    data: function () {
        return {
            isLoading: true,
            modal: false,
            conteiner_h: {
                height: '',
            },
            petRow_num: '',
            pets: [],
            weights: [],
            passed: [],
            img_src: "storage/images/",
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
        }
    },
    created() {
        this.getDatas();
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
        getDatas() {
            axios.get('/json/pets').then((res) => {
                if(!res.data.user_pets.length){
                return this.$router.push({name: 'alldata.create'});
                }
                this.isLoading = true;
                this.weights = res.data.weights;
                this.pets = res.data.user_pets;
                this.isLoading = false;
            });
        },
        showModal: function(id, key){
            this.pet_id = id;
            if(this.$refs.conteiner.offsetHeight > 500){
                this.conteiner_h.height = this.$refs.conteiner.offsetHeight + 'px';
            }else{
                this.conteiner_h.height = '500px';
            }
            this.petRow_num = key;

            this.modal = true;
        },
        closeModal: function(){
            this.modal = false;
        },
    },
    computed: {
        myChartStyle() {
            return {
                width: `${this.chart_width}px`,
                position: 'relative',
            };
        },
        petRow_h: function(){
            return (this.petRow_num * 117.5 + 460) + 'px';
        },
    },
}
</script>

<style scoped>
.fixed_row{
    position: sticky;
    left: 0;
    background: white;
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
  overflow-x:scroll;
  width:94%;
  height:auto;
  padding: .2em 1em 1em;
  background:#fff;
  color:gray;
  position: absolute;
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