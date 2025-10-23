<?php
include_once '../include/connDB.php';
include_once '../include/funcMod.php';
include_once '../include/elementMod.php';

$shipper = getEdit($pdo, 'tb_shippers', 'i_ShipperID', $_REQUEST['sid']);
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลผู้จัดส่ง</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        body {
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>

<body>
    <?php require_once '../include/navbar.php'; ?>

    <div class="container d-flex align-items-center justify-content-center" style="min-height:90vh;">
        <div class="card w-75 shadow-lg border-0">
            <!-- Header -->
            <div class="card-header text-center" style="background-color: white;">
                <h2 class="mb-0" style="color: black;">แก้ไขข้อมูลผู้จัดส่ง</h2>
            </div>

            <!-- Form Body -->
            <div class="card-body">
                <form id="editForm" action="../include/action.php" method="post">
                    <input type="hidden" name="tb_name" value="tb_shippers">
                    <input type="hidden" name="action" value="update">

                    <?= input_text("i_ShipperID", "รหัสผู้จัดส่ง", "number", $shipper["i_ShipperID"], "รหัสอัตโนมัติ", true); ?>
                    <?= input_text("c_ShipperName", "ชื่อผู้จัดส่ง", "text", $shipper["c_ShipperName"], "กรุณากรอกชื่อผู้จัดส่ง"); ?>
                    <?= input_text("c_Phone", "เบอร์โทร", "text", $shipper["c_Phone"], "กรุณากรอกเบอร์โทร"); ?>

                    <div class="text-center mt-4">
                        <a href="../db_shippers_search.php" class="btn btn-secondary me-2">ย้อนกลับ</a>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#confirmModal">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>

            <!-- Modal ยืนยันการบันทึก -->
            <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content shadow-lg border-0">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="confirmModalLabel">ยืนยันการบันทึก</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body">
                            <p class="mb-2">คุณต้องการบันทึกการเปลี่ยนแปลงข้อมูลผู้จัดส่งหรือไม่?</p>
                            <div class="small text-muted">ตรวจสอบข้อมูลให้ถูกต้องก่อนกด "ยืนยัน"</div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                            <button id="confirmSaveBtn" type="button" class="btn btn-primary">ยืนยันและบันทึก</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const confirmBtn = document.getElementById('confirmSaveBtn');
            const form = document.getElementById('editForm');
            if (confirmBtn && form) {
                confirmBtn.addEventListener('click', () => {
                    confirmBtn.disabled = true;
                    confirmBtn.innerHTML = '⏳ กำลังบันทึก...';
                    form.submit();
                });
            }
        });
    </script>
</body>
</html>
