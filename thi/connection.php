<?php
$hostName = "localhost";
$userName = "root";
$password = "";
$db = "gammtph10005_examphp1";

try {
  // tạo đối tượng kết nối PDO
  $conn = new PDO("mysql:host=$hostName; dbname=$db;charset=utf8",$userName,$password);
  echo "Created database sussesfully";
} catch (PDOException $e) {
  echo "Lỗi kết nối cơ sở dữ liệu <br>" . $e->getMessage();
}
