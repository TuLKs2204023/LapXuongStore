@extends('admin.layout.layout')

@section('contents')
    @if (auth()->user()->role == 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">

            <h2>Sorry ! The page you are looking only availabled for Admin and Manager !</h2>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">
        </section>
    @endif
    @if (auth()->user()->role !== 'Customer')
        <div class="pagetitle">
            <h1>Welcome to LapXuongShop , {{ auth()->user()->name }} </h1>
            <nav>
                <ol class="breadcrumb">
                    <li class="breadcrumb-item active"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                    <li class="breadcrumb-item active">{{ auth()->user()->name }} - Dashboard</li>
                </ol>
            </nav>
        </div><!-- End Page Title -->

        <section class="section dashboard">
            <div class="row">
                @if (auth()->user()->role == 'Admin')
                    <!-- Left side columns -->
                    <div class="col-lg-8">
                        <div class="row">

                            <!-- Sales Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card sales-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Sales <span>| This Month</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-cart"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $totalItem }}</h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">12%</span> --}}
                                                <span class="text-muted small pt-2 ps-1">Orders</span>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- End item Card -->

                            <!-- Revenue Card -->
                            <div class="col-xxl-4 col-md-6">
                                <div class="card info-card revenue-card">
                                    <div class="card-body">
                                        <h5 class="card-title">All Product</h5>
                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bx bx-laptop"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $totalProduct }}</h6>
                                                {{-- <span class="text-success small pt-1 fw-bold">8%</span> --}}
                                                <span class="text-muted small pt-2 ps-1">Products</span>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div><!-- Product Card -->

                            <!-- Customers Card -->
                            <div class="col-xxl-4 col-xl-12">

                                <div class="card info-card customers-card">
                                    <div class="card-body">
                                        <h5 class="card-title">Users <span>| This Month</span></h5>

                                        <div class="d-flex align-items-center">
                                            <div
                                                class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people"></i>
                                            </div>
                                            <div class="ps-3">
                                                <h6>{{ $totalUser }}</h6>
                                                {{-- <span class="text-danger small pt-1 fw-bold">12%</span> --}}
                                                <span class="text-muted small pt-2 ps-1">Customer</span>

                                            </div>
                                        </div>

                                    </div>
                                </div>

                            </div><!-- End Customers Card -->

                            <!-- Reports -->
                            <div class="col-12">
                                <div class="card">

                                    {{-- <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div> --}}

                                    <div class="card-body">
                                        <h5 class="card-title">Reports of 7 Days </h5>
                                        <!-- Line Chart -->
                                        <div id="reportsChart"></div>
                                        <script>
                                            let day = @php echo json_encode($dayData); @endphp;
                                            let revenue = @php echo json_encode($revenue); @endphp;
                                            let product = @php echo json_encode($productData); @endphp;
                                            let interaction = @php echo json_encode($interaction); @endphp;
                                            console.log(day);
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new ApexCharts(document.querySelector("#reportsChart"), {
                                                    series: [{
                                                        name: 'Qty laptop saled',
                                                        data: product,
                                                    }, {
                                                        name: 'Revenue',
                                                        data: revenue,
                                                    }, {
                                                        name: 'Qty Customer Interaction',
                                                        data: interaction,
                                                    }],
                                                    chart: {
                                                        height: 350,
                                                        type: 'area',
                                                        toolbar: {
                                                            show: false
                                                        },
                                                    },
                                                    markers: {
                                                        size: 4
                                                    },
                                                    colors: ['#4154f1', '#2eca6a', '#ff771d'],
                                                    fill: {
                                                        type: "gradient",
                                                        gradient: {
                                                            shadeIntensity: 1,
                                                            opacityFrom: 0.3,
                                                            opacityTo: 0.4,
                                                            stops: [0, 90, 100]
                                                        }
                                                    },
                                                    dataLabels: {
                                                        enabled: false
                                                    },
                                                    stroke: {
                                                        curve: 'smooth',
                                                        width: 2
                                                    },
                                                    xaxis: {
                                                        type: 'datetime',
                                                        // categories: ["2018-09-19T00:00:00.000Z",
                                                        //             "2018-09-19T01:30:00.000Z",
                                                        //             "2018-09-19T02:30:00.000Z",
                                                        //             "2018-09-19T03:30:00.000Z",
                                                        //             "2018-09-19T04:30:00.000Z",
                                                        //             "2018-09-19T05:30:00.000Z",
                                                        //             "2018-09-19T06:30:00.000Z"]
                                                        categories: day,
                                                    },
                                                    tooltip: {
                                                        x: {
                                                            format: 'dd/MM/yy HH:mm'
                                                        },
                                                    }
                                                }).render();
                                            });
                                        </script>
                                        <!-- End Line Chart -->
                                    </div>
                                </div>
                            </div><!-- End Reports -->
                            <!-- Recent Sales -->
                            <div class="col-12">
                                <div class="card recent-sales overflow-auto">
                                    {{-- <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div> --}}
                                    <div class="card-body">
                                        <h5 class="card-title">Recent Sales
                                            <span>
                                                {{ count($orderWarning) > 0 ? '' : '|Yesterday ,we dont have any orders to process.' }}
                                            </span>
                                        </h5>
                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Day</th>
                                                    <th scope="col">Customer</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                @foreach ($order as $key => $item)
                                                    @foreach ($item->details as $ip)
                                                        <tr>
                                                            <th scope="row"> {{ $item->created_at->format('d/m/Y') }}
                                                            </th>
                                                            <td>{{ $item->name }}</td>
                                                            <td><a href="{{ Route('product.details', $ip->product->slug) }}"
                                                                    class="text-primary fw-bold">{{ $ip->product->name }}</a>
                                                            </td>
                                                            <td>{{ number_format($ip->product->salePrice(), 0, ',', '.') }}
                                                            </td>
                                                            <td>
                                                                <span>
                                                                    @php
                                                                        echo $item->statusProcessing();
                                                                    @endphp
                                                                </span>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div><!-- End Recent Sales -->

                            <!-- Top Selling -->
                            <div class="col-12">
                                <div class="card top-selling overflow-auto">

                                    {{-- <div class="filter">
                                    <a class="icon" href="#" data-bs-toggle="dropdown"><i
                                            class="bi bi-three-dots"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                        <li class="dropdown-header text-start">
                                            <h6>Filter</h6>
                                        </li>

                                        <li><a class="dropdown-item" href="#">Today</a></li>
                                        <li><a class="dropdown-item" href="#">This Month</a></li>
                                        <li><a class="dropdown-item" href="#">This Year</a></li>
                                    </ul>
                                </div> --}}

                                    <div class="card-body pb-0">
                                        <h5 class="card-title">Top Selling </h5>

                                        <table class="table table-borderless datatable">
                                            <thead>
                                                <tr>
                                                    <th scope="col">Preview</th>
                                                    <th scope="col">Product</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Sold</th>
                                                    <th scope="col">Revenue</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($allproduct as $key => $row)
                                                    <tr>
                                                        <th scope="row"><a
                                                                href="{{ Route('product.details', $row->slug) }}"><img
                                                                    src="{{ isset($row->oldestImage->url) ? asset('images/' . $row->oldestImage->url) : '' }}"
                                                                    alt=""></a></th>
                                                        <td><a href="{{ Route('product.details', $row->slug) }}"
                                                                class="text-primary fw-bold">{{ $row->name }}</a></td>
                                                        <td>{{ number_format($row->salePrice(), 0, ',', '.') }}</td>
                                                        <td class="fw-bold">{{ $row->topSale() }}</td>
                                                        <td>{{ number_format($row->revenue(), 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                    </div>

                                </div>
                            </div><!-- End Top Selling -->

                        </div>
                    </div><!-- End Left side columns -->

                    <!-- Right side columns -->
                    <div class="col-lg-4">
                        <!-- Recent Users Activity -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Users Activity
                                    <span> {{ count($userWarning) > 0 ? '' : 'Yesterday, we dont have any history.' }}
                                    </span>
                                </h5>
                                <div class="activity"
                                    style="
                                        height: 300px;
                                        overflow: auto;">
                                    @foreach ($history as $key => $val)
                                        <div class="activity-item d-flex">
                                            <div class="activite-label" style="word-wrap:break-word;">{{ $val->time() }}
                                            </div>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                            <div class="activity-content">
                                                <p class="fw-bold text-dark" style="margin-block-end:0.5em;">
                                                    <span class="fw-light">{{ $val->user->name }}</span>
                                                    {{ $val->action }}
                                                    {{ $val->by }}
                                                    {{ isset($var->created_at) ? '' : '' }}
                                                </p>
                                                {{ $val->data }}
                                            </div>
                                        </div><!-- End activity item-->
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <!-- End Recent Users Activity -->

                        <!-- Recent Manager Activity -->
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Products Change
                                    <span> {{ count($productWarning) > 0 ? '' : 'Yesterday, we dont have any history.' }}
                                    </span>
                                </h5>
                                <div class="activity"
                                    style="
                                    height: 300px;
                                    overflow: auto;">
                                    @foreach ($historyProduct as $key => $pro)
                                        <div class="activity-item d-flex">
                                            <div class="activite-label" style="word-wrap:break-word;">
                                                {{ $pro->timePro() }}
                                            </div>
                                            <i class='bi bi-circle-fill activity-badge text-success align-self-start'></i>
                                            <div class="activity-content">
                                                <p class="fw-bold text-dark" style="margin-block-end:0.5em;">
                                                    <span class="fw-light">{{ $pro->user->name }}</span>
                                                    {{ $pro->action }}
                                                    <a href="{{ isset($pro->product) ? Route('product.details', $pro->product->slug) : '' }}"
                                                        class="fw-light text-dark">
                                                        <span
                                                            class="fw-light">{{ isset($pro->product) ? $pro->product->name : '' }}</span>
                                                    </a>
                                                    {{ $pro->by }}
                                                </p>

                                                <a class="fw-light text-dark"
                                                    href="{{ isset($pro->product) ? Route('product.details', $pro->product->slug) : '' }}">{{ $pro->data }}</a>
                                            </div>
                                        </div><!-- End activity item-->
                                    @endforeach

                                </div>

                            </div>
                        </div>

                        <!-- End Recent Manager Activity -->

                        <!-- Product Manufacture -->
                        <div class="card">
                            <div class="card-body pb-0">
                                <h5 class="card-title">Manufacture of Products</h5>
                                <div id="trafficChart" style="min-height: 400px;" class="echart"></div>
                                <script>
                                    let data = @php echo json_encode($dataManu); @endphp;
                                    document.addEventListener("DOMContentLoaded", () => {
                                        echarts.init(document.querySelector("#trafficChart")).setOption({
                                            tooltip: {
                                                trigger: 'item'
                                            },
                                            legend: {
                                                top: '5%',
                                                left: 'center'
                                            },
                                            series: [{
                                                name: 'Quantity of products',
                                                type: 'pie',
                                                radius: ['40%', '70%'],
                                                avoidLabelOverlap: false,
                                                label: {
                                                    show: false,
                                                    position: 'center'
                                                },
                                                emphasis: {
                                                    label: {
                                                        show: true,
                                                        fontSize: '18',
                                                        fontWeight: 'bold'
                                                    }
                                                },
                                                labelLine: {
                                                    show: false
                                                },
                                                data: data
                                            }]
                                        });
                                    });
                                </script>

                            </div> <!-- End Product Manufacture -->
                        </div><!-- End Website Traffic -->

                    </div><!-- End Right side columns -->
                @endif
            </div>
        </section>
        <section class="section dashboard">
            @if (auth()->user()->role == 'Manager')
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            @endif
        </section>
    @endif
@endsection
