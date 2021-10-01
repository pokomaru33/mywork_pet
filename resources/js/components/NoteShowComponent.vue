<template>
    <div class="px-4 mt-8">
        <div class="">
            <div class="">
                <p class="text-red-600 mb-4" v-if="notes.flg_type == '1'">病院からのメモ</p>
                <p class="mb-4">名前: {{notes.name}}</p>
                <p class="mb-4">タイトル: {{notes.title}}</p>
                <p class="mb-4">内容:<br>{{notes.body}}</p>
            </div>
            <div class="overflow-hidden">
                <router-link v-bind:to="{name: 'note.edit', params: {getId: getId }}">
                    <button class="h-12 w-full text-sm font-semibold text-center text-white rounded-md bg-green-500 mb-4">編集する</button>
                </router-link>
                <button class="h-12 w-24 text-xs font-semibold text-center text-white rounded-md bg-red-600 float-right" v-on:click="delNote(getId)">削除</button>
            </div>
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
            notes: {},
           }
       },
       methods: {
           getData() {
               axios.get('/json/note/' + this.getId)
                   .then((res) => {
                    this.notes = res.data;
                   });
           },
            delNote(id) {
                axios.delete('/json/note/' + id)
                .then((res) => {
                    this.$router.push({name: 'alldata'});
                });
            },
       },
       mounted() {
           this.getData();
       }
    }
</script>