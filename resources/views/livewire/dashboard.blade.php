<div>
    <div class="max-w-full mx-auto px-4  bg-slate-300 rounded-lg transition-all duration-500 ease-in-out ">
        <div class="flex flex-col items-stretch">
            <h1 class="text-xl font-bold text-cyan-500 py-2">Dashboard<span>::</span> </h1>
            <hr class="border-slate-500/40 ">

            <div class="py-4 flex gap-4 flex-col">
                <div class="flex flex-row gap-4 justify-between items-stretch">
                    <x-helpers.parts.dashboard.card
                        class="w-3/6 p-4 bg-white/80 min-h-48 drop-shadow rounded-lg neomorphism">

                        <div id="debit"></div>
                    </x-helpers.parts.dashboard.card>
                    <x-helpers.parts.dashboard.card
                        class="w-3/6 p-4 bg-white/80 min-h-48 drop-shadow rounded-lg neomorphism">

                        <div id="credit"></div>
                    </x-helpers.parts.dashboard.card>

                </div>

                <x-helpers.parts.dashboard.card
                    class="w-full p-4 bg-white/80 min-h-48 drop-shadow rounded-lg neomorphism" />
            </div>

        </div>
    </div>

</div>

{{--
@script
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

    var sparklineData = [47, 45, 54, 38, 56, 24, 65, 31, 37, 39, 62, 51, 35, 41, 35, 27, 93, 53, 61, 27, 54,
        43, 19,
        46
    ];

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


    /*
            new ApexCharts(document.querySelector("#debit"), spark1).render();

            spark1.chart.id = "sdsd";
            spark1.chart.group = "sdsd1";

            spark1.title.text = '$224,652';
            spark1.colors = ['#FF6969']

            spark1.subtitle.text = spark1.series.name = "Credit";

            new ApexCharts(document.querySelector("#credit"), spark1).render();


            setInterval(() => {
                $wire.render()
            }, 5000);

            */
</script>
@endscript
 --}}
