/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 require('./bootstrap');

//  import Vue from 'vue';
import VueRouter from 'vue-router';
import VCalendar from 'v-calendar';
import LineChart from 'vue-chartjs';
// import Vuetify from 'vuetify';
// import 'vuetify/dist/vuetify.min.css';
 
 import HeaderComponent from "./components/HeaderComponent";
 import FoodComponent from "./components/FoodComponent";
 import AnimalsComponent from "./components/AnimalsComponent";
 import AnimalsEditComponent from "./components/AnimalsEditComponent";
 import AlldataComponent from "./components/AlldataComponent";
 import AlldataCreateComponent from "./components/AlldataCreateComponent";
 import WeightEditComponent from "./components/WeightEditComponent";
 import NoteShowComponent from "./components/NoteShowComponent";
 import NoteEditComponent from "./components/NoteEditComponent";


 window.Vue = require('vue').default;
 Vue.use(VueRouter);
//  Vue.use(Vuetify);
 Vue.use(VCalendar);
 Vue.component('chart-component', LineChart);



 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */
 
 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
 
 Vue.component('header-component', HeaderComponent);
 
 
 const router = new VueRouter({
    mode: 'history',
    routes: [
        {
            path: '/food',
            name: 'food',
            component: FoodComponent
        },
        {
            path: '/top',
            name: 'alldata',
            component: AlldataComponent
        },
        {
            path: '/create',
            name: 'alldata.create',
            component: AlldataCreateComponent
        },
        {
            path: '/pets',
            name: 'pets',
            component: AnimalsComponent
        },
        {
            path: '/pets/:getId/edit',
            name: 'pets.edit',
            component: AnimalsEditComponent,
            props: true,
        },
        {
            path: '/weight/:getId/edit',
            name: 'weight.edit',
            component: WeightEditComponent,
            props: true,
        },
        {
            path: '/note/:getId',
            name: 'note.show',
            component: NoteShowComponent,
            props: true,
        },
        {
            path: '/note/:getId/edit',
            name: 'note.edit',
            component: NoteEditComponent,
            props: true,
        },
    ]
 });
 const app = new Vue({
     el: '#app',
     router,
    //  vuetify: new Vuetify(),
 });
 