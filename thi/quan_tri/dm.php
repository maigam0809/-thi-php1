<?php

require_once "../connection.php";

$sql = "SELECT * FROM books INNER JOIN categories on books.cate_id = categories.cate_id";
// echo $sql;
$stmt = $conn->prepare($sql);
$stmt->execute();
$book = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hiển thị danh mục sách</title>
</head>

<body>
  <h3>Danh sách danh mục books</h3>
  <a href="them.php">Thêm danh books</a>
  <table border="1">
    <tr>
      <th>Books id</th>
      <th>Books Title</th>
      <th>Cate name</th>
      <th>Books Image</th>
      <th>Intro</th>
      <th>Detail</th>
      <th>Page</th>
      <th>Price</th>
      <th>Action</th>
      <th>Action</th>
    </tr>
    <?php foreach ($book as $t) :?>
      <tr>
        <td><?= $t['book_id'] ?></td>
        <td><?= $t['book_title'] ?></td>
        <td><?= $t['cate_name'] ?></td>
        <td><img src="../images/<?=$t['image']?>" width="120px" alt="" srcset=""></td>
        <td><?= $t['intro'] ?></td>
        <td><?= $t['detail'] ?></td>
        <td><?= $t['page'] ?></td>
        <td><?= $t['price'] ?></td>
      
        <td><a href="sua.php?id=<?= $t['book_id'] ?>">Sửa</a></td>
        <td><a onclick="return confirm('Bạn có chắc chắn xóa không ?')" href="xoa.php?id=<?=$t['book_id']?>" >Xóa</a></td>
      </tr>
    <?php endforeach; ?>


  </table>

</body>

</html>