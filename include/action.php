<?php
include_once 'connDB.php';

print_r($_POST);

$tbName = $_POST['tb_name'];
$action = $_POST['action'];

switch ($tbName) {
    case 'tb_product':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_products (c_ProductName, i_SupplierID, i_CategoryID, c_Unit, i_Price) 
                        VALUES (:param_pname, :param_supid, :param_catid, :param_unit, :param_price)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_pname', $_POST['c_ProductName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_supid', $_POST['i_SupplierID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_catid', $_POST['i_CategoryID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_unit', $_POST['c_Unit'], PDO::PARAM_STR);
                $stmt->bindValue(':param_price', $_POST['i_Price'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo "New record created successfully";
                    header("Location: ../db_product_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
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

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_product_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
                
            case 'delete':
                $sql = "DELETE FROM tb_products WHERE i_ProductID = :param_pid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_pid', $_POST['i_ProductID'], PDO::PARAM_INT);
                
                try{
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_product_search.php");
                } catch(PDOException $e){
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
        break;

    case 'tb_customers':
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO tb_customers (c_customername, c_contactname, c_address, c_city, c_postalcode, c_country) 
                        VALUES (:c_customername, :c_contactname, :c_address, :c_city, :c_postalcode, :c_country)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':c_customername', $_POST['c_customername'], PDO::PARAM_STR);
                $stmt->bindValue(':c_contactname', $_POST['c_contactname'], PDO::PARAM_STR);
                $stmt->bindValue(':c_address', $_POST['c_address'], PDO::PARAM_STR);
                $stmt->bindValue(':c_city', $_POST['c_city'], PDO::PARAM_STR);
                $stmt->bindValue(':c_postalcode', $_POST['c_postalcode'], PDO::PARAM_STR);
                $stmt->bindValue(':c_country', $_POST['c_country'], PDO::PARAM_STR);

                try {
                    $stmt->execute();
                    echo "New record created successfully";
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_customers SET 
                            c_customername = :c_customername, 
                            c_contactname = :c_contactname, 
                            c_address = :c_address, 
                            c_city = :c_city, 
                            c_postalcode = :c_postalcode, 
                            c_country = :c_country 
                        WHERE i_customerid = :i_customerid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':c_customername', $_POST['c_customername'], PDO::PARAM_STR);
                $stmt->bindValue(':c_contactname', $_POST['c_contactname'], PDO::PARAM_STR);
                $stmt->bindValue(':c_address', $_POST['c_address'], PDO::PARAM_STR);
                $stmt->bindValue(':c_city', $_POST['c_city'], PDO::PARAM_STR);
                $stmt->bindValue(':c_postalcode', $_POST['c_postalcode'], PDO::PARAM_STR);
                $stmt->bindValue(':c_country', $_POST['c_country'], PDO::PARAM_STR);
                $stmt->bindValue(':i_customerid', $_POST['i_customerid'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                $sql = "DELETE FROM tb_customers WHERE i_customerid = :i_customerid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':i_customerid', $_POST['i_customerid'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        break;

    default:
        //code block
        break;
}
?>