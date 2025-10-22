<?php
include_once 'connDB.php';
include_once './funcMod.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

function get_post_val(array $keys, $default = '') {
    foreach ($keys as $k) {
        if (isset($_POST[$k]) && $_POST[$k] !== '') return $_POST[$k];
    }
    return $default;
}

function require_fields(array $fields) {
    $missing = [];
    foreach ($fields as $f) {
        if (get_post_val([$f, strtolower($f)], '') === '') $missing[] = $f;
    }
    return $missing;
}

$tbName = isset($_POST['tb_name']) ? $_POST['tb_name'] : '';
$action = isset($_POST['action']) ? $_POST['action'] : '';

switch ($tbName) {
    case 'tb_products':
    case 'tb_product':
        switch ($action) {
            case 'insert':
                $miss = require_fields(['c_ProductName']);
                if (!empty($miss)) {
                    echo 'Missing fields: ' . implode(',', $miss);
                    exit;
                }

                $sql = "INSERT INTO tb_products (c_ProductName, i_SupplierID, i_CategoryID, c_Unit, i_Price) 
                        VALUES (:pname, :supid, :catid, :unit, :price)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':pname', get_post_val(['c_ProductName','c_productname']), PDO::PARAM_STR);
                $stmt->bindValue(':supid', (int)get_post_val(['i_SupplierID','i_supplierid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':catid', (int)get_post_val(['i_CategoryID','i_categoryid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':unit', get_post_val(['c_Unit','c_unit'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':price', get_post_val(['i_Price','i_price'], 0), PDO::PARAM_STR);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_product_search.php');
                break;

            case 'update':
                $sql = "UPDATE tb_products SET c_ProductName=:pname, i_SupplierID=:supid, i_CategoryID=:catid, c_Unit=:unit, i_Price=:price WHERE i_ProductID = :pid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':pname', get_post_val(['c_ProductName','c_productname']), PDO::PARAM_STR);
                $stmt->bindValue(':supid', (int)get_post_val(['i_SupplierID','i_supplierid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':catid', (int)get_post_val(['i_CategoryID','i_categoryid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':unit', get_post_val(['c_Unit','c_unit'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':price', get_post_val(['i_Price','i_price'], 0), PDO::PARAM_STR);
                $stmt->bindValue(':pid', (int)get_post_val(['i_ProductID','i_productid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_product_search.php');
                break;

            case 'delete':
                $sql = "DELETE FROM tb_products WHERE i_ProductID = :pid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':pid', (int)get_post_val(['i_ProductID','i_productid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_product_search.php');
                break;
        }
        break;

    case 'tb_customers':
    case 'tb_customer':
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO tb_customers (i_customerid, c_customername, c_contactname, c_contacttitle, c_address, c_city, c_postalcode, c_country)
                        VALUES (:cid, :cname, :contact, :title, :address, :city, :postal, :country)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CustomerID','i_customerid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':cname', get_post_val(['c_CustomerName','c_customername'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':contact', get_post_val(['c_ContactName','c_contactname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':title', get_post_val(['c_ContactTitle','c_contacttitle'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':address', get_post_val(['c_Address','c_address'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':city', get_post_val(['c_City','c_city'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':postal', get_post_val(['c_PostalCode','c_postalcode'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':country', get_post_val(['c_Country','c_country'], ''), PDO::PARAM_STR);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_customers_search.php');
                break;

            case 'update':
                $sql = "UPDATE tb_customers SET c_customername=:cname, c_contactname=:contact, c_contacttitle=:title, c_address=:address, c_city=:city, c_postalcode=:postal, c_country=:country WHERE i_customerid = :cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':cname', get_post_val(['c_CustomerName','c_customername'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':contact', get_post_val(['c_ContactName','c_contactname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':title', get_post_val(['c_ContactTitle','c_contacttitle'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':address', get_post_val(['c_Address','c_address'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':city', get_post_val(['c_City','c_city'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':postal', get_post_val(['c_PostalCode','c_postalcode'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':country', get_post_val(['c_Country','c_country'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CustomerID','i_customerid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_customers_search.php');
                break;

            case 'delete':
                $sql = "DELETE FROM tb_customers WHERE i_customerid = :cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CustomerID','i_customerid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_customers_search.php');
                break;
        }
        break;

    case 'tb_categories':
    case 'tb_category':
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO tb_categories (i_CategoryID, c_CategoryName, c_Description) VALUES (:cid, :name, :desc)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CategoryID','i_categoryid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':name', get_post_val(['c_CategoryName','c_categoryname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':desc', get_post_val(['c_Description','c_description'], ''), PDO::PARAM_STR);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_categories_search.php');
                break;

            case 'update':
                $sql = "UPDATE tb_categories SET c_CategoryName=:name, c_Description=:desc WHERE i_CategoryID = :cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':name', get_post_val(['c_CategoryName','c_categoryname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':desc', get_post_val(['c_Description','c_description'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CategoryID','i_categoryid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_categories_search.php');
                break;

            case 'delete':
                $sql = "DELETE FROM tb_categories WHERE i_CategoryID = :cid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':cid', (int)get_post_val(['i_CategoryID','i_categoryid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_categories_search.php');
                break;
        }
        break;

    case 'tb_employees':
    case 'tb_employee':
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO tb_employees (i_EmployeeID, c_LastName, c_FirstName, c_BirthDate, c_Photo, c_Notes) VALUES (:eid, :lname, :fname, :birth, :photo, :notes)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':eid', (int)get_post_val(['i_EmployeeID','i_employeeid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':lname', get_post_val(['c_LastName','c_lastname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':fname', get_post_val(['c_FirstName','c_firstname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':birth', get_post_val(['c_BirthDate','c_birthdate'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':photo', get_post_val(['c_Photo','c_photo'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':notes', get_post_val(['c_Notes','c_notes'], ''), PDO::PARAM_STR);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_employees_search.php');
                break;

            case 'update':
                $sql = "UPDATE tb_employees SET c_LastName=:lname, c_FirstName=:fname, c_BirthDate=:birth, c_Photo=:photo, c_Notes=:notes WHERE i_EmployeeID = :eid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':lname', get_post_val(['c_LastName','c_lastname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':fname', get_post_val(['c_FirstName','c_firstname'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':birth', get_post_val(['c_BirthDate','c_birthdate'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':photo', get_post_val(['c_Photo','c_photo'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':notes', get_post_val(['c_Notes','c_notes'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':eid', (int)get_post_val(['i_EmployeeID','i_employeeid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_employees_search.php');
                break;

            case 'delete':
                $sql = "DELETE FROM tb_employees WHERE i_EmployeeID = :eid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':eid', (int)get_post_val(['i_EmployeeID','i_employeeid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_employees_search.php');
                break;
        }
        break;

    case 'tb_shippers':
    case 'tb_shipper':
        switch ($action) {
            case 'insert':
                $sql = "INSERT INTO tb_shippers (i_ShipperID, c_ShipperName, c_Phone) VALUES (:sid, :name, :phone)";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':sid', (int)get_post_val(['i_ShipperID','i_shipperid'], 0), PDO::PARAM_INT);
                $stmt->bindValue(':name', get_post_val(['c_ShipperName','c_shippername'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':phone', get_post_val(['c_Phone','c_phone'], ''), PDO::PARAM_STR);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_shippers_search.php');
                break;

            case 'update':
                $sql = "UPDATE tb_shippers SET c_ShipperName=:name, c_Phone=:phone WHERE i_ShipperID = :sid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':name', get_post_val(['c_ShipperName','c_shippername'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':phone', get_post_val(['c_Phone','c_phone'], ''), PDO::PARAM_STR);
                $stmt->bindValue(':sid', (int)get_post_val(['i_ShipperID','i_shipperid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_shippers_search.php');
                break;

            case 'delete':
                $sql = "DELETE FROM tb_shippers WHERE i_ShipperID = :sid";
                $stmt = $pdo->prepare($sql);
                $stmt->bindValue(':sid', (int)get_post_val(['i_ShipperID','i_shipperid'], 0), PDO::PARAM_INT);
                try { $stmt->execute(); } catch (PDOException $e) { echo 'Error: '.$e->getMessage(); }
                header('Location: ../db_shippers_search.php');
                break;
        }
        break;

    }
    ?>
    default:
        //code block
        break;
?>