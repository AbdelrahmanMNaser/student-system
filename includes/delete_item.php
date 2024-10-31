<?php
include("db_connection.php");

function fetch_referenced($itemName)
{
  global $conn;
  $retrieve = "SELECT 
                TABLE_NAME,
                COLUMN_NAME, 
                REFERENCED_TABLE_NAME
              FROM 
                INFORMATION_SCHEMA.KEY_COLUMN_USAGE
              WHERE 
                REFERENCED_TABLE_NAME = '$itemName'
  ";
  $result = $conn->query($retrieve);

  return $result;
}

function delete_FK($result, $itemPKValue)
{
  global $conn;
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      $table = $row["TABLE_NAME"];
      $column = $row["COLUMN_NAME"];
      $delete_FK_query = "DELETE FROM `$table` WHERE `$column` = '$itemPKValue'";
      $conn->query($delete_FK_query);
    }
  }
}

function delete_PK($itemName, $itemPK, $itemPKValue)
{
  global $conn;
  $delete_PK_query = "DELETE FROM `$itemName` WHERE `$itemPK` = '$itemPKValue'";
  $conn->query($delete_PK_query);
}

function delete_Row($itemName, $itemPK, $itemPKValue)
{
  $result = fetch_referenced($itemName);

  delete_FK($result, $itemPKValue);

  delete_PK($itemName, $itemPK, $itemPKValue);
}
