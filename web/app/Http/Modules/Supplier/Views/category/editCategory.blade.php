@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Editing category: '.(isset($categoryDetails->category_name) ? $categoryDetails->category_name : '')) {{--TITLE GOES HERE--}}

@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/jstree/dist/themes/default/style.min.css"/>

    <style>
        /*.jstree li a i {*/
        /*display: none !important;*/
        /*}*/
    </style>
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">
            @if(!isset($categoryDetails))
                <div style="text-align: center">
                    <span class="">Sorry, no such category found.</span><br>
                    <a href="/supplier/manage-categories">
                        <button class="btn btn-xs btn-success">Go back</button>
                    </a>
                </div>
            @else
                <div class="panel panel-white">
                    <div class="panel-heading">
                        <h4 class="panel-title">Categories</h4>

                    </div>
                    <div class="panel-body">
                        <div class="col-md-4 well">
                            <div id="tree_1" class="tree-demo">
                                <?php
                                function createTree($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                {
                                    foreach ($array['category'] as $key => $category) {
                                        if ($curParent == $category->parent_category_id) {
                                            if ($category->parent_category_id == 0) $class = "dropdown"; else $class = "sub_menu";
                                            if ($currLevel > $prevLevel) echo " <ul class='$class'> ";
                                            if ($currLevel == $prevLevel) echo " </li> ";

                                            $dataJSTree = ($array['selectedId'] == $category->category_id) ? ' "selected" : true,"opened" : true,"icon":false,"icon":"fa fa-edit icon-state-success " ' : '';
                                            if (\Illuminate\Support\Facades\Session::get('fs_supplier')['id'] == $category->created_by)
                                                echo "<li data-jstree='{" . $dataJSTree . "}'><a href='/supplier/edit-category/$category->category_id '> $category->category_name</a>";
                                            else
                                                echo "<li data-jstree='{\"disabled\" : true" . ($dataJSTree != '' ? ',' . $dataJSTree : '') . "}'><a data-toggle='tooltip' title='You can edit your category only.' href='javascript:void(0);'> $category->category_name</a>";

                                            if ($currLevel > $prevLevel) $prevLevel = $currLevel;
                                            $currLevel++;
                                            createTree($array, $category->category_id, $currLevel, $prevLevel);
                                            $currLevel--;
                                        }
                                    }
                                    if ($currLevel == $prevLevel) echo " </li> </ul> ";
                                }
                                $newCategoryArray['category'] = $allCategories;
                                $newCategoryArray['selectedId'] = $categoryDetails->category_id;
                                createTree($newCategoryArray, 0);
                                ?>

                            </div>
                        </div>
                        <div class="col-md-8">
                            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Name</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" id="category_name" name="category_name"
                                               value="{{ $categoryDetails->category_name}}">
                                        <span class="error">{!! $errors->first('category_name') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Parent Category</label>

                                    <div class="col-sm-8">
                                        <select name="parent_category" class="form-control m-b-sm">
                                            <option value="0">-Root level-</option>
                                            <?php
                                            function createTree1($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                            {
                                                foreach ($array['category'] as $key => $category) {
                                                    if ($curParent == $category->parent_category_id) {
                                                        echo '<option value="' . $category->category_id . '" '
                                                                . (($array['selectedParentId'] == $category->category_id) ? "selected" : "")
                                                                . (($array['selectedId'] == $category->category_id) ? "disabled" : "") . '>';
                                                        if ($currLevel >= $prevLevel) echo str_repeat('&brvbar;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;', $currLevel);
                                                        echo $category->category_name;
                                                        if ($currLevel > $prevLevel) $prevLevel = $currLevel;
                                                        $currLevel++;
                                                        echo '</option>';
                                                        createTree1($array, $category->category_id, $currLevel, $prevLevel);
                                                        $currLevel--;
                                                    }
                                                }
                                            }
                                            $newCategoryArray['category'] = $allCategories;
                                            $newCategoryArray['selectedParentId'] = $categoryDetails->parent_category_id;
                                            $newCategoryArray['selectedId'] = $categoryDetails->category_id;
                                            createTree1($newCategoryArray, 0);
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="input-placeholder" class="col-sm-3 control-label">Description</label>

                                    <div class="col-sm-8">
                                <textarea name="category_desc"
                                          class="form-control">{{$categoryDetails->category_desc}}</textarea>
                                        <span class="error">{!! $errors->first('category_desc') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Status</label>

                                    <div class="col-sm-8">
                                        <?php $status = array('1' => 'Active', '2' => 'Inactive');?>
                                        @foreach($status as $key=>$value)
                                            <input type="radio" name="status" value="{{$key}}"
                                                   @if($categoryDetails->category_status==$key) checked @endif>{{$value}}
                                        @endforeach
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Image</label>
                                    <input type="hidden" name="old_image"
                                           value="{{$categoryDetails->category_banner_url}}">
                                    <div class="col-sm-8">
                                        <div class="fileinput fileinput-new" data-provides="fileinput">
                                            <div class="fileinput-new thumbnail"
                                                 style="width: 200px; height: 150px;">
                                                @if($categoryDetails->category_banner_url!='')
                                                    <img src="{{$categoryDetails->category_banner_url}}" alt=""/>
                                                @else
                                                    <img src="/assets/images/no-image.png" alt=""/>
                                                @endif
                                            </div>
                                            <div class="fileinput-preview fileinput-exists thumbnail"
                                                 style="max-width: 200px; max-height: 150px;">
                                            </div>
                                            <div>
                                                            <span class="btn btn-circle btn-default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select image </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="category_image"
                                                                       accept="image/*">
                                                            </span>
                                                <a href="#" class="btn btn-circle btn-default fileinput-exists"
                                                   data-dismiss="fileinput">
                                                    Remove </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--<hr>--}}
                                {{--SEO--}}
                                {{--<div class="form-group">--}}
                                {{--<label class="col-sm-3 control-label">SEO Name</label>--}}

                                {{--<div class="col-sm-8">--}}
                                {{--<input type="text" class="form-control" name="seo_name"--}}
                                {{--value="{{$categoryDetails->category_name}}">--}}
                                {{--<span class="error">{!! $errors->first('seo_name') !!}</span>--}}
                                {{--</div>--}}
                                {{--</div>--}}
                                <hr>
                                <b>Meta Data</b>

                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Page title</label>

                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="page_title"
                                               value="{{$categoryDetails->page_title}}">
                                        <span class="error">{!! $errors->first('page_title') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta description</label>

                                    <div class="col-sm-8">
                                <textarea name="meta_desc"
                                          class="form-control">{{$categoryDetails->meta_description}}</textarea>
                                        <span class="error">{!! $errors->first('meta_desc') !!}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Meta keywords</label>

                                    <div class="col-sm-8">
                                <textarea name="meta_keywords"
                                          class="form-control">{{$categoryDetails->meta_keywords}}</textarea>
                                        <span class="error">{!! $errors->first('meta_keywords') !!}</span>
                                    </div>
                                </div>
                                <div class="form-actions" align="center">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                    <a href="/supplier/manage-categories" class="btn btn-default">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>
@endsection


@section('pagejavascripts')
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
    <script src="/assets/plugins/jstree/dist/jstree.min.js"></script>
    <!-- END PAGE LEVEL SCRIPTS -->
    <script src="/assets/js/pages/ui-tree.js"></script>
    <script>
        $(document).ready(function () {
            UITree.init();
        });
    </script>
@endsection
