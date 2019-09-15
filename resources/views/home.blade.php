@extends('layouts.app')

@push('headers')
   <header class="head">
                                <div class="search-bar">
                                    <form class="main-search" action="">
                                        <div class="input-group">
                                            <input type="text" class="form-control" placeholder="Live Search ...">
                                            <span class="input-group-btn">
                                                <button class="btn btn-primary btn-sm text-muted" type="button">
                                                    <i class="fa fa-search"></i>
                                                </button>
                                            </span>
                                        </div>
                                    </form>
                                    <!-- /.main-search -->                                </div>
                                <!-- /.search-bar -->
                            <div class="main-bar">
                                <h3>
              <i class="fa fa-dashboard"></i>&nbsp;
            Dashboard
          </h3>
                            </div>
                            <!-- /.main-bar -->
                        </header>
@endpush
@section('content')

   
                   
                        <!-- ============================================================== -->
                        <!-- end influencer profile  -->
                        <!-- ============================================================== -->
                        <!-- ============================================================== -->
                        <!-- widgets   -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- four widgets   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total views   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Employee</h5>
                                            <h2 class="mb-0"> 1000</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-info-light mt-1">
                                            <i class="fa fa-eye fa-fw fa-sm text-info"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end total views   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total followers   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Absent</h5>
                                            <h2 class="mb-0"> 22</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-primary-light mt-1">
                                            <i class="fa fa-user fa-fw fa-sm text-primary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end total followers   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- partnerships   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Permit</h5>
                                            <h2 class="mb-0">14</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-secondary-light mt-1">
                                            <i class="fa fa-handshake fa-fw fa-sm text-secondary"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end partnerships   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- total earned   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-inline-block">
                                            <h5 class="text-muted">Total Leave</h5>
                                            <h2 class="mb-0">10</h2>
                                        </div>
                                        <div class="float-right icon-circle-medium  icon-box-lg  bg-brand-light mt-1">
                                            <i class="fa fa-money-bill-alt fa-fw fa-sm text-brand"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end total earned   -->
                            <!-- ============================================================== -->
                        </div>
                        <!-- ============================================================== -->
                        <!-- end widgets   -->
                        <!-- ============================================================== -->
                        <div class="row">
                            <!-- ============================================================== -->
                            <!-- followers by gender   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Late Chart</h5>
                                    <div class="card-body">
                                        <div id="gender_donut" style="height: 230px;"></div>
                                    </div>
                                    <div class="card-footer p-0 bg-white d-flex">
                                        <div class="card-footer-item card-footer-item-bordered w-50">
                                            <h2 class="mb-0"> 10% </h2>
                                            <p>Late </p>
                                        </div>
                                        <div class="card-footer-item card-footer-item-bordered">
                                            <h2 class="mb-0">90% </h2>
                                            <p>Good</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end followers by gender  -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- followers by age   -->
                            <!-- ============================================================== -->
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-12">
                                <div class="card">
                                    <h5 class="card-header">Permission Chart</h5>
                                    <div class="card-body">
                                        <canvas id="chartjs_bar"></canvas>
                                    </div>
                                </div>
                            </div>
                            <!-- ============================================================== -->
                            <!-- end followers by age   -->
                            <!-- ============================================================== -->
                            <!-- ============================================================== -->
                            <!-- followers by locations   -->
                            <!-- ============================================================== -->
                           
                            <!-- ============================================================== -->
                            <!-- end followers by locations  -->
                            <!-- ============================================================== -->
                        </div>
                        


@endsection
