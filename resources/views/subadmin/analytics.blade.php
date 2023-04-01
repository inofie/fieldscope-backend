@extends('subadmin.master')
@section('content')
    <style>
        @font-face {
            font-family: 'BebasNeue';
            src: url({{URL::to("assets/fonts/BebasNeue-Regular.ttf")}});
        }

        .highcharts-xaxis-labels {
            text-transform: uppercase;
        }

        .highcharts-credits, .highcharts-a11y-proxy-button {
            display: none !important;
        }

    </style>
    <div class="container">
        <!-- <h1 class="main-heading">Dashboard</h1> -->
        <div class="row">
          <div class="col-md-4 mt-17">
              <div class="lightblue-box dashboard-box">
                  <p class="pt-3 ft-18 day">Today,  <span class="user-date">05 June 2020</span></p>
                  <p class="ft-light ft-18 welcome">Welcome,</p>
                  <p class="ft-regular ft-25">{{ucfirst($user->first_name)}} {{ucfirst($user->last_name)}}</p>
              </div>
           </div>
           <div class="col-md-4 mt-17">
              <div class="blue-box dashboard-box">
                  <div class="icon-img">
                  <img src="{{asset('image/dash-user.png')}}" alt="user image" class="img-responsive" />
                  </div>
                  <p class="ft-bold white pt-3 ft-18">Total Users</p>
                  <p class="count white txt-right ft-70 mb-0">{{ $total_users }}</p>
              </div>
           </div>
          <div class="col-md-4 mt-17">
              <div class="gray-box dashboard-box">
                  <div class="icon-img">
                  <img src="{{asset('image/list.png')}}" alt="user image" class="img-responsive" />
                  </div>
                      <p class="ft-bold theme pt-3 ft-18">Total Projects</p>
                      <p class="count theme txt-right ft-70 mb-0">{{ $total_projects }}</p>
               </div>

            </div>
        </div>
        {{--        <div class="row" style="margin-top:30px;">--}}
        {{--            <div class="col-md-12">--}}
        {{--                <div id="chartContainer" style="height: 300px; width: 100%;"></div>--}}
        {{--            </div>--}}
        {{--        </div>--}}

        <div class="row" style="margin-top:30px;">
            <div class="col-md-12">
                <div id="container"></div>
            </div>
        </div>

    </div>

@endsection

@push('page_level_scripts')
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

    {{--    <script>--}}
    {{--        window.onload = function () {--}}

    {{--           var lastWeekProjects = '{!! json_encode($getLastWeekProject) !!}';--}}
    {{--               lastWeekProjects = JSON.parse(lastWeekProjects);--}}

    {{--           var chart_data = [];--}}
    {{--           if(lastWeekProjects.length > 0)--}}
    {{--           {--}}
    {{--             for(var i=0; i < lastWeekProjects.length; i++)--}}
    {{--             {--}}
    {{--                var record = {};--}}
    {{--                    record.x = new Date(lastWeekProjects[i].created_at);--}}
    {{--                    record.y = parseInt(lastWeekProjects[i].total_project);--}}
    {{--                chart_data.push(record);--}}
    {{--             }--}}
    {{--           }--}}

    {{--           console.log(chart_data);--}}

    {{--            var chart = new CanvasJS.Chart("chartContainer", {--}}
    {{--                animationEnabled: true,--}}
    {{--                title:{--}}
    {{--                    text: "Last Week Projects Record",--}}
    {{--                    fontFamily: "Gibson-SemiBold",--}}
    {{--                    fontWeight: "bold",--}}
    {{--                    horizontalAlign: "left",--}}
    {{--                    margin: 20,--}}
    {{--                    fontColor: "#3f3d56",--}}
    {{--                    fontSize: 28,--}}
    {{--                },--}}
    {{--//                 axisY: {--}}
    {{--//                     title: "Quantity",--}}
    {{--//                     valueFormatString: "#0,,.",--}}
    {{--//                     suffix: "",--}}
    {{--//                     stripLines: [{--}}
    {{--//                         value: 3366500,--}}
    {{--//                         label: "Average"--}}
    {{--//                     }]--}}
    {{--//                 },--}}
    {{--                data: [{--}}
    {{--                    type: "spline",--}}
    {{--                    dataPoints: chart_data--}}
    {{--                }]--}}
    {{--            });--}}
    {{--            chart.render();--}}
    {{--        }--}}
    {{--    </script>--}}

    <script>
        Highcharts.chart('container', {
            chart: {
                type: 'line'
            },
            title: {
                text: 'Last Week Projects Record'
            },
            /*subtitle: {
                text: 'Source: WorldClimate.com'
            },*/
            xAxis: {
                categories: {!! json_encode($dates) !!},
            },
            yAxis: {
                title: {
                    text: 'No. of projects'
                }
            },
            plotOptions: {
                line: {
                    dataLabels: {
                        enabled: true,
                        style: {
                            color: '#00ADE7',
                            fontSize: '16px',
                            fontFamily: 'BebasNeue',
                        }

                    },
                    enableMouseTracking: false
                }
            },
            series: [{
                name: 'Projects Per Day',
                marker: {
                    symbol: 'url({{URL::to("image/dot3.png")}})',
                    width: 70,
                    height: 70,

                },

                data: {{json_encode($projectsPerDay)}},
                lineWidth: 2,
                color: "#333333",
                dataLabels: {
                    padding: 25,
                }
            }]
        });
    </script>
@endpush
