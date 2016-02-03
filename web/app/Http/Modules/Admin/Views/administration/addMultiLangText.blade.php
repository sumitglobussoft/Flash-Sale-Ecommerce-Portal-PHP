@extends('Admin/Layouts/adminlayout')

@section('title',trans('message.addlanguagevalue')) {{--TITLE GOES HERE--}}

@section('headcontent')
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.7/css/jquery.dataTables.min.css">
@endsection

@section('content')
    {{--PAGE CONTENT GOES HERE--}}
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-white">
                <form method="POST" class="languagevariable" id="languageForm">
                    <div id="table" class="table-editable">
                        <table class="table" id="manage_multi_text">
                            <thead>
                            <tr>
                                <th class="text-center">English Value</th>
                                <th class="text-center">Converted Value</th>

                            </tr>
                            </thead>
                        </table>
                    </div>

                    <div class="form-actions" align="center">
                        <button class="btn btn-primary" id="langsubmit">Submit</button>
                        <a class="btn btn-default" href="/admin/manage-language">{{trans('message.backtolist')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>
@endsection


@section('pagejavascripts')
    <script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {

            $('#manage_multi_text').DataTable({
                "processing": true,
                "serverSide": true,
                "emptyTable": "No data available in table",
                "ajax": {
                    url: "/admin/administration-ajax-handler",
                    data: {
                        method: 'multi-lang-text'
                    },
//                    success: function(response){
                    //var response = $.parseJSON(response);
//                        console.log(response);
//                    }

                }
            });


            $(document.body).on("click", '#langsubmit', function (e) {
                e.preventDefault();
                var formData = new FormData(document.getElementById('languageForm'));
                formData.append("method", 'submitconvertlang');
                $.ajax({
                    url: '/admin/administration-ajax-handler',
                    type: 'POST',
                    dataType: 'json',
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    data: formData,
                    success: function (response) {
                        toastr[response.status](response.msg);
                    }
                });
            });

        });

    </script>
@endsection