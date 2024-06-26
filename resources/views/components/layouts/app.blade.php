<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    {{-- <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"> --}}


    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <style>
        .material-symbols-outlined {
            font-variation-settings:
                'FILL' 0,
                'wght' 400,
                'GRAD' -25,
                'opsz' 16
        }


        .small-icon {
            font-size: 20px;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])



</head>

<body class="font-sans antialiased ">
    <div class="min-full bg-gray-100 overflow-hidden">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        {{-- {{ $slot }} --}}

        <div class="flex   bg-white ">
            <livewire:parts.sidebar />

            <main class="w-4/5 p-4">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>


    <script>
        Apex.grid = {
            padding: {
                right: 0,
                left: 0
            }
        }

        Apex.dataLabels = {
            enabled: false
        }

        var randomizeArray = function(arg) {
            var array = arg.slice();
            var currentIndex = array.length,
                temporaryValue, randomIndex;

            while (0 !== currentIndex) {

                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex -= 1;

                temporaryValue = array[currentIndex];
                array[currentIndex] = array[randomIndex];
                array[randomIndex] = temporaryValue;
            }

            return array;
        }

        // data for the sparklines that appear below header area
        var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54, 43, 19,
            46
        ];

        // the default colorPalette for this dashboard
        //var colorPalette = ['#01BFD6', '#5564BE', '#F7A600', '#EDCD24', '#F74F58'];
        var colorPalette = ['#06b6d4', '#00D8B6', '#008FFB', '#FEB019', '#FF4560', '#775DD0']

        var spark1 = {
            chart: {
                id: 'sparkline1',
                group: 'sparklines',
                type: 'area',
                height: 160,
                sparkline: {
                    enabled: true
                },
            },
            stroke: {
                curve: 'straight'
            },
            fill: {
                opacity: 1,
            },
            series: [{
                name: 'Debit',
                data: randomizeArray(sparklineData)
            }],
            labels: [...Array(24).keys()].map(n => `2018-09-0${n+1}`),
            yaxis: {
                min: 0
            },
            xaxis: {
                type: 'datetime',
            },
            colors: ['#06b6d4'],
            title: {
                text: '$424,652',
                offsetX: 30,
                style: {
                    fontSize: '24px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            },
            subtitle: {
                text: 'Debit',
                offsetX: 30,
                style: {
                    fontSize: '20px',
                    cssClass: 'apexcharts-yaxis-title'
                }
            }
        }


        new ApexCharts(document.querySelector("#debit"), spark1).render();

        spark1.subtitle.text = spark1.series.name = "Credit";

        spark1.title.text = '$224,652';
        spark1.colors = ['#FF6969']

        new ApexCharts(document.querySelector("#credit"), spark1).render();
    </script>

</body>

</html>
