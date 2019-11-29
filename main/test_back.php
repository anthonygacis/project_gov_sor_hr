<?php
  include "connection/connection.php";
  include "connection/connection1.php";
  $allTableName = ["employee", "back_related", "educbackground", "empchildren", "license", "org_involvement", "other_info", "training_prog", "work_experience"];

  $allColumns = [];

  foreach ($allTableName as $key => $value) {
    $s = DB1::run("SELECT * FROM " . $value);
    $r = $s->fetch();
    $newArray = array_keys($r);
    $allColumns[$value] = $newArray;
  }

  function retrieveCols($arrColumns, $colExceptions){
    $tempArr = $arrColumns;
    foreach ($colExceptions as $key => $value) {
      $index = array_search($value, $tempArr);
      if($index !== false){
          unset($tempArr[$index]);
      }
    }
    $s = implode($tempArr, ",");
    return $s;
  }
  function printQues($arrColumns, $colExceptions){
    $tempArr = $arrColumns;
    foreach ($colExceptions as $key => $value) {
      $index = array_search($value, $tempArr);
      if($index !== false){
          unset($tempArr[$index]);
      }
    }

    $s = [];
    foreach ($tempArr as $key => $value) {
      array_push($s, '?');
    }

    return implode($s,",");
  }

  function cleanDate($values, $colExceptions){
    $a = [];
    foreach ($values as $key => $value) {
      if(!in_array($key, $colExceptions, false)){
        if($value == '0000-00-00'){
          array_push($a, null);
        }else{
          array_push($a, $value);
        }
      }
    }
    return $a;
  }

  // for employee
  $sel = DB1::run("SELECT " . retrieveCols($allColumns["employee"], []) . " FROM employee");
  while($sr = $sel->fetch()){
    echo $sr["employeeid"] . " " . $sr["lname"] . "" . $sr["fname"];
    $oldID = $sr["employeeid"];

    try {
      $i = DB::run("INSERT INTO employee(" . retrieveCols($allColumns["employee"], ["employeeid"]) . ") VALUES(" . printQues($allColumns["employee"], ["employeeid"]) . ")", cleanDate($sr, ["employeeid"]));
      if($i->rowCount() > 0){
        $newID = DB::getLastInsertedID();

        // for back_related =================================================================
        $sel1 = DB1::run("SELECT " . retrieveCols($allColumns["back_related"], ["itemno", "employeeid"]) . " FROM back_related WHERE employeeid = " . $oldID);
        while($sr1 = $sel1->fetch()){
          $i1 = DB::run("INSERT INTO back_related(" . retrieveCols($allColumns["back_related"], ["itemno"]) . ") VALUES(" . printQues($allColumns["back_related"], ["itemno"]) . ")", cleanDate($sr1, ["itemno", "employeeid"]));
        }
        // for back_related =================================================================


      }
    } catch (\Exception $e) {
      echo " FAILED" . "<br/>";
    }
  }

?>
