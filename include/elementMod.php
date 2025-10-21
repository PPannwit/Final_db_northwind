<?php

function input_text($elementName, $strLabel, $elementType, $elementValue, $strGuide,$lock=false)
{
    $lockAttr = $lock ? " readonly " : "";
    echo "<div class=\"mb-3 mt-3\">
       <label for=\"$elementName\" class=\"form-label\">$strLabel:</label>
       <input type=\"$elementType\" class=\"form-control\" id=\"$elementName\"   
        placeholder=\"$strGuide\" name=\"$elementName\" value =\"$elementValue\" $lockAttr>
   </div>";
}

function input_dropdown($pdo, $elementName, $strLabel, $tbName, $fieldID, $fieldName, $elementValue)
{
    $sql = "SELECT $fieldID as id , $fieldName as name FROM $tbName ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo "<div class=\"mb-3 mt-3\">
       <label for=\"$elementName\" class=\"form-label\">$strLabel:</label>";
    echo "<select class=\"form-select\" name=\"$elementName\" id=\"$elementName\">";
    echo "<option value=\"\">-- กรุณาเลือก $strLabel --</option>";
    foreach ($rows as $row) {
        $id = $row['id'];
        $name = $row['name'];
        $opt = ($elementValue == $id) ? " selected " : "";
        echo "<option value=$id $opt > $name </option>";
    }
    echo "</select>
   </div>";
}

function dropdown_db($pdo, $elementName, $tbName, $fieldId, $fieldName, $elementValue)
{
    $sql = "SELECT DISTINCT $fieldId as id , $fieldName as name from $tbName";

    $stmt = $pdo->prepare($sql);

    $stmt->execute();

    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // echo json_encode($products);
    echo "<select class=\"form-select\" name=\"$elementName\">";
    foreach ($products as $product) {
        $id = htmlspecialchars($product['id']);
        $name = htmlspecialchars($product['name']);
        $otp = ($id == $elementValue) ? "selected" : "";
        echo "<option value=\"$id\" $otp>$name</option>";
    }
    echo "</select>";
}
