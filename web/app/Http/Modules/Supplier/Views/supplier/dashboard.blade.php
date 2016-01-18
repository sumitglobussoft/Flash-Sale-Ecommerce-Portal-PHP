@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Dashboard')


@section('pageheadcontent')
    {{--OPTIONAL--}}
    {{--PAGE STYLES OR SCRIPTS LINKS--}}

@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="counter">107,200</p>
                        <span class="info-box-title">User activity this month</span>
                    </div>
                    <div class="info-box-icon">
                        <i class="icon-users"></i>
                    </div>
                    <div class="info-box-progress">
                        <div class="progress progress-xs progress-squared bs-n">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 40%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="counter">340,230</p>
                        <span class="info-box-title">Page views</span>
                    </div>
                    <div class="info-box-icon">
                        <i class="icon-eye"></i>
                    </div>
                    <div class="info-box-progress">
                        <div class="progress progress-xs progress-squared bs-n">
                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="80"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 80%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p>$<span class="counter">653,000</span></p>
                        <span class="info-box-title">Monthly revenue goal</span>
                    </div>
                    <div class="info-box-icon">
                        <i class="icon-basket"></i>
                    </div>
                    <div class="info-box-progress">
                        <div class="progress progress-xs progress-squared bs-n">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="60"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 60%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6">
            <div class="panel info-box panel-white">
                <div class="panel-body">
                    <div class="info-box-stats">
                        <p class="counter">47,500</p>
                        <span class="info-box-title">New emails recieved</span>
                    </div>
                    <div class="info-box-icon">
                        <i class="icon-envelope"></i>
                    </div>
                    <div class="info-box-progress">
                        <div class="progress progress-xs progress-squared bs-n">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="50"
                                 aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row -->

@endsection

@section('pagejavascripts')
    <script src="/assets/plugins/3d-bold-navigation/js/main.js"></script>
    <script src="/assets/plugins/waypoints/jquery.waypoints.min.js"></script>
    <script src="/assets/plugins/jquery-counterup/jquery.counterup.min.js"></script>
    <script src="/assets/plugins/toastr/toastr.min.js"></script>

    <script src="/assets/plugins/flot/jquery.flot.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.time.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.symbol.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.resize.min.js"></script>
    <script src="/assets/plugins/flot/jquery.flot.tooltip.min.js"></script>
    <script src="/assets/plugins/curvedlines/curvedLines.js"></script>
    <script src="/assets/plugins/metrojs/MetroJs.min.js"></script>
    <script src="/assets/js/modern.js"></script>
    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}
@endsection
