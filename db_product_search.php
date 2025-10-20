<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';

// $products = dropdown_db($pdo);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- BS5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- GG Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
        body {
            background: #2A7B9B;
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }

        h1 {
            color: white;
        }
    </style>
    <script>
        function EditData(pid) {
            console.log("Edit Product ID : " + pid);
            const form = document.createElement('form');
            form.m
            form.method = 'POST';
            form.action = './crud/db_product_edit.php';

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'pid';
            input.value = pid;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>

    <?php require_once 'include/navbar.php';

    $param_catid = isset($_POST['cond_catid']) && $_POST['cond_catid'] !== '' ? $_POST['cond_catid'] : 1;
    $param_price = isset($_POST['cond_price']) && $_POST['cond_price'] !== '' ? $_POST['cond_price'] : 10;

    $sql = "SELECT tb_products.i_ProductID as pid, tb_products.c_ProductName as pname, tb_products.i_Price as pprice
            FROM tb_products
            WHERE tb_products.i_CategoryID = :param_catid
            AND tb_products.i_Price >= :param_price;";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([
        ':param_catid' => $param_catid,
        ':param_price' => $param_price,
    ]);

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาสินค้า</h1>


        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                        ตัวกรองการค้นหา
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <!-- FORM FILTER -->
                        <form action="db_product_search.php" method="POST">
                            <div class="row ">
                                <div class="col-5">
                                    <!-- <input type="text" class="form-control" placeholder="หมวดหมู่สินค้าที่ค้นหา" name="cond_catid"> -->
                                    <?php
                                    // dropdown_db($pdo,"cond_catid","tb_categories","i_CategoryID","c_CategoryName");
                                    dropdown_db($pdo, "cond_catid", "tb_suppliers", "i_SupplierID", "c_SupplierName");

                                    ?>

                                </div>
                                <div class="col-5">
                                    <input type="number" class="form-control" placeholder="ราคาสินค้าที่ค้นหา" name="cond_price">
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i>&nbsp;&nbsp;ค้นหาข้อมูล</button>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM FILTER -->
                    </div>
                </div>
            </div>

            <p></p>
        </div>
        <div class="card">
            <div class="card-header">รายการสินค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Product ID</th>
                            <th>Product Name</th>
                            <th>Product Price</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($products as $product) { ?>
                            <tr>
                                <td><?php echo $product['pid']; ?></td>
                                <td><?php echo $product['pname']; ?></td>
                                <td><?php echo $product['pprice']; ?></td>
                                <td>
                                    <!-- Form Method POST -->
                                    <form action="./crud/db_product_edit.php" method="POST">
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                        <button onclick="EditData(<?php echo $product['pid']; ?>)" type="button" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <!-- Form Method POST -->
                                    <form action="./crud/db_product_delete.php" method="POST">
                                        <input type="hidden" name="pid" value="<?php echo $product['pid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>

                                <!-- Call Function -->
                                <!-- <td>
                                    <button onclick="EditData(<?= $product['pid']; ?>)" type="button" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                </td> -->
                                
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                <ul class="pagination justify-content-end">
                    <li class="page-item"><a class="page-link text-black " href="#">Previous</a></li>
                    <li class="page-item"><a class="page-link text-black active" href="#">1</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">2</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">3</a></li>
                    <li class="page-item"><a class="page-link text-black" href="#">Next</a></li>
                </ul>
            </div>
        </div>
    </div>

</body>

</html>