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


        {{-- ---------------------------------------------------------start Manager section--------------------------------------------------------------------- --}}

        @if (auth()->user()->role == 'Manager')
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
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Promotion</span>
                </a>
            </li><!-- End Promotion Nav -->

            <li class="nav-item">
                <a class="nav-link " href="{{ Route('admin.stock.index') }}">
                    <i class="bi bi-menu-button-wide"></i>
                    <span>Stock</span>
                </a>
            </li><!-- End Promotion Nav -->

            <li class="nav-item">
                <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" aria-expanded="true"
                    href="#">
                    <i class="bi bi-cpu"></i><span>Specifications</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                    <li>
                        <!-- Manufacture -->
                        <a href="{{ Route('admin.manufacture.index') }}">
                            <i class="bi bi-circle"></i><span>Manufacture</span>
                        </a>
                        <!--End Manufacture -->
                        <!-- CPU -->
                        <a href="{{ Route('admin.cpu.index') }}">
                            <i class="bi bi-circle"></i><span>CPU</span>
                        </a>
                        <!--End CPU -->
                        <!-- RAM -->
                        <a href="{{ Route('admin.ramGroup.index') }}">
                            <i class="bi bi-circle"></i><span>RAM</span>
                        </a>
                        <!--End RAM -->
                    </li>
        @endif
        {{-- ---------------------------------------------------------end Manager section--------------------------------------------------------------------- --}}



        {{-- ---------------------------------------------------------start Admin section--------------------------------------------------------------------- --}}

        @if (auth()->user()->role == 'Admin')
            <li class="nav-item">
                <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" aria-expanded="true"
                    href="#">
                    <i class="bi bi-person-check-fill"></i><span>User Setting</span>
                    <i class="bi bi-chevron-double-down ms-auto"></i>
                    {{-- <i class="bi bi-chevron-down ms-auto"></i> --}}
                </a>
                <ul id="components-nav" class="nav-content collapse" data-bs-parent="#sidebar-nav">
                    <li>
                        <!-- User -->
                        <a href="{{ URL::to('/all-user') }}">
                            <i class="bi bi-circle"></i><span>User List</span>
                        </a>
                        <!--End UserList -->
                        <!-- User Orders -->
                        <a href="{{ URL::to('/allorders') }}">
                            <i class="bi bi-circle"></i><span>User Orders</span>
                        </a>
                        <!--End User Orders -->
                        <!-- User Ratings -->
                        <a href="{{ Route('admin.rating.index') }}">
                            <i class="bi bi-circle"></i><span>User Ratings</span>
                        </a>
                        <!--End User Ratings -->

                    </li>
                </ul>
            </li><!-- End Forms Nav -->
        @endif

        {{-- ---------------------------------------------------------end Admin section--------------------------------------------------------------------- --}}

    </ul>
</aside>
