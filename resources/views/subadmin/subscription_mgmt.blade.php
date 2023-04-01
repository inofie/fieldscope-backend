@extends('subadmin.master')
@section('content')
    <div class="row nomargin" id="top">
        <div class="col-md-9">
        <h1 class="main-heading">Subscription Management</h1>
        </div>
        <div class="col-md-3">
            <div class="container">
                <a href="{{URL::to('subadmin/re_subscription')}}" class="btn btn-add addusertype-btn-modified">Re-Subscribe</a>
                {{--<button type="button" class="btn btn-info add  addusertype-btn-modified" data-toggle="modal" data-target="#myModal">Re-Subscribe</button>--}}
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row nomargin">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>title</th>
                        <th>description</th>
                        <th>duration</th>
                        <th></th>

                    </tr>
                    </thead>
                    <tbody>
                        @foreach($data['subs'] AS $key => $item)
                            @if($data['companySub']['subscription_id'] == $item->id )
                                @php
                                    $selected = 'style="background-color: #0082f1;color:white!important;"';
                                @endphp
                                <tr @php
                                    echo $selected ;
                                @endphp >
                                    <td style="color: #000;">{{$item['title']}}</td>
                                    <td style="color: #000;">{{$item['description']}}</td>
                                    <td style="color: #000;">{{$item['duration'].' '.$item['duration_unit']}}</td>
                                    <td colspan="2" class="text-right" style="color: #000;">
                                        <a href="/" class="edit_form" style="color: #000;" data-id="{{$item->id}}"> <i class="fas fa-arrow-up"></i></a>

                                    </td>
                                </tr>
                            @else
                                @php
                                    $selected = '';
                                @endphp
                            @endif

                        @endforeach
                    </tbody>
                </table>
                {{$data['subs']->appends($_GET)->links()}}
            </div>

        </div>
    </div>


@endsection

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Select Your Option"
            });

            var updateUrl = "{{URL::to('subadmin/project/update')}}";
            var $editModal = $('#editModal');

            $("td a.delete").on('click', function (e) {
                return confirm("Are you sure ?");
            });

            $('#search-btn').on('click', function (e) {
                var keyword = $('#search-input').val();
                search(keyword);
            });

            $('.stateInput').on('change', function (e) {
                var id = $(this).val();
                var $input = $(this);
                $.getJSON('{{URL::to('subadmin/cities')}}/'+id, function(response){
                        var items = [];
                        $.each( response.data, function( key, val ) {
                            items.push( "<option value='" + val.id + "'>" + val.name + "</option>" );
                        });
                        // console.log($('.stateInput').closest('.row').find('.cityInput'));
                    $input.closest('.row').find('.cityInput').append(items.join( "" ));
                    });
                //search(keyword);
            });

            function search(keyword) {
                var url = new URL(window.location.href);
                url.searchParams.set('keyword', keyword);
                url.searchParams.set('page',1);
                console.log(url.href);
                window.location.href = url.href;
            }

            $("td a.edit_form").on('click', function (e) {
                e.preventDefault();
                console.log('edit');
                var id = $(this).data('id');
                $.ajax({
                    url: "{{URL::to('subadmin/project/editProjectDetails/')}}/" + id,
                    method: "GET",
                    data: '',
                    success: function (response) {
                        var data = response.data;
                        $('#update_form').attr('action', updateUrl + '/' + response.data.id);
                        console.log(response.data );
                        console.log($('#update_form input[name="name"]'));

                        $('#update_form input[name="name"]').val(response.data.name);
                        $('#update_form input[name="address1"]').val(response.data.address1);
                        $('#update_form input[name="address2"]').val(response.data.address2);
                        $('#update_form input[name="postal_code"]').val(response.data.postal_code);
                        $('#update_form input[name="claim_num"]').val(response.data.claim_num);
                        $('#update_form input[name="inspection_date"]').val(response.data.inspection_date);

                        $('#update_form select[name="state_id"] option').each(function (key,item) {
                            if($(item).val() == response.data.state_id){
                                $(item).prop('selected', true);
                            }
                        });
                        $('#update_form select[name="state_id"]').trigger('change');

                        // console.log('city_id');
                        // console.log($(document).find('#update_form select[name="city_id"] option'));
                        $('#update_form select[name="city_id"] option').each(function (key,item) {
                            // console.log('city_id');
                            if($(item).val() == response.data.city_id){
                                $(item).prop('selected', true);
                            }
                        });

                        $('#update_form select[name="assigned_user_id"] option').each(function (key,item) {
                            if($(item).val() == response.data.assigned_user_id){
                                $(item).prop('selected', true);
                            }
                        });



                        $editModal.modal('show');
                    },
                    error: function () {
                        alert("No Network");
                    }
                });
            });
        });
    </script>
@endpush