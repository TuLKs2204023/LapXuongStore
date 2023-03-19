<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        {{-- ---------------------------------------------------------start Dashboard section--------------------------------------------------------------------- --}}


        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        {{-- ---------------------------------------------------------end Dashboard section--------------------------------------------------------------------- --}}


        {{-- ---------------------------------------------------------start Manager and Admin section--------------------------------------------------------------------- --}}
        {{-- ---------------------------------------------------------start only Admin section--------------------------------------------------------------------- --}}
        @if (auth()->user()->role == 'Admin')
            <li class="nav-item">
                <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" aria-expanded="true"
                    href="#">
                    <i class="bi bi-person"></i><span>User Settings</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <!-- User -->
                        <a href="{{ URL::to('/all-user') }}">
                            <i class="bi bi-circle"></i><span>User List</span>
                        </a>
                        <!--End UserList -->

                        <!-- User Ratings -->
                        <a href="{{ Route('historyProduct') }}">
                            <i class="bi bi-circle"></i><span>Product History</span>
                        </a>
                        <!--End User Ratings -->

                    </li>
                </ul>
            </li><!-- End Forms Nav -->
        @endif
        {{-- ---------------------------------------------------------end only Admin section--------------------------------------------------------------------- --}}

        @if (auth()->user()->role !== 'Customer')
            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.product.index') }}">
                    <i class="bi bi-tags"></i>
                    <span>Product</span>
                </a>
            </li><!-- End Product Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.cate.index') }}">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Categories</span>
                </a>
            </li><!-- End Categories Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.promotion.index') }}">
                    <i class="bi bi-award"></i>
                    <span>Promotion</span>
                </a>
            </li><!-- End Promotion Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.discount.index') }}">
                    <i class="ri-coin-line"></i>
                    <span>Discount</span>
                </a>
            </li><!-- End Discount Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.stock.index') }}">
                    <i class="bi bi-cart"></i>
                    <span>Stock</span>
                </a>
            </li><!-- End Stock Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.order.allorders') }}">
                    <i class="bi bi-mailbox2"></i>
                    <span>Order</span>
                </a>
            </li><!-- End Order Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.rating.index') }}">
                    <i class="bi bi-hand-thumbs-up-fill"></i>
                    <span>Rating</span>
                </a>
            </li><!-- End Rating Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.wishlist.index') }}">
                    <i class="bi bi-suit-heart"></i>
                    <span>Wishlist</span>
                </a>
            </li><!-- End Rating Nav -->

            <li class="nav-item">
                <a class="nav-link" data-bs-target="#specs-nav" data-bs-toggle="collapse" aria-expanded="true"
                    href="#">
                    <i class="bi bi-cpu"></i><span>Specifications</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="specs-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <!-- Manufacture -->
                        <a href="{{ Route('admin.manufacture.index') }}">
                            <i class="bi bi-circle"></i><span>Manufacture</span>
                        </a>
                        <!--End Manufacture -->

                        <!-- Series -->
                        <a href="{{ Route('admin.series.index') }}">
                            <i class="bi bi-circle"></i><span>Series</span>
                        </a>
                        <!--End Series -->

                        <!-- Demand -->
                        <a href="{{ Route('admin.demand.index') }}">
                            <i class="bi bi-circle"></i><span>Demand</span>
                        </a>
                        <!--End Demand -->

                        <!-- CPU -->
                        <a href="{{ Route('admin.cpu.index') }}">
                            <i class="bi bi-circle"></i><span>CPU</span>
                        </a>
                        <!--End CPU -->

                        <!-- GPU -->
                        <a href="{{ Route('admin.gpu.index') }}">
                            <i class="bi bi-circle"></i><span>GPU</span>
                        </a>
                        <!--End GPU -->

                        <!-- Color -->
                        <a href="{{ Route('admin.color.index') }}">
                            <i class="bi bi-circle"></i><span>Color</span>
                        </a>
                        <!--End Color -->

                        <!-- RAM -->
                        <a href="{{ Route('admin.ramGroup.index') }}">
                            <i class="bi bi-circle"></i><span>RAM</span>
                        </a>
                        <!--End RAM -->

                        <!-- Screen -->
                        <a href="{{ Route('admin.screenGroup.index') }}">
                            <i class="bi bi-circle"></i><span>Screen</span>
                        </a>
                        <!--End Screen -->

                        <!-- Resolution -->
                        <a href="{{ Route('admin.resolution.index') }}">
                            <i class="bi bi-circle"></i><span>Resolution</span>
                        </a>
                        <!--End Resolution -->

                        <!-- HDD -->
                        <a href="{{ Route('admin.hddGroup.index') }}">
                            <i class="bi bi-circle"></i><span>HDD</span>
                        </a>
                        <!--End HDD -->

                        <!-- SSD -->
                        <a href="{{ Route('admin.ssdGroup.index') }}">
                            <i class="bi bi-circle"></i><span>SSD</span>
                        </a>
                        <!--End SSD -->
                    </li>
                </ul>
            </li>
        @endif
        {{-- ---------------------------------------------------------end Manager and Admin section--------------------------------------------------------------------- --}}

    </ul>
</aside>
