<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <!-- Dashboard Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <!-- Product Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.product.index') }}">
                <i class="bi bi-tags"></i>
                <span>Product</span>
            </a>
        </li><!-- End Product Nav -->

        <!-- Stock Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.stock.index') }}">
                <i class="bi bi-server"></i>
                <span>Stock</span>
            </a>
        </li><!-- End Stock Nav -->

        <!-- Categories Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.cate.index') }}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Categories</span>
            </a>
        </li><!-- End Categories Nav -->

        <!-- Specifications Nav -->
        <li class="nav-item">
            <a class="nav-link " href="{{Route('admin.promotion.index')}}">
                <i class="bi bi-menu-button-wide"></i>
                <span>Promotion</span>
            </a>
        </li><!-- End Promotion Nav -->

        <li class="nav-item">
            <!-- specifications header -->
            <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" aria-expanded="true"
                href="#">
                <i class="bi bi-cpu"></i><span>Specifications</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <!-- / specifications header -->

            <!-- / specifications content -->
            <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                    <!-- Manufacture sub-nav -->
                    <a href="{{ Route('admin.manufacture.index') }}">
                        <i class="bi bi-circle"></i><span>Manufacture</span>
                    </a>
                    <!--End Manufacture sub-nav -->

                    <!-- CPU sub-nav -->
                    <a href="{{ Route('admin.cpu.index') }}">
                        <i class="bi bi-circle"></i><span>CPU</span>
                    </a>
                    <!--End CPU sub-nav -->

                    <!-- RAM sub-nav -->
                    <a href="{{ Route('admin.ramGroup.index') }}">
                        <i class="bi bi-circle"></i><span>RAM</span>
                    </a>
                    <!--End RAM sub-nav -->
                </li><!-- End Specifications Nav -->

            </ul><!-- / specifications content -->

        </li><!-- End Forms Nav -->

        <hr style="opacity: 0.1;">

        <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                                             document.getElementById('logout-form').submit();">
                <i class="bi bi-box-arrow-in-left"></i>
                {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                @csrf
            </form>
        </li><!-- End Logout Page Nav -->
    </ul>

</aside>
