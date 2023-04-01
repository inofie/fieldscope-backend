
@if($error)

{{--    {{dd($error['data']['user_type'])}}--}}

    <div class="alert alert-info" style="">
        <ul>
            @foreach ($error['data'] as $e)
                <li>{{ ($e) }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if(Session::has('message'))
{{--    {{print_r(Session::get('message'))}}--}}
{{--    {{dd(Session::get('data'))}}--}}
    <div style="" class="alert alert-{{ Session::get('class', 'info') }}">
        {{ Session::get('message') }}
        <ul>
            @if(Session::has('data'))
                @foreach (Session::get('data') as $e)
                    <li>{{ ($e) }}</li>
                @endforeach
            @endif
        </ul>
    </div>
@endif


<div style="display: none;" class="alert alert-danger error"></div>
<div style="display: none;" class="alert alert-success success"></div>


