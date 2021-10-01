<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <div class="py-2 px-2 bg-gray-800 overflow-hidden">
        <div class="container flex justify-between items-center">
            <span class="mb-0 text-white">PETS</span>
            <div class="flex items-start">
                <a href="{{asset('pets')}}" class="block h-12 px-2 text-sm font-semibold text-center text-white rounded-md pt-2 bg-green-500 hover:bg-teal-300">
                    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hideen h-8 x-6">
                        <g><path class="fill-current text-white" d="M433.198,202.846l-69.291-69.236l-54.996-54.926l-52.823-53.018L0,281.562l37.928,37.905l34.026-33.995v200.86h150.257h67.577h150.257V285.442l34.026,34.026L512,281.562L433.198,202.846z M408.139,454.426H299.595V335.265h-87.191v119.161H103.862V253.589l152.227-152.103l152.05,152.049V454.426z" style="fill: white;"></path></g>
                    </svg>
                </a>
                <a href="{{asset('food')}}" class="block h-12 ml-1 px-2 text-sm font-semibold text-center text-white rounded-md pt-2 bg-green-500 hover:bg-teal-300">
                    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hideen h-8 x-6">
                        <g><path class="fill-current text-white" d="M207.103,23.875v109.219c0,7-5.656,12.641-12.625,12.641h-3.375c-6.969,0-12.641-5.641-12.641-12.641V23.375c0-18-12.109-23.375-23.719-23.375s-23.719,5.375-23.719,23.375v109.719c0,7-5.672,12.641-12.641,12.641h-3.375c-6.969,0-12.625-5.641-12.625-12.641V23.875c0-32.219-45.938-31.125-45.938,0.359c0,37.703,0,104.297,0,104.297c-0.219,57.906,13.625,72.953,36.469,91c18.422,14.531,34.156,22.859,34.156,58.953v232.188h55.344V278.484c0-36.094,15.734-44.422,34.156-58.953c22.859-18.047,36.688-33.094,36.469-91c0,0,0-66.594,0-104.297C253.04-7.25,207.103-8.344,207.103,23.875z" style="fill: white;"></path><path class="fill-current text-white" d="M385.228,34.75c-11.75,32.953-45.578,110.156-47.719,178.344c-3.313,105.844,61.547,90.188,62.703,159.531v138.688h55.078l0.266,0.688c0,0,0-0.281,0-0.688c0-9.266,0-119.625,0-232.203c0-111.359,0-224.797,0-244.359C455.556-5.438,403.524-16.531,385.228,34.75z" style="fill: white;"></path></g>
                    </svg>
                </a>
                <a href="{{asset('top')}}" class="block h-12 ml-1 px-2 text-sm font-semibold text-center text-white rounded-md pt-2 bg-green-500 hover:bg-teal-300">
                    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" xml:space="preserve" class="overflow-hidden h-8 x-6">
                        <g><path d="M392.197,26.581h-4.77v-9.699c0-9.316-7.55-16.882-16.881-16.882c-9.332,0-16.898,7.566-16.898,16.882v9.699h-42.576v-9.699c0-9.316-7.558-16.882-16.89-16.882c-9.324,0-16.89,7.566-16.89,16.882v9.699h-42.576v-9.699c0-9.316-7.566-16.882-16.89-16.882c-9.332,0-16.89,7.566-16.89,16.882v9.699h-42.584v-9.699c0-9.316-7.566-16.882-16.89-16.882c-9.332,0-16.89,7.566-16.89,16.882v9.699h-4.77c-38.501,0.008-69.684,31.199-69.7,69.7v306.59c0.016,60.28,48.856,109.12,109.129,109.128h156.354l146.312-146.312V96.281C461.89,57.78,430.699,26.589,392.197,26.581zM429.173,350.021h-31.679c-51.237,0-92.766,41.53-92.766,92.766v33.787l-2.692,2.692l-142.804,0.008c-21.149-0.008-40.148-8.525-54.026-22.378c-13.853-13.878-22.37-32.877-22.378-54.025V96.281c0.008-10.258,4.114-19.398,10.834-26.142c6.743-6.719,15.883-10.826,26.142-10.834h4.77v18.121c0,9.332,7.558,16.889,16.89,16.889c9.324,0,16.89-7.558,16.89-16.889V59.306h42.584v18.121c0,9.332,7.558,16.889,16.89,16.889c9.323,0,16.89-7.558,16.89-16.889V59.306h42.576v18.121c0,9.332,7.566,16.889,16.89,16.889c9.332,0,16.89-7.558,16.89-16.889V59.306h42.576v18.121c0,9.332,7.566,16.889,16.898,16.889c9.332,0,16.881-7.558,16.881-16.889V59.306h4.77c10.259,0.008,19.398,4.114,26.142,10.834c6.718,6.744,10.825,15.883,10.834,26.142V350.021z" style="fill: white;"></path><rect x="146.919" y="170.033" width="218.17" height="32.725" style="fill: white;"></rect><rect x="146.919" y="257.294" width="218.17" height="32.725" style="fill: white;"></rect><rect x="146.919" y="344.556" width="130.9" height="32.725" style="fill: white;"></rect></g>
                    </svg>
                </a>
                <a href="{{asset('create')}}"  class="block h-12 ml-1 px-4 text-2xl font-semibold text-center text-white rounded-md pt-2 bg-green-500 hover:bg-teal-300">+</a>
                <a href="{{asset('contact/input')}}" class="block h-12 ml-1 px-2 text-sm font-semibold text-center rounded-md pt-2 bg-white hover:bg-teal-300">
                    <svg version="1.1" id="_x32_" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="width: 32px; height: 32px; opacity: 1;" xml:space="preserve">
                        <g>
                            <path style="fill:#4B4B4B" d="M510.678,112.275c-2.308-11.626-7.463-22.265-14.662-31.054c-1.518-1.915-3.104-3.63-4.823-5.345
                                c-12.755-12.818-30.657-20.814-50.214-20.814H71.021c-19.557,0-37.395,7.996-50.21,20.814c-1.715,1.715-3.301,3.43-4.823,5.345
                                C8.785,90.009,3.63,100.649,1.386,112.275C0.464,116.762,0,121.399,0,126.087V385.92c0,9.968,2.114,19.55,5.884,28.203
                                c3.497,8.26,8.653,15.734,14.926,22.001c1.59,1.586,3.169,3.044,4.892,4.494c12.286,10.175,28.145,16.32,45.319,16.32h369.958
                                c17.18,0,33.108-6.145,45.323-16.384c1.718-1.386,3.305-2.844,4.891-4.43c6.27-6.267,11.425-13.741,14.994-22.001v-0.064
                                c3.769-8.653,5.812-18.171,5.812-28.138V126.087C512,121.399,511.543,116.762,510.678,112.275z M46.509,101.571
                                c6.345-6.338,14.866-10.175,24.512-10.175h369.958c9.646,0,18.242,3.837,24.512,10.175c1.122,1.129,2.179,2.387,3.112,3.637
                                L274.696,274.203c-5.348,4.687-11.954,7.002-18.696,7.002c-6.674,0-13.276-2.315-18.695-7.002L43.472,105.136
                                C44.33,103.886,45.387,102.7,46.509,101.571z M36.334,385.92V142.735L176.658,265.15L36.405,387.435
                                C36.334,386.971,36.334,386.449,36.334,385.92z M440.979,420.597H71.021c-6.281,0-12.158-1.651-17.174-4.552l147.978-128.959
                                l13.815,12.018c11.561,10.046,26.028,15.134,40.36,15.134c14.406,0,28.872-5.088,40.432-15.134l13.808-12.018l147.92,128.959
                                C453.137,418.946,447.26,420.597,440.979,420.597z M475.666,385.92c0,0.529,0,1.051-0.068,1.515L335.346,265.221L475.666,142.8
                                V385.92z"></path>
                        </g>
                    </svg>
                </a>
            </div>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-2 border-b-2">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>
            <div class="my-2">
                <!-- Account Management -->
                <x-jet-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')" class="mb-1">
                    {{ __('アカウント') }}
                </x-jet-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-jet-responsive-nav-link href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                    this.closest('form').submit();">
                        {{ __('ログアウト') }}
                    </x-jet-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
