<?php
include_once 'connDB.php';
include_once './funcMod.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$tbName = $_POST['tb_name'];
$action = $_POST['action'];

switch ($tbName) {
    case 'tb_products':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_products (i_ProductID, c_ProductName, i_SupplierID, i_CategoryID, c_Unit, i_Price) 
                        VALUES (:param_pid, :param_pname, :param_supid, :param_catid, :param_unit, :param_price)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_pid', $_POST['i_ProductID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_pname', $_POST['c_ProductName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_supid', $_POST['i_SupplierID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_catid', $_POST['i_CategoryID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_unit', $_POST['c_Unit'], PDO::PARAM_STR);
                $stmt->bindValue(':param_price', $_POST['i_Price'], PDO::PARAM_STR); 

                try {
                    $stmt->execute();
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
                    WHERE i_ProductID = :param_pid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_pname', $_POST['c_ProductName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_supid', $_POST['i_SupplierID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_catid', $_POST['i_CategoryID'], PDO::PARAM_INT);
                $stmt->bindValue(':param_unit', $_POST['c_Unit'], PDO::PARAM_STR);
                $stmt->bindValue(':param_price', $_POST['i_Price'], PDO::PARAM_STR); 
                $stmt->bindValue(':param_pid', $_POST['i_ProductID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    header("Location: ../db_product_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                break;
        }
        break;

    case 'tb_customers':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_customers (i_customerid, c_customername, c_contactname, c_address, c_city, c_postalcode, c_country) 
                        VALUES (:pid, :pname, :contact, :address, :city, :postal, :country)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':pid', $_POST['i_customerid'], PDO::PARAM_INT);
                $stmt->bindValue(':pname', $_POST['c_customername'], PDO::PARAM_STR);
                $stmt->bindValue(':contact', $_POST['c_contactname'], PDO::PARAM_STR);
                $stmt->bindValue(':address', $_POST['c_address'], PDO::PARAM_STR);
                $stmt->bindValue(':city', $_POST['c_city'], PDO::PARAM_STR);
                $stmt->bindValue(':postal', $_POST['c_postalcode'], PDO::PARAM_STR);
                $stmt->bindValue(':country', $_POST['c_country'], PDO::PARAM_STR);

                try {
                    $stmt->execute();
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_customers SET 
                        c_customername = :pname, 
                        c_contactname  = :contact, 
                        c_address      = :address, 
                        c_city         = :city,
                        c_postalcode   = :postal,
                        c_country      = :country
                    WHERE i_customerid = :pid"; 
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':pname', $_POST['c_customername'], PDO::PARAM_STR);
                $stmt->bindValue(':contact', $_POST['c_contactname'], PDO::PARAM_STR);
                $stmt->bindValue(':address', $_POST['c_address'], PDO::PARAM_STR);
                $stmt->bindValue(':city', $_POST['c_city'], PDO::PARAM_STR);
                $stmt->bindValue(':postal', $_POST['c_postalcode'], PDO::PARAM_STR);
                $stmt->bindValue(':country', $_POST['c_country'], PDO::PARAM_STR);
                $stmt->bindValue(':pid', $_POST['i_customerid'], PDO::PARAM_INT); 

                try {
                    $stmt->execute();
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
            
            case 'delete': 
                break;
        }
        break;

    case 'tb_categories':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_categories (c_CategoryName, c_Description) 
                        VALUES (:param_name, :param_description)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_CategoryName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_description', $_POST['c_Description'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    header("Location: ../db_categories_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_categories SET 
                        c_CategoryName = :param_name , 
                        c_Description  = :param_description
                    WHERE i_CategoryID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_CategoryName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_description', $_POST['c_Description'], PDO::PARAM_STR);
                $stmt->bindValue(':param_cid', $_POST['i_CategoryID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    header("Location: ../db_categories_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete': 
                break;
        }
        break;

    case 'tb_employees':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_employees (i_EmployeeID, c_LastName, c_FirstName, c_BirthDate, c_Photo, c_Notes) 
                        VALUES (:eid, :lname, :fname, :birth, :photo, :notes)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':eid', $_POST['i_EmployeeID'], PDO::PARAM_INT);
                $stmt->bindValue(':lname', $_POST['c_LastName'], PDO::PARAM_STR);
                $stmt->bindValue(':fname', $_POST['c_FirstName'], PDO::PARAM_STR);
                $stmt->bindValue(':birth', $_POST['c_BirthDate'], PDO::PARAM_STR);
                $stmt->bindValue(':photo', $_POST['c_Photo'], PDO::PARAM_STR);
                $stmt->bindValue(':notes', $_POST['c_Notes'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    header("Location: ../db_employees_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_employees SET 
                        c_LastName = :lname, 
                        c_FirstName = :fname,
                        c_BirthDate = :birth,
                        c_Photo = :photo,
                        c_Notes = :notes
                    WHERE i_EmployeeID = :eid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':lname', $_POST['c_LastName'], PDO::PARAM_STR);
                $stmt->bindValue(':fname', $_POST['c_FirstName'], PDO::PARAM_STR);
                $stmt->bindValue(':birth', $_POST['c_BirthDate'], PDO::PARAM_STR);
                $stmt->bindValue(':photo', $_POST['c_Photo'], PDO::PARAM_STR);
                $stmt->bindValue(':notes', $_POST['c_Notes'], PDO::PARAM_STR);
                $stmt->bindValue(':eid', $_POST['i_EmployeeID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    header("Location: ../db_employees_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
            
            case 'delete':
                break;
        }
        break;

    case 'tb_shippers':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_shippers (i_ShipperID, c_ShipperName, c_Phone) 
                        VALUES (:sid, :sname, :phone)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':sid', $_POST['i_ShipperID'], PDO::PARAM_INT);
                $stmt->bindValue(':sname', $_POST['c_ShipperName'], PDO::PARAM_STR);
                $stmt->bindValue(':phone', $_POST['c_Phone'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    header("Location: ../db_shippers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_shippers SET 
                        c_ShipperName = :sname, 
                        c_Phone = :phone
                    WHERE i_ShipperID = :sid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':sname', $_POST['c_ShipperName'], PDO::PARAM_STR);
                $stmt->bindValue(':phone', $_POST['c_Phone'], PDO::PARAM_STR);
                $stmt->bindValue(':sid', $_POST['i_ShipperID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    header("Location: ../db_shippers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                break;
        }
        break;

    default:
        echo "ไม่พบตารางที่ระบุ (Invalid tb_name)";
        break;
}
?>