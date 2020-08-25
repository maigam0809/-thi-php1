<?php
require_once "../connection.php";
$book_id = $_GET['id'];
$sql = "DELETE FROM books WHERE book_id = $book_id";
// Chuẩn bị
$stmt = $conn->prepare($sql);
// Thực thi
if($stmt->execute()){
  header("location:dm.php");
  die;
}
?>
