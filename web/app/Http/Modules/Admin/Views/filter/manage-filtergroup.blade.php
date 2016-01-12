@extends('Admin/Layouts/adminlayout')

@section('title', 'Manage FilterGroup') {{--TITLE GOES HERE--}}

@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    {{--DISPLAY ALL CATEGORIES, USING SERVER SIDE DATATABLES--}}
    <div class="row">
        <div class="btn-bar btn-toolbar dropleft pull-right">
            <a href="/admin/add-new-filtergroup" class="btn btn-success"><i class="fa fa-plus "></i>&nbsp;Add New Filter
                Group</a>
        </div>
        <div class="col-md-12">
            <div class="table-responsive">

                <table class="table table-striped table-bordered table-hover text-center"
                       id="datatable_orders" style="border:none;">
                    <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Product Filter Group Name</th>
                        <th class="text-center">Display On</th>
                        <th class="text-center">Edit</th>
                        <th class="text-center">Delete</th>
                        <th class="text-center">Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $rowCount = 1; ?>
                    @foreach($filtergroupdetail as $filtergroupkey => $filtergroupvalue)
                        @foreach($filtergroupvalue->filtergroup as $filtercatkey => $filtercatval)
                            <tr id="filter<?php echo $filtergroupvalue->product_filter_option_id?>">
                                <td class="text-center"><?php echo $rowCount++; ?></td>
                                <td class="text-center">{{$filtergroupvalue->product_filter_option_name}}</td>
                                <td class="text-center">{{$filtercatval}}</td>
                                <td class="text-center"><a
                                            href="/admin/edit-filtergroup/{{$filtergroupvalue->product_filter_option_id}}"
                                            class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                </td>
                                <td class="text-center"><a href="#"
                                                           class="btn btn-danger delete-feature"
                                                           data-cid="{{$filtergroupvalue->product_filter_option_id}}"><i
                                                class="fa fa-trash-o"></i></a></td>
                                <td class="center" style="text-align: center;">
                                    @if ($filtergroupvalue->product_filter_option_status == 1)
                                        <div class="form-group">
                                            <select class="form-control"
                                                    data-id="<?php echo $filtergroupvalue->product_filter_option_id ?>"
                                                    id="changestatus"
                                                    style='width:80%; margin-left: 2%; background-color: orange'>
                                                <option value="0" style='background-color: white'>Disable</option>
                                                <option value="1" selected style='background-color: green'>Active
                                                </option>
                                            </select>
                                        </div>
                                    @else
                                        <div class="form-group">
                                            <select class="form-control"
                                                    data-id="<?php echo $filtergroupvalue->product_filter_option_id; ?>"
                                                    id="changestatus"
                                                    style='width:80%; margin-left: 2%; background-color: orange'>
                                                <option value="0" selected style='background-color: white'>Disable
                                                </option>
                                                <option value="1" style='background-color: green'>Active</option>
                                            </select>
                                        </div>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    @endforeach
                    </tbody>
                </table>
                {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
@endsection

@section('pagejavascripts')
    <script>
        {{--PAGE SCRIPTS GO HERE--}}

        $(document).ready(function () {

            $(document.body).on("change", "#changestatus", function () {
                var featureId = $(this).attr('data-id');
                //   alert(featureId);
                var featuretatus = $(this).val();
                // console.log(optionstatus);
                $.ajax({
                    url: '/admin/filter-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'changefeatureStatus',
                        featureId: featureId,
                        featuretatus: featuretatus
                    },
                    success: function (response) {
                        var res = $.parseJSON(response);

                        if (res['status'] == 0) {
                            $('#filter' + featureId).prop("disabled", true);
                        } else {
                            $('#filter' + featureId).prop("disabled", false);

                        }
                        window.location.reload();
                    }
                });
            });

            $(document.body).on('click', '.delete-feature', function () {
                var w = $(this);
                var filterId = w.attr('data-cid');
                alert(filterId);
                $.ajax({
                    url: '/admin/filter-ajax-handler',
                    type: 'POST',
                    datatype: 'json',
                    data: {
                        method: 'deletefilteroption',
                        filterId: filterId,

                    },
                    success: function (response) {
                        var res = $.parseJSON(response);
                        if (res) {
                            w.parent().parent().remove();
                        }

                    }

                });
            });

        });

    </script>
@endsection
