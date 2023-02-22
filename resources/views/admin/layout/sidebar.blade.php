<aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link " href="{{ Route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

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
            <a class="nav-link" data-bs-target="#components-nav" data-bs-toggle="collapse" aria-expanded="true"
                href="#">
                <i class="bi bi-cpu"></i><span>Specifications</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="components-nav" class="nav-content collapse show" data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{Route('admin.manufacture.index')}}">
                        <i class="bi bi-circle"></i><span>Manufacture</span>
                    </a>
                    <a href="{{Route('admin.cpu.index')}}">
                        <i class="bi bi-circle"></i><span>CPU</span>
                    </a>

                    <a href="{{Route('admin.stock.index')}}">
                        <i class="bi bi-circle"></i><span>Stock</span>
                    </a>
                    <a href="{{Route('admin.ramGroup.index')}}">
                        <i class="bi bi-circle"></i><span>RAM</span>

                    </a>
                </li>

            </ul>
        </li><!-- End Forms Nav -->

        <li class="nav-heading">Pages</li>

        <li class="nav-item">
            <a class="nav-link collapsed" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>Profile</span>
            </a>
        </li><!-- End Profile Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>F.A.Q</span>
            </a>
        </li><!-- End F.A.Q Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-contact.html">
                <i class="bi bi-envelope"></i>
                <span>Contact</span>
            </a>
        </li><!-- End Contact Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-register.html">
                <i class="bi bi-card-list"></i>
                <span>Register</span>
            </a>
        </li><!-- End Register Page Nav -->

        <li class="nav-item">
            <a class="nav-link collapsed" href="pages-login.html">
                <i class="bi bi-box-arrow-in-right"></i>
                <span>Login</span>
            </a>
        </li><!-- End Login Page Nav -->
    </ul>

</aside>
