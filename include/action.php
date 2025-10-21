<?php
include_once 'connDB.php';
include_once './funcMod.php';

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

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_product_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
        break;

    case 'tb_customers':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_customers (c_CompanyName, c_ContactName, c_ContactTitle, c_Country) 
                        VALUES (:param_cname, :param_contact, :param_title, :param_country)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cname', $_POST['c_CompanyName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_contact', $_POST['c_ContactName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_title', $_POST['c_ContactTitle'], PDO::PARAM_STR);
                $stmt->bindValue(':param_country', $_POST['c_Country'], PDO::PARAM_STR);
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
                    c_CompanyName = :param_cname , 
                    c_ContactName  = :param_contact , 
                    c_ContactTitle  = :param_title , 
                    c_Country        = :param_country
                WHERE tb_customers.i_CustomerID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cname', $_POST['c_CompanyName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_contact', $_POST['c_ContactName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_title', $_POST['c_ContactTitle'], PDO::PARAM_STR);
                $stmt->bindValue(':param_country', $_POST['c_Country'], PDO::PARAM_STR);
                $stmt->bindValue(':param_price', $_POST['i_Price'], PDO::PARAM_INT);
                $stmt->bindValue(':param_pid', $_POST['i_ProductID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                $sql = "DELETE FROM tb_customers WHERE i_CustomerID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cid', $_POST['i_CustomerID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_customers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
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
                    echo "New record created successfully";
                    header("Location: ../db_categories_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_categories SET 
                    c_CategoryName = :param_name , 
                    c_Description  = :param_description
                WHERE tb_categories.i_CategoryID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_CategoryName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_description', $_POST['c_Description'], PDO::PARAM_STR);
                $stmt->bindValue(':param_cid', $_POST['i_CategoryID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_categories_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                $sql = "DELETE FROM tb_categories WHERE i_CategoryID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cid', $_POST['i_CategoryID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_categories_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
        break;

        case 'tb_employees':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_employees (c_EmployeeName, c_Title) 
                        VALUES (:param_name, :param_title)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_EmployeeName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_title', $_POST['c_Title'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    echo "New record created successfully";
                    header("Location: ../db_employees_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_employees SET 
                    c_EmployeeName = :param_name , 
                    c_Title  = :param_title
                WHERE tb_employees.i_EmployeeID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_EmployeeName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_title', $_POST['c_Title'], PDO::PARAM_STR);
                $stmt->bindValue(':param_cid', $_POST['i_EmployeeID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_employees_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                $sql = "DELETE FROM tb_employees WHERE i_EmployeeID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cid', $_POST['i_EmployeeID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_employees_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
        break;

        case 'tb_shippers':
        switch ($action) {

            case 'insert':
                $sql = "INSERT INTO tb_shippers (c_ShipperName, c_ContactName) 
                        VALUES (:param_name, :param_contact)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_ShipperName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_contact', $_POST['c_ContactName'], PDO::PARAM_STR);
                try {
                    $stmt->execute();
                    echo "New record created successfully";
                    header("Location: ../db_shippers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'update':
                $sql = "UPDATE tb_shippers SET 
                    c_ShipperName = :param_name , 
                    c_ContactName  = :param_contact
                WHERE tb_shippers.i_ShipperID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_name', $_POST['c_ShipperName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_contact', $_POST['c_ContactName'], PDO::PARAM_STR);
                $stmt->bindValue(':param_cid', $_POST['i_ShipperID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records UPDATED successfully";
                    header("Location: ../db_shippers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;

            case 'delete':
                $sql = "DELETE FROM tb_shippers WHERE i_ShipperID = :param_cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':param_cid', $_POST['i_ShipperID'], PDO::PARAM_INT);

                try {
                    $stmt->execute();
                    echo $stmt->rowCount() . " records DELETED successfully";
                    header("Location: ../db_shippers_search.php");
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }
                break;
        }
        //code
        break;

    default:
        //code block
        break;
}
?>