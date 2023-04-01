
@extends('subadmin.master')
@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="main-heading">View Editor</h1>
    </div>
    <div class="col-md-4 mt-15">
        <div class="row">
            <div class="col-md-4">
                <button type="button" class="btn btn-info">Enable Draw</button>
            </div>
            <div class="col-md-4">
                <select class="form-control br-3">
                    <option>thin</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="col-md-4">
                <select class="form-control br-3">
                    <option>Red</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
        </div>
    </div>
</div>
<form class="form-inline">
    <div class="row pt-4">
        <div class="col-md-12 textarea">
            <label>Example textarea</label>
            <textarea class="form-control" rows="6"></textarea>
        </div>
    </div>
    <div class="row pt-3">
        
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Name1</label>
                    <input type="text" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Name2</label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6 form-group">
                    <label>Name3</label>
                    <input type="text" class="form-control">
                </div>

                <div class="col-md-6 form-group">
                    <label>Name4</label>
                    <input type="text" class="form-control">
                </div>
            </div>
        </div>
     
    </div>
    <div class="row">
        <div class="col-md-12 pt-4">
            <button type="button" class="btn btn-save">Save</button>
        </div>
    </div>
</form>
@endsection

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
      
        });
    </script>
@endpush