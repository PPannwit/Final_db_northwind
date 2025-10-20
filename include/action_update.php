<?php
include_once 'connDB.php';

print_r($_POST);

$tbName = $_POST['tb_name'];
$tbName = $_POST['action'];

switch ($tbName) {
    case 'tb_product':
        switch ($action) {
            case 'insert':
                //code
                break;
            case 'update':
                //code
                break;
        }
        //code
        $sql = "UPDATE tb_products SET 
                    c_ProductName = :param_pname , 
                    i_SupplierID  = :param_supid , 
                    i_CategoryID  = :param_catid , 
                    c_Unit        = :param_unit  ,
                    i_Price       = :param_price
                WHERE tb_products.i_ProductID = :param_pid";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':param_pname', $_POST['c_ProductName'], PDO::PARAM_STR);
        $stmt->bindValue(':param_supid', $_POST['i_SupplierID'], PDO::PARAM_INT);
        $stmt->bindValue(':param_catid', $_POST['i_CategoryID'], PDO::PARAM_INT);
        $stmt->bindValue(':param_unit', $_POST['c_Unit'], PDO::PARAM_STR);
        $stmt->bindValue(':param_price', $_POST['i_Price'], PDO::PARAM_INT);
        $stmt->bindValue(':param_pid', $_POST['i_ProductID'], PDO::PARAM_INT);
        
        try{
            $stmt->execute();
            echo $stmt->rowCount() . " records UPDATED successfully";
                header("Location: ../db_product_search.php");
        } catch(PDOException $e){
            echo "Error: " . $e->getMessage();
        }
        break;
    default:
        //code block
        break;
}
?>