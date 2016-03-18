@extends('Admin/Layouts/adminlayout')

@section('title',trans('message.addlanguagevalue')) {{--TITLE GOES HERE--}}

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
                                <th>Extra</th>
                            </tr>
                            </thead>
                            <tbody id="variantTBody">
                            <tr>
                                <td><input type="text" class="form-control"
                                           name="name[]">
                                    {!!  $errors->first('name', '<font color="red">:message</font>') !!}
                                </td>
                                <td><input type="text" class="form-control"
                                           name="value[]">
                                    {!!  $errors->first('value', '<font color="red">:message</font>') !!}
                                </td>
                                <td>
                                    <a class="col-sm-1 add-more"><i class="fa fa-plus"></i></a>
                                    <a class="col-sm-1 remove"><i class="fa fa-remove"></i></a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-actions" align="center">
                        <button type="submit" class="btn btn-primary">Submit</button>
                        <a class="btn btn-default" href="/admin/manage-language">{{ trans('message.backtolist') }}</a>
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
            var variantCounter = 1;
            $(document.body).on('click', '.add-more', function () {
                var toAppendNewTableRow = '<tr>';
                toAppendNewTableRow += '<td><input type="text" class="form-control" name="name[]"></td>';
                toAppendNewTableRow += '<td><input type="text" class="form-control" name="value[]"></td>';
                toAppendNewTableRow += '<td>';
                toAppendNewTableRow += '<a class="col-sm-1 add-more"><i class="fa fa-plus"></i></a>';
                toAppendNewTableRow += '<a class="col-sm-1 remove"><i class="fa fa-remove"></i></a>';
                toAppendNewTableRow += '</td>';

                toAppendNewTableRow += ' </tr>';

                $("#variantTBody").append(toAppendNewTableRow);
                variantCounter++;
            });

            $(document.body).on('click', '.remove', function () {
                var count = $('#variantTBody').children('tr').length;
                if (count > 1) {
                    $(this).closest('tr').remove();
                }
            });
//            if ($(".tab-content").find('.error').text()) {
//                $.each($(".tab-content").find('.error'), function (index, value) {
//                    if ($(this).text()) {
//                        $(".tab-content").children('.tab-pane').removeClass('active');
//                        $(this).closest('.tab-pane').addClass('active');
//
//                        $(".nav-tabs").children('li').removeClass('active');
//                        var id = $(this).closest('.tab-pane').attr('id');
////                        if (id == 'tab_1_1') {
////                            $(".nav-tabs").children('li').first().addClass('active');
////                        } else {
////                            $(".nav-tabs").children('li').last().addClass('active');
////                        }
//                        console.log(id);
//                        return false;
//                    }
//                });
//            }

        });


    </script>
@endsection