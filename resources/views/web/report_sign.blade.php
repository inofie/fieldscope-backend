
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
{{--    <link href="{{asset('assets/css/custom.min.css')}}" rel="stylesheet">--}}
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

        .report{

        }
        #_iframe_pdf_url{
            width: 100%;
            height: 900px;
        }

        .sign-form{
            padding: 50px 0;
        }

        #signature{
            width: 800px;
            height: auto;
            margin: 0 auto ;
            border: 1px #515151 dashed;
        }

    </style>
</head>
<body class="">
<section class="container">
    <div class="row report">
        <div class="col-md-12">
            <iframe id="_iframe_pdf_url" src="{{url($report['path']."?".$report->updated_at)}}" frameborder="0"></iframe>
        </div>
    </div>

    @if(empty($report['customer_sign']))
        <div class="row sign-form">
            <div class="col-md-12">
                <div id="signature"></div>
                <p style="padding: 20px 0; text-align: center; margin: 0 auto ;">Signature</p>
            </div>
            <div class="btn-area" style="text-align: center;">
                <button id="_signature_submit" type="button" class="btn btn-primary btn-sm">Submit</button>
            </div>
        </div>
        @endif


</section>
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

        $("#signature").jSignature();

        // $('.myImg').click(function () {
        //     var image_src = $(this).attr('src');
        //     $('#img01').attr('src', image_src);
        //     $('#myModal').modal('show');
        // })
        //
        // $('._view_pdf').click(function () {
        //     let pdf_url = $(this).data('pdf-url');
        //     $('#_iframe_pdf_url').attr('src', pdf_url);
        // })

        $('#_signature_submit').click(function (e) {
            e.preventDefault();
            var $sigdiv = $("#signature")
            var datapair = $sigdiv.jSignature("getData", "svgbase64");
            let image_url = "data:" + datapair[0] + "," + datapair[1]
            $.ajax({
                type: 'POST',
                url: '{{ URL::to("report/sign/".$report['token']) }}',
                data: {
                    signature_url: image_url,
                    id: '{{ $data["id"] }}',
                    pdf_url: $('#_iframe_pdf_url').attr('src')
                },
                beforeSend: function () {
                    // $('#_signature_submit').attr('disabled', 'disabled');
                },
                success: function (data) {
                    console.log('_signature_submit', data);
                    alert(data.message);
                    location.href = '{{ URL::to("")}}';
                    return false;
                }
            });
        })

    });
</script>
<script src="{{ asset('assets/js/jSignature.min.js') }}"></script>

</body>
</html>





