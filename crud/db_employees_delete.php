<?php
include_once '../include/connDB.php';

if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
    
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : null;

    if ($eid === null || $eid === 0) {
        header('Location: ../db_employees_search.php'); 
        exit;
    }

    try {
        $sql = "DELETE FROM tb_employees WHERE i_EmployeeID = :eid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':eid', $eid, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ../db_employees_search.php');
        exit;
    } catch (PDOException $e) {
        echo "Error deleting employee: " . $e->getMessage();
    }

} else {
    
    $eid = isset($_POST['eid']) ? (int)$_POST['eid'] : 0;

    if ($eid === 0) {
        header('Location: ../db_employees_search.php');
        exit;
    }
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
                    <a href="../db_employees_search.php" class="btn-close btn-close-white" aria-label="Close"></a>
                </div>
                <div class="modal-body text-start">
                    <p>คุณแน่ใจหรือไม่ว่าต้องการลบ Employee ID: <strong><?php echo htmlspecialchars($eid); ?></strong>?</p>
                    <p class="text-danger small">ข้อมูลนี้จะถูกลบอย่างถาวรและไม่สามารถกู้คืนได้</p>
                </div>
                <div class="modal-footer">
                    <a href="../db_employees_search.php" class="btn btn-secondary">
                        ยกเลิก
                    </a>
                    
                    <form id="deleteForm" action="" method="POST">
                        
                        <input type="hidden" name="eid" value="<?php echo htmlspecialchars($eid); ?>">
                        
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