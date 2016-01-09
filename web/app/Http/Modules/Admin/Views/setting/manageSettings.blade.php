@extends('Admin/Layouts/adminlayout')

@section('title', 'Settings: '.(isset($allObjectsOfSeciton[0]->section_name) ? str_replace('_',' ',$allObjectsOfSeciton[0]->section_name) : '')) {{--TITLE GOES HERE--}}

@section('headcontent')

@endsection

@section('content')
    <div class="row">
        <div class="panel panel-white">
            <div class="panel-body">
                <div class="col-md-3 well" id="section-sidebar">
                    @if(isset($allSection)&&!empty($allSection))
                        <div id="section-sidebar-wrapper">
                            <ul class="nav nav-pills nav-stacked">
                                @foreach($allSection as $sectionKey =>$section)
                                    <li role="presentation"
                                        @if($allObjectsOfSeciton[0]->section_id==$section->section_id) class="active" @endif>
                                        <a href="/admin/manage-settings/{{$section->name}}">{{str_replace('_',' ',$section->name)}}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                <div class="col-md-9" id="main-content">
                    @if(isset($allObjectsOfSeciton)&&!empty($allObjectsOfSeciton))
                        <form class="form-horizontal" method="post">
                            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                                <?php
                                $firstHead = 0;
                                ?>
                                @foreach($allObjectsOfSeciton as $key=>$value)
                                    @if($value->type!='H')
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">
                                                {{$value->setting_name}}
                                                @if($value->tooltip!='')
                                                    <i class="fa fa-question-circle" data-toggle="tooltip"
                                                       title="{{$value->tooltip}}!"></i>
                                                @endif
                                            </label>

                                            <div class="col-sm-4">
                                                @if($value->type=='U' ||$value->type=='I')
                                                    <input name="update[{{$value->object_id}}]"
                                                           id="field_{{$value->name.'_'.$value->object_id}}"
                                                           class="form-control" type="text" value="{{$value->value}}">
                                                @elseif($value->type=='S')
                                                    <?php
                                                    $varNamesValues = explode('____', $value->variant_names);
                                                    $varNames = explode('____', $value->var_names);
                                                    ?>
                                                    <select name="update[{{$value->object_id}}]"
                                                            id="field_{{$value->name.'_'.$value->object_id}}"
                                                            class="form-control">
                                                        @if($value->var_names!='')
                                                            @foreach($varNames as $variantKey=>$variant)
                                                                <option value="{{$varNamesValues[$variantKey]}}" @if($value->value==$varNamesValues[$variantKey]) selected @endif>{{$variant}}</option>
                                                            @endforeach
                                                        @else
                                                            <option>{{$value->value}}</option>
                                                        @endif

                                                    </select>
                                                    <?php
                                                        $varNamesValues='';
                                                        $varNames='';
                                                        ?>
                                                @elseif($value->type=='C')
                                                    <input name="update[{{$value->object_id}}]"
                                                           id="field_{{$value->name.'_'.$value->object_id}}"
                                                           class="form-control" type="checkbox"
                                                           @if($value->value=='Y') checked @endif>
                                                @endif

                                            </div>
                                        </div>

                                    @endif

                                    @if($value->type=='H')
                                        @if($firstHead!=0)
                                            <?php echo '</div></div></div>'; ?>
                                        @endif
                                        <div class="panel panel-default">
                                            <div class="panel-heading" role="tab"
                                                 id="head_{{$value->object_id}}">
                                                <h4 class="panel-title">
                                                    <a @if($firstHead!=0||$key!=0)class="collapsed"
                                                       @endif data-toggle="collapse" data-parent="#accordion"
                                                       href="#collapse_{{$value->object_id}}"
                                                       aria-expanded="@if($firstHead==0&&$key==0)true @else false @endif"
                                                       aria-controls="collapse_{{$value->object_id}}">
                                                        {{$value->setting_name}}
                                                    </a>
                                                </h4>
                                            </div>

                                            <div id="collapse_{{$value->object_id}}"
                                                 class="panel-collapse collapse @if($firstHead==0&&$key==0)in @endif"
                                                 role="tabpanel"
                                                 aria-labelledby="head_{{$value->object_id}}">
                                                <div class="panel-body" style="height:300px; overflow-y:auto;">
                                                    <?php $firstHead++; ?>
                                                    @endif
                                                    @endforeach
                                                </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

@section('pagejavascripts')

@endsection
