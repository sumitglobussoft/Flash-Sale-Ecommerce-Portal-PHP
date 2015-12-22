@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage Categories') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    {{--DISPLAY ALL CATEGORIES, USING SERVER SIDE DATATABLES--}}
    <div class="row">
        <div class="btn-bar btn-toolbar dropleft pull-right">
            <a href="/admin/add-category" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp;Add New Category</a>
        </div>
        <div class="col-md-3">
            <?php
            function treeView($array, $id = 0)
            {
                for ($i = 0; $i < count($array); $i++) {
                    if ($array[$i]->parent_category_id == $id) {
                        echo '<a href="/edit-category?id=' . $array[$i]->category_id . '" style="text-decoration: none">' . $array[$i]->display_name . $array[$i]->category_name . '</a><br>';
                        treeView($array, $array[$i]->category_id);
                    }
                }
            }
            ?>
            <?php treeView($allCategories);  ?>
            <?php treeView($allCategories);  ?>
        </div>
    </div>

@endsection

@section('pagejavascripts')
    <script>
        {{--PAGE SCRIPTS GO HERE--}}
    </script>
@endsection
