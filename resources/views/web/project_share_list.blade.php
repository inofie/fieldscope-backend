<?php
//echo "<pre>";
//$session = \Session::all();
//$user = $session['user'];
//print_r($user); die;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>subadmin </title>
    <!-- Bootstrap -->
    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/subadmin/style.css')}}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link rel="icon" href="{{ asset('image/logo.png') }}" type="image/gif" sizes="16x16">

    <!-- NProgress -->
    <link href="{{asset('assets/css/nprogress.css')}}" rel="stylesheet">
    <!-- jQuery custom content scroller -->
    <link href="{{asset('assets/css/jquery.mCustomScrollbar.min.css')}}" rel="stylesheet"/>

    <!-- Custom Theme Style -->
    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/css/mytheme.css')}}" rel="stylesheet">
    <link href="{{asset('assets/select2/css/select2.css')}}" rel="stylesheet">

    <link href="https://cdn.datatables.net/1.10.18/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/rowreorder/1.2.5/css/rowReorder.dataTables.min.css" rel="stylesheet">

    <script>
        var base_url = "{{URL::to('/')}}";
    </script>
    <style>
        .select2-container {
            width: 100% !important;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            width: 100% !important;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            border-radius: 13px;
            color: white;
            background-color: #00aee7;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }
        .card-image img{
            height:150px;
            border-radius:5px;
        }

    </style>
</head>
<body class="nav-md">
<div class="container body">
    <div class="main_container">

        <div class="right_col" role="main">
            <?php //print_r($data); /*die;*/?>

                {{--{{dd(request()->input('project_ids'))}}--}}
                <div class="row">
                    <div class="col-md-6">
                        <h1 class="main-heading">Project Photos</h1>
                    </div>

                    <div class="col-md-6">
                        <div class="container">
                            <button class="btn btn-add" data-toggle="modal" data-target="#myModal"><i class="fa fa-filter pl-1"></i>
                                filter
                            </button>

                            <a href="{{url('project/photos').'/'.$data['projectShare']['share_token']}}" class="btn btn-add"><i class="fa fa-times pl-1"></i> Clear
                                Filter</a>
                            <!-- Trigger the modal with a button -->
                            {{--<button type="button" class="btn btn-add" >Add Project </button>--}}

                            <div class="modal fade new-modal" id="myModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                                        aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title">Add Filter</h4>
                                        </div>
                                        <form class="filters">
                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="form-group col-md-6">
                                                        <label>Date</label>
                                                        <input type="date" name="date" class="form-control" placeholder="Date"
                                                               @if(!empty(request()->input('date')) )
                                                               value="{{request()->input('date')}}"
                                                                @endif
                                                        />
                                                    </div>
                                                    <div class="form-group col-md-6">
                                                        <label>Inspection Areas</label>
                                                        <select name="category_ids" class="form-control select2">
                                                            @if(empty(request()->input('category_ids')))
                                                                <option value="0" disabled selected>Select Your Option</option>
                                                            @endif
                                                            @foreach($data['category'] AS $key => $item)
                                                                <option
                                                                        @if(!empty(request()->input('category_ids')) AND  request()->input('category_ids') == $item['id'])
                                                                        {{'selected'}}
                                                                        @endif
                                                                        value="{{$item['id']}}">{{$item['name']}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-close" data-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn btn-save">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- /.modal -->
                        </div>
                    </div>
                </div>
                <div class="row pt-4 listing">
                    @if(!empty($data['media']->total()))
                        @foreach($data['media'] AS $key => $item)
                            <div class="col-md-2 mb-3">
                                <a href="/">
                                    <div class="card-image">
                                        <img src="{{url('uploads/media/'.$item->path )}}" class="img-responsive"/>
                                    </div>
                                    <div class="card-details" style="min-height:80px">
{{--                                        <h4>{{$item->p_name}}</h4>--}}
                                        <h5 class="light-gray" title="{{\Carbon\Carbon::parse($item->created_at)->format('Y-m-d g:i A') }}">
                                            {{\Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                                        </h5>
{{--                                        . {{$item->u_first_name}} {{$item->u_last_name}} --}}
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <div class="col-md-12 mb-3 text-center">
                            <h4>No Data Found</h4>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12">
                        {{$data['media']->appends(request()->input())->links()}}
                    </div>
                </div>

        </div>
    </div>
</div>

<!-- jQuery -->
<script src="{{asset('assets/js/jquery.min.js')}}"></script>
<!-- Bootstrap -->
<script src="{{asset('assets/js/bootstrap.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('assets/js/fastclick.js')}}"></script>
<!-- NProgress -->
<script src="{{asset('assets/js/nprogress.js')}}"></script>
<!-- jQuery custom content scroller -->
<script src="{{asset('assets/js/jquery.mCustomScrollbar.concat.min.js')}}"></script>
<!-- Custom Theme Scripts -->
<script src="{{asset('assets/js/custom.min.js')}}"></script>

<script src="{{asset('assets/select2/js/select2.min.js')}}"></script>
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>--}}
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/rowreorder/1.2.5/js/dataTables.rowReorder.min.js"></script>

<script src="{{asset('assets/js/custom-datatable.js')}}"></script>


<script type="text/javascript">
    $(document).ready(function () {

        var filters = '@php echo json_encode(request()->input()); @endphp';
        var requestP = JSON.parse(filters);
        console.log(filters, 'filters');
        console.log(requestP, 'requestP');

        $("form.filters").on('submit', function (e) {

            e.preventDefault();
            var inputP = queryStringToJson($(this).find("select,textarea, input").serialize());

            requestP.date = inputP.date;
            requestP.project_ids = inputP.project_ids;
            requestP.tag_ids = inputP.tag_ids;
            requestP.user_ids = inputP.user_ids;

            console.log(inputP, 'inputP');
            console.log(requestP, 'requestP');


            window.location = location.protocol + '//' + location.host + location.pathname + '?' + $.param(inputP);
        });

        function queryStringToJson(url) {
            return JSON.parse('{"' + decodeURI(url).replace(/"/g, '\\"').replace(/&/g, '","').replace(/=/g, '":"') + '"}');
        }
    });
</script>

</body>
</html>





