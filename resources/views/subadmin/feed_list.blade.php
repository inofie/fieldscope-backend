
@extends('subadmin.master')
@section('content')
<div class="row">
    <div class="col-md-8">
        <h1 class="main-heading">Photo Feed</h1>
        <div class="row">
            <div class="col-md-8">
                <div class="search-bar">
                    <div class="input-group">
                        <input value="" id="search-input" name="keyword" type="text" class="form-control" placeholder="Search Project" />
                        <span class="input-group-btn">
                            <button id="search-btn" class="btn btn-default search-btn" type="button"><i class="fas fa-search"></i></button>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <button class="btn btn-filter"><i class="fa fa-filter"></i> filter</button>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="container">
            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-add" data-toggle="modal" data-target="#myModal">Add Project</button>

            <div class="modal fade new-modal" id="myModal" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title">Add Filter</h4>
                        </div>
                        <div class="modal-body">
                            <form>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label>Date</label>
                                        <input type="date" class="form-control" placeholder="Date" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Projects</label>
                                        <input type="text" class="form-control" placeholder="Projects" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Users</label>
                                        <input type="text" class="form-control" placeholder="Users" />
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Tags</label>
                                        <input type="text" class="form-control" placeholder="Tags" />
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-close" data-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-save">Save</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div>
    </div>
</div>
<div class="row pt-4">
    <?php for($i=1; $i<=12; $i++) { ?>
    <div class="col-md-2 mb-3">
        <div class="card-image">
            <img src="{{asset('image/one.png')}}" class="img-responsive" />
        </div>
        <div class="card-details">
            <h4>Test Customer</h4>
            <h5 class="dark-gray">Tag Name: Soft it Width</h5>
            <h5 class="light-gray">12:30 p.m. Paul Lewis</h5>
        </div>
    </div>
    <?php } ?>
</div>

<div class="row">
    <div class="col-md-12">
        <nav aria-label="Page navigation" class="text-right">
            <ul class="pagination">
                <li class="disabled">
                    <a href="/" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                <li class="active"><a href="/">1</a></li>
                <li><a href="/">2</a></li>
                <li><a href="/">3</a></li>
                <li><a href="/">4</a></li>
                <li><a href="/">5</a></li>
                <li>
                    <a href="/" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

@endsection

@push('page_level_scripts')
    <script type="text/javascript">
        $(document).ready(function(){
      
        });
    </script>
@endpush