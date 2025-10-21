<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include_once 'include/connDB.php';
include_once 'include/elementMod.php'; 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

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
        function EditData(custid) {
            console.log("Edit Customer ID : " + custid);
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = './crud/db_customers_edit.php'; 

            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'custid'; 
            input.value = custid;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</head>

<body>

    <?php require_once 'include/navbar.php';
    $param_custid = isset($_POST['cond_custid']) && $_POST['cond_custid'] !== '' ? $_POST['cond_custid'] : '';

    $sql = "SELECT tb_customers.i_customerid as custid, 
                   tb_customers.c_customername as custname, 
                   tb_customers.c_contactname as contact,
                   tb_customers.c_city as city,
                   tb_customers.c_country as country
            FROM tb_customers";

    $params = [];
    if (!empty($param_custid)) {
        $sql .= " WHERE tb_customers.i_customerid = :param_custid";
        $params[':param_custid'] = $param_custid;
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);
    ?>

    <div class="container p-4">
        <h1>หน้าจอค้นหาลูกค้า</h1>


        <div id="accordion">

            <div class="card">
                <div class="card-header">
                    <a class="btn" data-bs-toggle="collapse" href="#collapseOne">
                        ตัวกรองการค้นหา
                    </a>
                </div>
                <div id="collapseOne" class="collapse show" data-bs-parent="#accordion">
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="row ">
                                <div class="col-10">
                                    <?php
                                    dropdown_db($pdo, "cond_custid", "tb_customers", "i_customerid", "c_customername", $param_custid);
                                    ?>
                                </div>
                                <div class="col-2 d-grid">
                                    <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i>&nbsp;&nbsp;ค้นหาข้อมูล</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <p></p>
        </div>
        <div class="card">
            <div class="card-header">รายการลูกค้าทั้งหมด</div>
            <div class="card-body">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Contact Name</th>
                            <th>City</th>
                            <th>Country</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($customers as $customer) { ?>
                            <tr>
                                <td><?php echo $customer['custid']; ?></td>
                                <td><?php echo $customer['custname']; ?></td>
                                <td><?php echo $customer['contact']; ?></td>
                                <td><?php echo $customer['city']; ?></td>
                                <td><?php echo $customer['country']; ?></td>
                                <td>
                                    <form action="./crud/db_customers_edit.php" method="POST">
                                        <input type="hidden" name="custid" value="<?php echo $customer['custid']; ?>">
                                        <button onclick="EditData(<?php echo $customer['custid']; ?>)" type="button" class="btn btn-warning text-white bi bi-pen fs-6"></button>
                                    </form>
                                </td>
                                <td>
                                    <form action="./crud/db_customers_delete.php" method="POST">
                                        <input type="hidden" name="custid" value="<?php echo $customer['custid']; ?>">
                                        <button type="submit" class="btn btn-danger bi bi-trash fs-6"></button>
                                    </form>
                                </td>
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