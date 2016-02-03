@extends('Admin/Layouts/adminlayout')

@section('title', 'Edit Language Values') {{--TITLE GOES HERE--}}

@section('headcontent')

@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <form method="POST" class="languagevariable">
                    <div id="table" class="table-editable">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Language Variable</th>
                                <th>Value</th>
                            </tr>
                            </thead>
                            <tbody id="variantTBody">
                            <tr>
                                <td><input type="text" class="form-control" readonly="readonly"
                                           name="name" value="{{$langdetails[0]->name}}">
                                </td>
                                <td><input type="text" class="form-control"
                                           name="value" value="{{$langdetails[0]->value}}">
                                </td>
                                {{--<td>--}}
                                {{--<a class="col-sm-1 add-more"><i class="fa fa-plus"></i></a>--}}
                                {{--<a class="col-sm-1 remove"><i class="fa fa-remove"></i></a>--}}
                                {{--</td>--}}
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-actions" align="center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-default" href="/admin/manage-language-value">{{ trans('message.backtolist') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('pagejavascripts')
    <script type="text/javascript">

        $(document).ready(function () {


        });


    </script>
@endsection