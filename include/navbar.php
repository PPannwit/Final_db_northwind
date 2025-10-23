<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="./public/image/avatar.png" alt="Avatar Logo" style="width:40px;" class="rounded-pill">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">สินค้า</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_product_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาสินค้า</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_product_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มสินค้า</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">ลูกค้า</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_customers_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาลูกค้า</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_customers_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มลูกค้า</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">หมวดหมู่</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_categories_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาหมวดหมู่</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_categories_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มหมวดหมู่</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">พนักงาน</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_employees_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาพนักงาน</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_employees_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มพนักงาน</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">ผู้จัดส่ง</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_shippers_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาผู้จัดส่ง</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_shippers_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มผู้จัดส่ง</a></li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">ผู้จัดหา</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item " href="/Final_db_northwind/db_suppliers_search.php"><i
                                    class="bi bi-search"></i>&nbsp;&nbsp;&nbsp;ค้นหาผู้จัดหา</a></li>
                        <li><a class="dropdown-item" href="/Final_db_northwind/crud/db_suppliers_insert.php"><i
                                    class="bi bi-plus-circle"></i>&nbsp;&nbsp;&nbsp;เพิ่มผู้จัดหา</a></li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/Final_db_northwind/db_order_search.php">
                        <i></i>&nbsp;&nbsp;ขายสินค้า
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/Final_db_northwind/db_sales_search.php">
                        <i></i>&nbsp;&nbsp;ตรวจสอบคำสั่งซื้อ
                    </a>
                </li>

            </ul>
        </div>
    </div>
</nav>