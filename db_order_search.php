<?php
include_once 'include/connDB.php';
include_once 'include/elementMod.php';
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ออกการขายสินค้า</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'Kanit', sans-serif;
            background: linear-gradient(90deg, rgba(42, 123, 155, 1) 7%, rgb(3, 72, 193) 50%, rgb(2, 151, 192) 100%);
        }

        h1 {
            color: white;
        }

        .card {
            border-radius: 15px;
        }
    </style>
</head>

<body>
    <?php require_once 'include/navbar.php'; ?>

    <div class="container p-4">
        <h1>ออกการขายสินค้า</h1>

        <form id="orderForm" action="./crud/db_order_add.php" method="POST">
            <div class="card p-4">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label class="form-label">เลขที่การขายสินค้า (Order ID)</label>
                        <input type="text" class="form-control" name="i_OrderID" placeholder="Auto Generate" readonly>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">วันที่ขาย</label>
                        <input type="text" class="form-control" name="c_OrderDate" value="<?php echo date('j/n/Y'); ?>"
                            readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label class="form-label">ชื่อพนักงานขาย</label>
                        <?php dropdown_db($pdo, "i_EmployeeID", "tb_employees", "i_EmployeeID", "c_FirstName", ""); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ชื่อลูกค้า</label>
                        <?php dropdown_db($pdo, "i_CustomerID", "tb_customers", "i_CustomerID", "c_CustomerName", ""); ?>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">ชื่อบริษัทขนส่ง (Shipper)</label>
                        <?php dropdown_db($pdo, "i_ShipperID", "tb_shippers", "i_ShipperID", "c_ShipperName", ""); ?>
                    </div>
                </div>
                <hr>
                <h5>รายการสินค้า</h5>
                <table class="table table-bordered text-center align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>สินค้า</th>
                            <th>จำนวน</th>
                            <th>รายละเอียด / ลบ</th>
                        </tr>
                    </thead>
                    <tbody id="productTable">
                        <tr>
                            <td>
                                <?php dropdown_db($pdo, "i_ProductID[]", "tb_products", "i_ProductID", "c_ProductName", ""); ?>
                            </td>
                            <td>
                                <input type="text" name="i_Quantity[]" class="form-control" required
                                    oninput="this.value=this.value.replace(/[^0-9]/g,'');">
                            </td>
                            <td>
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeRow(this)">
                                    <i class="bi bi-trash fs-5"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end mb-3">
                    <button type="button" class="btn btn-success btn-sm" id="addRowBtn">
                        <i class="bi bi-plus"></i> เพิ่มสินค้า
                    </button>
                    <button type="button" class="btn btn-primary ms-2 btn-sm" data-bs-toggle="modal"
                        data-bs-target="#confirmModal">
                        <i class="bi bi-check-circle"></i> ยืนยันการสั่งซื้อ
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="confirmModalLabel">ยืนยันการสั่งซื้อ</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p class="mb-2">คุณต้องการบันทึกการสั่งซื้อสินค้าหรือไม่?</p>
                    <div class="small text-muted">ตรวจสอบข้อมูลให้ถูกต้องก่อนกด "ยืนยัน"</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ยกเลิก</button>
                    <button id="confirmSaveBtn" type="button" class="btn btn-primary">ยืนยันและบันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="limitModal" tabindex="-1" aria-labelledby="limitModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title d-flex align-items-center" id="limitModalLabel">
                        <i class="bi bi-exclamation-triangle-fill me-2 fs-4"></i>
                        จำนวนรายการเกินกำหนด
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-exclamation-circle-fill text-warning fs-1"></i>
                    </div>
                    <p class="mb-0">ไม่สามารถเพิ่มสินค้าเกิน 10 รายการ</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ตกลง</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="minRowModal" tabindex="-1" aria-labelledby="minRowModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg border-0">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title d-flex align-items-center" id="minRowModalLabel">
                        <i class="bi bi-info-circle-fill me-2 fs-4"></i>
                        รายการต้องมีอย่างน้อย 1 รายการ
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body text-center">
                    <div class="mb-2">
                        <i class="bi bi-slash-circle-fill text-danger fs-1"></i>
                    </div>
                    <p class="mb-0">ต้องมีอย่างน้อย 1 รายการสินค้าในออเดอร์</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">ตกลง</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById("confirmSaveBtn").addEventListener("click", function () {
            document.getElementById("orderForm").submit();
        });
        document.getElementById("addRowBtn").addEventListener("click", function () {
            const table = document.getElementById("productTable");
            const rowCount = table.rows.length;
            if (rowCount >= 10) {
                const limitModalEl = document.getElementById('limitModal');
                const limitModal = new bootstrap.Modal(limitModalEl);
                limitModal.show();
                return;
            }

            const newRow = table.rows[0].cloneNode(true);
            newRow.querySelectorAll("input").forEach(input => input.value = "");
            newRow.querySelectorAll("select").forEach(sel => sel.selectedIndex = 0);
            table.appendChild(newRow);
        });
        function removeRow(btn) {
            const table = document.getElementById("productTable");
            if (table.rows.length > 1) {
                btn.closest("tr").remove();
            } else {
                const minRowModalEl = document.getElementById('minRowModal');
                const minRowModal = new bootstrap.Modal(minRowModalEl);
                minRowModal.show();
            }
        }
    </script>

</body>

</html>