@extends('admin.layout.layout')

@section('title', '- Orders')

@section('contents')
    <!-- Start Page Title -->
    <div class="pagetitle">
        <h1>Orders List</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ Route('admin.dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Orders List</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <!-- Start Main Section -->
    <section class="section">
        <!-- card -->
        <div class="card">
            <div class="card-header">
                {{-- <a class="btn btn-outline-primary" href="#">
                    <i class="bi bi-plus-circle-fill me-1"></i>
                    Create New Orders
                </a> --}}
                <!-- Message Section -->
                @include('components.message')
                <!-- / Message Section -->
                {{-- <h3 class="card-title">DataTable with default features</h3> --}}
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table id="allOrdersMgmt" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>C.ID</th>
                            <th>Oder Date</th>
                            <th>Shipping Name</th>
                            <th>Shipping Phone</th>
                            <th>Shipping Address</th>
                            <th>Payment</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($all as $row)
                            <tr>
                                <td>{{ $row->id }}</td>
                                <td>{{ $row->user_id }}</td>
                                <td>{{ $row->order_date }}</td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->phone }}</td>
                                <td>{{ $row->address }}, {{ $row->ward }}, {{ $row->district }}, {{ $row->city }}
                                </td>
                                <td>
                                    @if ($row->payment == 1)
                                        Cash
                                    @elseif($row->payment == 2)
                                        Banking
                                    @endif
                                </td>
                                <td>@php echo $row->statusProcessing() @endphp</td>
                                <td>
                                    <a href="{{ Route('admin.order.details', $row->id) }}"
                                        class="btn btn-sm btn-outline-info">Details</a>
                                    @if ($row->status == 1)
                                        <form id="order-cancel" action="{{ Route('admin.order.cancelOrderByAdmin') }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            <input type="hidden" name="oId" value="{{ $row->id }}">
                                            <div class="btn btn-sm btn-outline-danger tu-button"
                                                data-index="{{ $row->id }}">Cancel</div>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                    <tfoot>
                    </tfoot>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </section><!-- End Main Section -->
@endsection

@section('myJs')
    <script>
        $(function() {
            $("#allOrdersMgmt").DataTable({
                "responsive": true,
                "lengthChange": true,
                "autoWidth": true,
                "aaSorting": [],
                "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
            }).buttons().container().appendTo('#allOrdersMgmt_wrapper .col-md-6:eq(0)');
        });
    </script>
    <script>
        jQuery(document).ready(function($) {
            const tuBtn = $(".tu-button");
            tuBtn.each(function(index, element){
                $(element).on("click", function(e){
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this, once cancelled Customer's promotion code won't be returned back anymore!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4154f1',
                        cancelButtonColor: 'crimson',
                        confirmButtonText: 'Yes, cancel it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $(element).html('<div class="spinner-border spinner-border-sm"></div> Processing');
                            Swal.fire(
                                'Cancelling!',
                                'Your cancellation is processing, please wait for a few seconds.',
                                'info',
                            )
                            $('#order-cancel').submit();
                        }})
                })
            })
        })
    </script>
@endsection
