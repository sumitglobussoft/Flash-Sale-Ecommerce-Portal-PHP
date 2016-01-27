@extends('Admin/Layouts/adminlayout')

@section('title', 'Editing category: '.(isset($categoryDetails->category_name) ? $categoryDetails->category_name : '')) {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="/assets/plugins/jstree/dist/themes/default/style.min.css"/>

    <style>
        .jstree li a i {
            display: none !important;
        }
    </style>
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}

    <div class="row">
        <div class="col-md-12">
            @if(!isset($categoryDetails))
                <div style="text-align: center">
                    <span class="">Sorry, no such category found.</span><br>
                    <a href="/admin/manage-categories">
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
                                            if ($array['selectedId'] == $category->category_id) $dataJSTree = '{ "selected" : true,"opened" : true,"icon":false }'; else $dataJSTree = '';
                                            echo "<li  data-jstree='$dataJSTree'><a href='/admin/edit-category/$category->category_id '> $category->category_name</a>";
                                            if ($currLevel > $prevLevel) {
                                                $prevLevel = $currLevel;
                                            }
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
                                            $selectedCatId = $categoryDetails->category_id;
                                            function treeView($array, $id = 0, $selectedId)
                                            {
                                                for ($i = 0; $i < count($array); $i++) {
                                                    if ($array[$i]->parent_category_id == $id) {
                                                        $selected = $array[$i]->category_id == $selectedId ? 'selected' : '';
                                                        echo '<option value="' . $array[$i]->category_id . '"' . $selected . '>' . $array[$i]->display_name . $array[$i]->category_name . '</option>';
                                                        treeView($array, $array[$i]->category_id, $selectedId);
                                                    }
                                                }
                                            }
                                            ?>
                                            @if(isset($allCategories))
                                                <?php treeView($allCategories, 0, $categoryDetails->parent_category_id);  ?>
                                            @endif
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
                                                            <span class="btn btn-circle default btn-file">
                                                                <span class="fileinput-new">
                                                                    Select image </span>
                                                                <span class="fileinput-exists">
                                                                    Change </span>
                                                                <input type="file" name="category_image"
                                                                       accept="image/*">
                                                            </span>
                                                <a href="#" class="btn btn-circle default fileinput-exists"
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
                                    <a href="/admin/manage-categories" class="btn btn-default">Cancel</a>
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
