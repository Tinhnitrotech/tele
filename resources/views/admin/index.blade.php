@extends('common.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Uplon</a></li>
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Layouts</a></li>
                        <li class="breadcrumb-item active">Sidebar Collapsed</li>
                    </ol>
                </div>
                <h4 class="page-title">Sidebar Collapsed</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-layers float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Orders</h6>
                <h3 class="my-3" data-plugin="counterup">1,587</h3>
                <span class="badge badge-success mr-1"> +11% </span> <span class="text-muted">From previous period</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-paypal float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Revenue</h6>
                <h3 class="my-3">$<span data-plugin="counterup">46,782</span></h3>
                <span class="badge badge-danger mr-1"> -29% </span> <span class="text-muted">From previous period</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-chart float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Average Price</h6>
                <h3 class="my-3">$<span data-plugin="counterup">15.9</span></h3>
                <span class="badge badge-pink mr-1"> 0% </span> <span class="text-muted">From previous period</span>
            </div>
        </div>

        <div class="col-md-6 col-xl-3">
            <div class="card-box tilebox-one">
                <i class="icon-rocket float-right m-0 h2 text-muted"></i>
                <h6 class="text-muted text-uppercase mt-0">Product Sold</h6>
                <h3 class="my-3" data-plugin="counterup">1,890</h3>
                <span class="badge badge-warning mr-1"> +89% </span> <span class="text-muted">Last year</span>
            </div>
        </div>
    </div>
@endsection
