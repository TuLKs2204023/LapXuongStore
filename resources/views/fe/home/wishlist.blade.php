@extends('fe.layout.layout')

@section('myCss')
    <style>
        .product-cart tr td .close-td.first-row a {
            color: black;
            text-decoration: none;
        }
    </style>
@endsection

@section('content')
    @if (auth()->user()->role !== 'Customer')
        <section class="section error-404 min-vh-100 d-flex flex-column align-items-center justify-content-center">
            <br>
            <br>
            <h3>Sorry ! The page you are looking only availabled for Customer !</h3>

            <img src="{{ asset('assets/img/not-found.svg') }}" class="img-fluid py-5" alt="Page Not Found">

        </section>
    @endif

    @if (auth()->user()->role == 'Customer')
        <!-- BREADCUMB SECTION BEGIN-->
        <div class="breadcrumb-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="breadcrumb-text">
                            <a href="{{ Route('fe.home') }}"><i class="fa fa-home"></i> Home</a>
                            <a href="{{ Route('fe.shop.index') }}">Shop</a>
                            <span>{{ auth()->user()->name }} Wishlist</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- BREADCUMB SECTION END-->

        <!-- Shoping-cart SECTION BEGIN-->
        <div class="shopping-cart spad">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cart-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Images</th>
                                        <th class="p-name">Product Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="products-cart">
                                    @if ($wishlistItems)
                                        @foreach ($wishlistItems as $item)
                                            <tr class="pr-cart-item" data-index="{{ $item->product->id }}">
                                                <td class="cart-pic first-row"><a
                                                        href="{{ Route('product.details', $item->product->slug) }}"><img
                                                            src="{{ asset('images/' . $item->product->oldestImage->url) }}"
                                                            alt="{{ $item->product->name }}"></a></td>
                                                <td class="cart-title first-row">
                                                    <h5>{{ $item->product->name }}</h5>
                                                </td>
                                                <td class="close-td first-row">
                                                    <i class="ti-close"></i>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="6"> {{ $errors }} </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                        <div class="row order-summary">
                            <div class="col-lg-4">
                                <div class="cart-buttons">
                                    <a href="{{ Route('fe.shop.index') }}" class="primary-btn up-cart">Click me to shop</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shoping-cart SECTION END-->
    @endif
@endsection

@section('myJs')
    <script>
        jQuery(document).ready(function($) {
            const productCart = $(".pr-cart-item");
            const headerHeart = $(".heart-icon");
            productCart.each(function(index, element) {
                const removeButton = $(element).find(".ti-close");
                $(removeButton).on("click", function(e) {
                    e.preventDefault();
                    const id = $(element).attr("data-index");
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#4154f1',
                        cancelButtonColor: 'crimson',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: "{{ Route('removeWishlist') }}",
                                type: "DELETE",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                },
                                data: {
                                    id: id,
                                },
                                success: function(response) {
                                    $(element).remove();
                                    headerHeart.find("span").html(response
                                        .totalWishlist);
                                }
                            })
                            Swal.fire(
                                'Deleted!',
                                'This comment has been deleted.',
                                'success'
                            )
                        }
                    })

                })
            })
        });
    </script>
@endsection
