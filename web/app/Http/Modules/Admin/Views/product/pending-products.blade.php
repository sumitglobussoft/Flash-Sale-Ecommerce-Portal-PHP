@extends('Admin/Layouts/adminlayout')

@section('title', 'Dashboard') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">
            <table class="dynamicTable table table-bordered table-condensed" style="width: 100%" id='categoriestable'>
                <thead>
                <tr>
                    <th class="center">No.</th>
                    <th>Product Name</th>
                    <th>Store</th>
                    <th>Added date</th>
                    <th>View</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                <tbody>
                <?php foreach ($pendingProducts as $keyPP => $valuePP) {


                }?>
                </tbody>
            </table>
        </div>
    </div>

@endsection

@section('pagejavascripts')
    <script>
        {{--PAGE SCRIPTS GO HERE--}}
    </script>
@endsection
