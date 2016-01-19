@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage Products') {{--TITLE GOES HERE--}}

@section('headcontent')

@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading">
                    <h4 class="panel-title">All Products</h4>

                    <div class="panel-control">
                        <a href="/admin/add-product"><i class="fa fa-plus"></i>&nbsp;Add new product</a>
                    </div>
                </div>

                <div class="panel-body">
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejavascripts')

@endsection
