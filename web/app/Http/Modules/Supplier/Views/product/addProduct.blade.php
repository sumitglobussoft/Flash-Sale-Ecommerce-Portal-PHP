@extends('Supplier/Layouts/supplierlayout')

@section('title', 'Add Product')

@section('content')
    <div class="panel panel-white">
        <div class="panel-body">
            <div role="tabpanel">
                <!-- Nav tabs -->
                <ul role="tablist" class="nav nav-tabs">
                    <li class="active" role="presentation"><a data-toggle="tab" role="tab" href="#tab1" aria-expanded="true">General</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab2" aria-expanded="false">Images</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab3" aria-expanded="false">SEO</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab4" aria-expanded="false">Shipping Properties</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab5" aria-expanded="false">Quantity discounts</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab6" aria-expanded="false">Features</a></li>
                    <li role="presentation" class=""><a data-toggle="tab" role="tab" href="#tab7" aria-expanded="false">Product Tabs</a></li>
                </ul>
                <!-- Tab panes -->
                <div class="tab-content">
                    <div id="tab1" class="tab-pane fade active in" role="tabpanel">
                        <p>General</p>
                    </div>
                    <div id="tab2" class="tab-pane fade" role="tabpanel">
                        <p>Images</p>
                    </div>
                    <div id="tab3" class="tab-pane fade" role="tabpanel">
                        <p>SEO</p>
                    </div>
                    <div id="tab4" class="tab-pane fade" role="tabpanel">
                        <p>Shipping properties</p>
                    </div>
                    <div id="tab5" class="tab-pane fade" role="tabpanel">
                        <p>Quantity discounts</p>
                    </div>
                    <div id="tab6" class="tab-pane fade" role="tabpanel">
                        <p>Features</p>
                    </div>
                    <div id="tab7" class="tab-pane fade" role="tabpanel">
                        <p>Product Tabs</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

    {{--<script src="/assets/js/pages/dashboard.js"></script>--}}
@endsection
