<?php

function getEdit($pdo, $tbName, $pkName, $pkValue)
{
    $sql = "SELECT * FROM $tbName WHERE $pkName = :param_pid;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['param_pid' => $pkValue]);
    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return count($row) == 0 ? null : $row[0];
}

function getNewID($pdo,$tbName,$pkName){
   $stmt = $pdo->prepare("SELECT MAX($pkName) + 1 as NewID from $tbName;");
   $stmt->execute();
   $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
   return count(value: $rows)==0? null : $rows[0]['NewID'];
}
