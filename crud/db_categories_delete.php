<?php
include_once '../include/connDB.php';

if (isset($_POST['confirm_delete']) && $_POST['confirm_delete'] == 'yes') {
    
    $cid = isset($_POST['cid']) ? (int)$_POST['cid'] : null;

    if ($cid === null || $cid === 0) {
        header('Location: ../db_categories_search.php'); 
        exit;
    }

    try {
        $sql = "DELETE FROM tb_categories WHERE i_CategoryID = :cid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':cid', $cid, PDO::PARAM_INT);
        $stmt->execute();
        header('Location: ../db_categories_search.php');
        exit;
    } catch (PDOException $e) {
        echo "Error deleting category: " . $e->getMessage();
    }

} else {
    
    $cid = isset($_POST['cid']) ? (int)$_POST['cid'] : 0;

    if ($cid === 0) {
        header('Location: ../db_categories_search.php');
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
                    <a href="../db_categories_search.php" class="btn-close btn-close-white" aria-label="Close"></a>
                </div>
                <div class="modal-body text-start">
                    <p>คุณแน่ใจหรือไม่ว่าต้องการลบ Category ID: <strong><?php echo htmlspecialchars($cid); ?></strong>?</p>
                    <p class="text-danger small">ข้อมูลนี้จะถูกลบอย่างถาวรและไม่สามารถกู้คืนได้</p>
                </div>
                <div class="modal-footer">
                    <a href="../db_categories_search.php" class="btn btn-secondary">
                        ยกเลิก
                    </a>
                    
                    <form id="deleteForm" action="" method="POST">
                        
                        <input type="hidden" name="cid" value="<?php echo htmlspecialchars($cid); ?>">
                        
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