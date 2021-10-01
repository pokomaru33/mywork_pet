<template>
    <div id="header" class="relative">
        <div class="py-2 px-2 bg-gray-800 overflow-hidden">
            <div class="container">
                <nav class="flex justify-between items-center">
                    <span class="mb-0 text-white">PETS</span>
                    <div class="flex items-start">
                        <router-link v-bind:to="{name: 'pets'}">
                            <button class="h-12 px-2 text-sm font-semibold text-center text-white rounded-md lg:h-10 bg-green-500 hover:bg-teal-300">
                                <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hideen h-8 x-6">
                                    <g>
                                        <path class="fill-current text-white" d="M433.198,202.846l-69.291-69.236l-54.996-54.926l-52.823-53.018L0,281.562l37.928,37.905l34.026-33.995v200.86
                                            h150.257h67.577h150.257V285.442l34.026,34.026L512,281.562L433.198,202.846z M408.139,454.426H299.595V335.265h-87.191v119.161
                                            H103.862V253.589l152.227-152.103l152.05,152.049V454.426z" style="fill: white;"></path>
                                    </g>
                                </svg>
                            </button>
                        </router-link>
                        <router-link v-bind:to="{name: 'food'}">
                            <button class="h-12 ml-1 px-2 text-sm font-semibold text-center text-white rounded-md lg:h-10 bg-green-500 hover:bg-teal-300">
                                <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hideen h-8 x-6">
                                <g>
                                    <path class="fill-current text-white" d="M207.103,23.875v109.219c0,7-5.656,12.641-12.625,12.641h-3.375c-6.969,0-12.641-5.641-12.641-12.641V23.375
                                        c0-18-12.109-23.375-23.719-23.375s-23.719,5.375-23.719,23.375v109.719c0,7-5.672,12.641-12.641,12.641h-3.375
                                        c-6.969,0-12.625-5.641-12.625-12.641V23.875c0-32.219-45.938-31.125-45.938,0.359c0,37.703,0,104.297,0,104.297
                                        c-0.219,57.906,13.625,72.953,36.469,91c18.422,14.531,34.156,22.859,34.156,58.953v232.188h55.344V278.484
                                        c0-36.094,15.734-44.422,34.156-58.953c22.859-18.047,36.688-33.094,36.469-91c0,0,0-66.594,0-104.297
                                        C253.04-7.25,207.103-8.344,207.103,23.875z" style="fill: white;"></path>
                                    <path class="fill-current text-white" d="M385.228,34.75c-11.75,32.953-45.578,110.156-47.719,178.344c-3.313,105.844,61.547,90.188,62.703,159.531
                                        v138.688h55.078l0.266,0.688c0,0,0-0.281,0-0.688c0-9.266,0-119.625,0-232.203c0-111.359,0-224.797,0-244.359
                                        C455.556-5.438,403.524-16.531,385.228,34.75z" style="fill: white;"></path>
                                </g>
                                </svg>
                            </button>
                        </router-link>
                        <router-link v-bind:to="{name: 'alldata'}">
                            <button class="h-12 ml-1 px-2 text-sm font-semibold text-center text-white rounded-md lg:h-10 bg-green-500 hover:bg-teal-300">
                                <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hidden h-8 x-6">
                                    <g>
                                        <path d="M392.197,26.581h-4.77v-9.699c0-9.316-7.55-16.882-16.881-16.882c-9.332,0-16.898,7.566-16.898,16.882v9.699
                                            h-42.576v-9.699c0-9.316-7.558-16.882-16.89-16.882c-9.324,0-16.89,7.566-16.89,16.882v9.699h-42.576v-9.699
                                            c0-9.316-7.566-16.882-16.89-16.882c-9.332,0-16.89,7.566-16.89,16.882v9.699h-42.584v-9.699c0-9.316-7.566-16.882-16.89-16.882
                                            c-9.332,0-16.89,7.566-16.89,16.882v9.699h-4.77c-38.501,0.008-69.684,31.199-69.7,69.7v306.59
                                            c0.016,60.28,48.856,109.12,109.129,109.128h156.354l146.312-146.312V96.281C461.89,57.78,430.699,26.589,392.197,26.581z
                                            M429.173,350.021h-31.679c-51.237,0-92.766,41.53-92.766,92.766v33.787l-2.692,2.692l-142.804,0.008
                                            c-21.149-0.008-40.148-8.525-54.026-22.378c-13.853-13.878-22.37-32.877-22.378-54.025V96.281
                                            c0.008-10.258,4.114-19.398,10.834-26.142c6.743-6.719,15.883-10.826,26.142-10.834h4.77v18.121c0,9.332,7.558,16.889,16.89,16.889
                                            c9.324,0,16.89-7.558,16.89-16.889V59.306h42.584v18.121c0,9.332,7.558,16.889,16.89,16.889c9.323,0,16.89-7.558,16.89-16.889
                                            V59.306h42.576v18.121c0,9.332,7.566,16.889,16.89,16.889c9.332,0,16.89-7.558,16.89-16.889V59.306h42.576v18.121
                                            c0,9.332,7.566,16.889,16.898,16.889c9.332,0,16.881-7.558,16.881-16.889V59.306h4.77c10.259,0.008,19.398,4.114,26.142,10.834
                                            c6.718,6.744,10.825,15.883,10.834,26.142V350.021z" style="fill: white;"></path>
                                        <rect x="146.919" y="170.033" width="218.17" height="32.725" style="fill: white;"></rect>
                                        <rect x="146.919" y="257.294" width="218.17" height="32.725" style="fill: white;"></rect>
                                        <rect x="146.919" y="344.556" width="130.9" height="32.725" style="fill: white;"></rect>
                                    </g>
                                    </svg>
                            </button>
                        </router-link>
                        <router-link v-bind:to="{name: 'alldata.create'}">
                            <button class="h-12 ml-1 px-4 pb-1 text-2xl font-semibold text-center text-white rounded-md bg-green-500 hover:bg-teal-300">+</button>
                        </router-link>

                        <button @click="x_boxAccount" type="button" class="h-12 px-2 ml-1 oveerflow-hidden text-sm leading-4 font-medium rounded-md text-green-500 bg-white hover:text-gray-700 focus:outline-none transition">
                            <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hideen h-6 x-6">
                                <g>
                                    <path class="fill-current text-gray-600" d="M305.895,307.693c-15.71,5.222-32.45,8.157-49.895,8.157s-34.186-2.935-49.894-8.157
                                        C92.029,326.416,32.331,410.25,32.331,512h223.668h223.67C479.669,410.25,419.981,326.416,305.895,307.693z" style="fill: rgb(75, 75, 75);"></path>
                                    <path class="fill-current text-gray-600" d="M255.999,279.581c67.621,0,122.424-54.813,122.424-122.423v-34.735C378.423,54.814,323.621,0,255.999,0
                                        c-67.62,0-122.423,54.814-122.423,122.423v34.735C133.577,224.768,188.379,279.581,255.999,279.581z" style="fill: rgb(75, 75, 75);"></path>
                                </g>
                            </svg>
                        </button>

                    </div>
                </nav>
            </div>
        </div>
        <div class="w-40 mr-2 bg-gray-700 rounded-md ring-1 ring-black py-1 bg-white absolute right-0 top-20 z-20 shadow-md" v-show="boxAccount">
            <div class="block px-4 py-2 text-xs text-gray-200">Manage Account</div>
            <a class="block px-4 py-2 text-sm leading-5 text-white transition" href="/contact/input">お問い合わせ</a>
            <div class="border-t border-gray-400"></div>
            <a class="block px-4 py-2 text-sm leading-5 text-white transition" href="/user/profile">アカウント情報</a>
            <div class="border-t border-gray-400"></div>
            <a class="block px-4 py-2 text-sm leading-5 text-white transition" href="/donation">寄付する</a>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                boxAccount: false,
            }
        },
        methods: {
            x_boxAccount: function () {
                this.boxAccount = !this.boxAccount;
            },
        }
    }
</script>