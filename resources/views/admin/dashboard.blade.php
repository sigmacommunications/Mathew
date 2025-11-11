@extends('admin.layouts.app')

@section('content')
    <div class="animated fadeIn">
        <!-- Widgets  -->
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-1">
                                <i class="pe-7s-video"></i> <!-- Video Icon -->
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ DB::table('jokes')->count() }}</span>
                                    </div>
                                    <div class="stat-heading">Video</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-2">
                                <i class="pe-7s-box2"></i> <!-- Package Icon -->
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ DB::table('packages')->count() }}</span>
                                    </div>
                                    <div class="stat-heading">Package</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="stat-widget-five">
                            <div class="stat-icon dib flat-color-3">
                                <i class="pe-7s-user"></i> <!-- User Icon -->
                            </div>
                            <div class="stat-content">
                                <div class="text-left dib">
                                    <div class="stat-text"><span class="count">{{ DB::table('users')->count() }}</span>
                                    </div>
                                    <div class="stat-heading">Users</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="clearfix"></div>
    </div>
@endsection
