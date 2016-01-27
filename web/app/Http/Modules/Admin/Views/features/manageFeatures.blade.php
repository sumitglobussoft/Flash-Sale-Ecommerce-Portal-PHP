@extends('Admin/Layouts/adminlayout')

@section('title', 'Features') {{--TITLE GOES HERE--}}

@section('headcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <?php  // echo "<pre>"; // print_r($allFeatures); die; ?>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="panel info-box panel-white">
                <div class="panel-heading clearfix">
                    <h4 class="panel-title">Manage feature groups and features</h4>
                    <div class="panel-control">
                        <div style="text-align: center">
                            <div role="group" class="btn-group ">
                                <button aria-expanded="true" data-toggle="dropdown"
                                        class="btn btn-default dropdown-toggle" type="button">
                                    <i class="fa fa-cog"></i>&nbsp;Add
                                    <span class="caret"></span>
                                </button>
                                <ul role="menu" class="dropdown-menu">
                                    <li>
                                        <a href="/admin/add-feature-group">
                                            <i class="fa fa-plus"></i>&nbsp;Add feature group
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/admin/add-feature">
                                            <i class="fa fa-plus"></i>&nbsp;Add feature
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">

                    @if($errMsg == NULL)
                        <div class="col-md-6">
                            <div id="tree_1" class="tree-demo">
                                <?php
                                function createTree($array, $curParent, $currLevel = 0, $prevLevel = -1)
                                {
                                    foreach ($array as $key => $category) {
                                        if ($curParent == $category['parent_id']) {
                                            if ($category['parent_id'] == 0) $class = "dropdown"; else $class = "sub_menu";
                                            if ($currLevel > $prevLevel) echo " <ul class='$class'> ";
                                            if ($currLevel == $prevLevel) echo " </li> ";
                                            if ($category['group_flag'] == 1) {
                                                echo "<li  data-jstree='{ \"opened\" : true }'><a href='/admin/edit-feature-group/" . $category['feature_id'] . "'>" . $category['feature_name'] . "</a>";
                                            } else {
                                                echo "<li  data-jstree='{ \"opened\" : true }'><a href='/admin/edit-feature/" . $category['feature_id'] . "'>" . $category['feature_name'] . "</a>";
                                            }
                                            if ($currLevel > $prevLevel) {
                                                $prevLevel = $currLevel;
                                            }
                                            $currLevel++;
                                            createTree($array, $category['feature_id'], $currLevel, $prevLevel);
                                            $currLevel--;
                                        }
                                    }
                                    if ($currLevel == $prevLevel) echo " </li> </ul> ";
                                }
                                createTree($allFeatures['data'], 0);
                                ?>

                            </div>
                        </div>
                    @else
                        {{$errMsg}}
                    @endif

                    {{--@if($errMsg == NULL)--}}
                    {{--<pre>--}}
                    {{--@foreach($allFeatures['data'] as $keyFD => $valueFD)--}}
                    {{--<tr>--}}
                    {{--{{print_r($valueFD)}}--}}
                    {{--</tr>--}}
                    {{--@endforeach--}}
                    {{--</pre>--}}
                    {{--@else--}}
                    {{--{{$errMsg}}--}}
                    {{--@endif--}}
                </div>
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')
    <script>
        {{--PAGE SCRIPTS GO HERE--}}
    </script>
@endsection
