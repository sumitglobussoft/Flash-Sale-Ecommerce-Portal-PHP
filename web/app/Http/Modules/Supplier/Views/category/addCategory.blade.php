@extends('Supplier/Layouts/supplierlayout')

@section('title', 'New Category') {{--TITLE GOES HERE--}}

@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
    <link href="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.css" rel="stylesheet" type="text/css"/>
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Category Details</h4>
                </div>
                <div class="panel-body">
                    <form class="form-horizontal" method="post" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                       value="{{old('category_name')}}">
                                <span class="error">{!! $errors->first('category_name') !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Parent Category</label>

                            <div class="col-sm-4">
                                <select name="parent_category" class="form-control m-b-sm">
                                    <option value="0">-Root level-</option>
                                    <?php
                                    function createTree1($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                    {
                                        foreach ($array['category'] as $key => $category) {
                                            if ($curParent == $category->parent_category_id) {
                                                echo '<option value="' . $category->category_id . '" >';
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
                                    createTree1($newCategoryArray, 0);
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="input-placeholder" class="col-sm-2 control-label">Description</label>

                            <div class="col-sm-4">
                                <textarea name="category_desc" class="form-control">{{old('category_desc')}}</textarea>
                                <span class="error">{!! $errors->first('category_desc') !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Status</label>

                            <div class="col-sm-4">
                                <input type="radio" name="status" value="1" checked>Active
                                <input type="radio" name="status" value="0">Inactive
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image</label>

                            <div class="col-sm-4">
                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                    <div class="fileinput-new thumbnail"
                                         style="width: 200px; height: 150px;">
                                        <img src="/assets/images/no-image.png" alt=""/>
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
                        {{--<label class="col-sm-2 control-label">SEO Name</label>--}}

                        {{--<div class="col-sm-4">--}}
                        {{--<input type="text" class="form-control" name="seo_name"--}}
                        {{--value="{{old('category_name')}}">--}}
                        {{--<span class="error">{!! $errors->first('seo_name') !!}</span>--}}
                        {{--</div>--}}
                        {{--</div>--}}
                        {{--<hr>--}}
                        Meta Data
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Page title</label>

                            <div class="col-sm-4">
                                <input type="text" class="form-control" name="page_title"
                                       value="{{old('category_name')}}">
                                <span class="error">{!! $errors->first('page_title') !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Meta description</label>

                            <div class="col-sm-4">
                                <textarea name="meta_desc" class="form-control">{{old('meta_desc')}}</textarea>
                                <span class="error">{!! $errors->first('meta_desc') !!}</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Meta keywords</label>

                            <div class="col-sm-4">
                                <textarea name="meta_keywords" class="form-control">{{old('meta_keywords')}}</textarea>
                                <span class="error">{!! $errors->first('meta_keywords') !!}</span>
                            </div>
                        </div>
                        <div class="form-actions" align="center">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <button type="reset" class="btn btn-default">Reset</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection


@section('pagejavascripts')
    <script src="/assets/plugins/bootstrap-fileinput/bootstrap-fileinput.js" type="text/javascript"></script>
@endsection
