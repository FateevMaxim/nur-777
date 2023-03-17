
<x-app-layout>
        <div class="py-6">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

                @if(session()->has('message'))
                    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                        <span class="font-medium">{{ session()->get('message') }}
                    </div>
                @endif

                <div class="grid grid-cols-1 md:grid-cols-3 h-22 pl-6 gap-4 pr-6 pb-4">

                        <div class="grid round_border min_height md:mt-0 mt-4 grid-cols-1 p-4 relative">
                            <div>
                                <h3 class="mt-0 p-4 text-2xl font-medium leading-tight text-primary">Пункт приёма China</h3>
                            </div>
                            <div class="p-4 absolute bottom-0">
                                <span>Количество зарегистрированных трек кодов за сегодня</span>
                                <h3 class="mt-0 text-2xl font-medium leading-tight text-primary">{{ $count }}</h3>
                            </div>
                        </div>
                            <textarea id="track_codes_list" class="min_height round_border p-4" autofocus></textarea>

                        <div class="grid grid-cols-1 p-4 min_height round_border relative">
                            <div class="grid mx-auto mt-8">
                                <img src="{{ asset('images/barcode.jpg') }}" width="200" alt="Barcode">
                                <b class="mx-auto" style="margin-top: -45px;">Upload Data</b>
                            </div>
                            <div id="track" class="grid h-12 mx-auto">
                                <div>
                                    <h1 class="text-2xl font-medium">Счётчик <span id="count"></span></h1>
                                </div>
                            </div>
                            <div class="absolute w-full bottom-0 p-4">
                                <form method="POST" action="{{ route('china-product') }}" id="searchForm">
                                    <div>
                                        <div>
                                            @csrf

                                            <x-primary-button class="mx-auto w-full">
                                                {{ __('Загрузить') }}
                                            </x-primary-button>
                                            <x-secondary-button class="mx-auto mt-4 w-full" id="clear">
                                                {{ __('Очистить') }}
                                            </x-secondary-button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                        <script>

                            document.addEventListener('keypress', e => {
                                var text = $("#track_codes_list").val();
                                var lines = text.split("\n");
                                var count = lines.length;
                                $("#count").text(count);
                            });

                            /* прикрепить событие submit к форме */
                            $("#searchForm").submit(function(event) {
                                /* отключение стандартной отправки формы */
                                event.preventDefault();

                                /* собираем данные с элементов страницы: */
                                var $form = $( this ),
                                    track_codes = $("#track_codes_list").val();
                                    url = $form.attr( 'action' );

                                /* отправляем данные методом POST */
                                $.post( url, { track_codes: track_codes } )
                                 .done(function( data ) {
                                     location.reload();
                                 });

                            });

                            /* прикрепить событие submit к форме */
                            $("#clear").click(function(event) {
                                /* отключение стандартной отправки формы */
                                event.preventDefault();

                                     $("#track_codes_list").html('');
                                     number = 1;
                                     $("#count").text('0');

                            });

                        </script>
                </div>
                    @include('components.scanner-settings')
            </div>
        </div>
</x-app-layout>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.4/datepicker.min.js"></script>
