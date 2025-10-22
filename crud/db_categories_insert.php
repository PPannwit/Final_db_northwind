<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$NewID = getNewID($pdo, "tb_categories", "i_CategoryID");
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มหมวดหมู่สินค้า</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(90deg, rgba(42,123,155,1) 7%, rgb(3,72,193) 50%, rgb(2,151,192) 100%);
            font-family: 'Kanit', sans-serif;
        }
        h2 { color: white; }
    </style>
</head>
<body>
<?php require_once '../include/navbar.php'; ?>
<div class="container d-flex align-items-center justify-content-center" style="min-height: 90vh;">
    <div class="card w-75 shadow-lg">
        <div class="card-header text-center bg-primary text-white"><h2>เพิ่มหมวดหมู่สินค้า</h2></div>
        <div class="card-body">
            <form action="../include/action.php" method="post">
                <input type="hidden" name="tb_name" value="tb_categories">
                <input type="hidden" name="action" value="insert">

                <?= input_text("i_CategoryID", "รหัสหมวดหมู่", "number", $NewID, "รหัสหมวดหมู่อัตโนมัติ", true); ?>
                <?= input_text("c_CategoryName", "ชื่อหมวดหมู่", "text", null, "กรุณากรอกชื่อหมวดหมู่"); ?>
                <?= input_text("c_Description", "รายละเอียด", "text", null, "คำอธิบายเพิ่มเติม (ถ้ามี)"); ?>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success">เพิ่มข้อมูล</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
