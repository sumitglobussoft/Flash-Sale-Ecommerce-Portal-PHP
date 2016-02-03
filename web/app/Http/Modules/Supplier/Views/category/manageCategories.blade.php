@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Manage Categories') {{--TITLE GOES HERE--}}

@section('pageheadcontent')
    <link rel="stylesheet" type="text/css" href="/assets/plugins/jstree/dist/themes/default/style.min.css"/>

    <style>
        /*.jstree li a i {*/
            /*display: none !important;*/
        /*}*/
    </style>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-12">
            @if(empty($allCategories))
                <div style="text-align: center">
                    <span class="">Sorry, no category found.</span><br>
                    <a href="/supplier/add-category">
                        <button class="btn btn-xs btn-success">Add new category</button>
                    </a>
                </div>
            @else
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h4 class="panel-title">All Categories</h4>

                        <div class="panel-control">
                            <a href="/supplier/add-category" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Add new category</a>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class="col-md-6">
                            <div id="tree_1" class="tree-demo">
                                <?php
                                function createTree($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                {
                                    foreach ($array as $key => $category) {
                                        if ($curParent == $category->parent_category_id) {
                                            if ($category->parent_category_id == 0) $class = "dropdown"; else $class = "sub_menu";
                                            if ($currLevel > $prevLevel) echo " <ul class='$class'> ";
                                            if ($currLevel == $prevLevel) echo " </li> ";
                                            if (\Illuminate\Support\Facades\Session::get('fs_supplier')['id'] == $category->created_by)
                                                echo "<li data-jstree='{ \"selected\" : true,\"opened\" : true,\"icon\":\"fa fa-edit icon-state-success \" }'><a href='/supplier/edit-category/$category->category_id '> $category->category_name</a>";
                                            else
                                                echo "<li data-jstree='{ \"disabled\" : true}'><a data-toggle='tooltip' title='You can edit your category only.' href='javascript:void(0);'> $category->category_name</a>";
                                            if ($currLevel > $prevLevel) $prevLevel = $currLevel;
                                            $currLevel++;
                                            createTree($array, $category->category_id, $currLevel, $prevLevel);
                                            $currLevel--;
                                        }
                                    }
                                    if ($currLevel == $prevLevel) echo " </li> </ul> ";
                                }
                                createTree($allCategories, 0);
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

@endsection

@section('pagejavascripts')
    <script src="/assets/plugins/jstree/dist/jstree.min.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="/assets/js/pages/ui-tree.js"></script>
    <script>
        $(document).ready(function () {
            UITree.init();
        });
    </script>
@endsection
