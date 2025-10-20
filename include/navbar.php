    <nav class="navbar navbar-expand-sm bg-dark navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="./public/image/avatar.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill">
            </a>

            <!-- Hamberger -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Navbar -->
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Suppliers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_suppliers_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาซัพพลายเออร์</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มซัพพลายเออร์</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Shippers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_shippers_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาผู้จัดส่ง</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มผู้จัดส่ง</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Employees</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_employee_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาพนักงาน</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มพนักงาน</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Customers</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_customer_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาลูกค้า</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มลูกค้า</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Categories</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_categories_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาหมวดหมู่</a></li>
                            <li><a class="dropdown-item" href="#"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มหมวดหมู่</a></li>
                        </ul>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Products</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item " href="db_product_search.php"><i class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาสินค้า</a></li>
                            <li><a class="dropdown-item" href="crud/db_product_insert.php"><i class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มสินค้า</a></li>
                        </ul>
                    </li>

                </ul>
            </div>

        </div>
    </nav>