<?php
include_once '../include/connDB.php';

if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
    
    // !! แก้ไข !!: รับค่า sid (Supplier ID)
    $sid = isset($_POST['sid']) ? (int)$_POST['sid'] : null;

    if ($sid === null || $sid === 0) {
        // !! แก้ไข !!: เปลี่ยน URL
        header('Location: ../db_suppliers_search.php'); 
        exit;
    }

    try {
        // !! แก้ไข !!: เปลี่ยน SQL (tb_suppliers, i_SupplierID)
        $sql = "DELETE FROM tb_suppliers WHERE i_SupplierID = :sid";
        $stmt = $pdo->prepare($sql);
        // !! แก้ไข !!: ผูกค่า :sid
        $stmt->bindValue(':sid', $sid, PDO::PARAM_INT);
        $stmt->execute();
        
        // !! แก้ไข !!: เปลี่ยน URL
        header('Location: ../db_suppliers_search.php');
        exit;
    } catch (PDOException $e) {
        // !! แก้ไข !!: เปลี่ยนข้อความ Error
        echo "Error deleting supplier: " . $e->getMessage();
    }

} else {
    
    // !! แก้ไข !!: รับค่า sid (จากหน้า search)
    $sid = isset($_POST['sid']) ? (int)$_POST['sid'] : 0;

    if ($sid === 0) {
        // !! แก้ไข !!: เปลี่ยน URL
        header('Location: ../db_suppliers_search.php');
        exit;
    }
    // ถ้า $sid มีค่า, PHP จะทำงานต่อเพื่อแสดง HTML ด้านล่าง
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ยืนยันการลบข้อมูล</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <style>
         body {
            background: #f8f9fa;
            font-family: 'Kanit', sans-serif;
        }
    </style>
</head>
<body>

    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content shadow-lg">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="confirmModalLabel">
                        <i class="bi bi-exclamation-triangle"></i> ยืนยันการลบ
                    </h5>
                    <a href="../db_suppliers_search.php" class="btn-close btn-close-white" aria-label="Close"></a>
                </div>
                <div class="modal-body text-start">
                    <p>คุณแน่ใจหรือไม่ว่าต้องการลบ Supplier ID: <strong><?php echo htmlspecialchars($sid); ?></strong>?</p>
                    <p class="text-danger small">ข้อมูลนี้จะถูกลบอย่างถาวรและไม่สามารถกู้คืนได้</p>
                </div>
                <div class="modal-footer">
                    <a href="../db_suppliers_search.php" class="btn btn-secondary">
                        ยกเลิก
                    </a>
                    
                    <form id="deleteForm" action="" method="POST">
                        
                        <input type="hidden" name="sid" value="<?php echo htmlspecialchars($sid); ?>">
                        
                        <input type="hidden" name="confirm_delete" value="yes">
                        
                        <button type="submit" class="btn btn-danger">
                            ยืนยันและลบ
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var myModalEl = document.getElementById('confirmDeleteModal');
            var myModal = new bootstrap.Modal(myModalEl, {
                backdrop: 'static', 
                keyboard: false     
            });
            myModal.show();
        });
    </script>

</body>
</html>