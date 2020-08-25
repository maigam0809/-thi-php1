<?php
require_once "../connection.php";

$book_id = $_GET['id'];
//Câu lệnh sql
$sqlT = "SELECT * FROM books WHERE book_id = $book_id";
$stmt = $conn->prepare($sqlT);
$stmt->execute();
$book = $stmt->fetch(PDO::FETCH_ASSOC);

//Validate ten san phẩm và image
$errors = ['tour_name' => '', 'image' => '', 'price' => null, 'number_date' => null];
if (isset($_POST['btnLuu'])) {
  extract($_REQUEST);
  if (trim($book_title) == '') {
    $errors['book_title'] = "bạn cần nhập tên sách";
  }
  if($page == ''){
    $errors['page'] = "bạn không được để trống";
  }
  elseif ($page <= 0) {
    $errors['page'] = "bạn cần nhập cho ngày dương";
  }

  if ($price == '') {
    $errors['price'] = "Bạn không được để trống";
  }elseif($price <= 0){
    $errors['price'] = "Bạn cần nhập giá tiền lớn hơn 0";
  }
  
  if (!array_filter($errors)) {
    //Câu lệnh sql insert
    $sql = "UPDATE books SET book_title = '$book_title', cate_id='$cate_id', intro='$intro', detail='$detail', page = '$page', price='$price' WHERE book_id = $book_id";
    echo $sql;
    // die;
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
      header("location:dm.php");
    } else {
     
      echo "Lỗi dữ liệu";
    }
  }
}
//Câu lệnh sql Lấy dữ liệu bảng categories
$sqlC = "SELECT * FROM categories";
$stmt = $conn->prepare($sqlC);
$stmt->execute();
$cate = $stmt->fetchAll(PDO::FETCH_ASSOC);
//Lấy mã của sản phẩm cần sửa

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sửa sản phẩm</title>
  <style>
    p {
      color: red;
    }
  </style>
</head>

<body>
  <h3>Sửa sản phẩm</h3>
  <form action="" method="post" enctype="multipart/form-data">
    <input type="text" name="book_title" placeholder="Tên sp" id="" value="<?= $book['book_title'] ?>">
    <p>
      <?= (isset($errors['book_title']) ? $errors['book_title'] : '') ?>
    </p>
    <br>
    <select name="cate_id" id="">
      <!--Đổ dữ liệu của bảng categories vào option-->
      <?php foreach ($cate as $c) : ?>
        <?php if ($c['cate_id'] == $book['cate_id']) : ?>
          <option value="<?= $c['cate_id'] ?>" selected><?= $c['cate_name'] ?></option>
        <?php else : ?>
          <option value="<?= $c['cate_id'] ?>"><?= $c['cate_name'] ?></option>
        <?php endif; ?>
      <?php endforeach; ?>
    </select>
    <br>
    <label for="">Hình ảnh</label>
    <br>
    <img src="../images/<?= $book['image'] ?>" width="120" alt="">
    
    <label for="">Intro</label>
    <br>
    <input type="text" name="intro" placeholder="Tên sp" id="" value="<?= $book['intro'] ?>">
    
    <label for="">Detail</label>
    <br>
    <textarea name="detail" id="" cols="130" rows="5" placeholder="detail"><?= $book['detail'] ?></textarea>
    <br>

    <label for="">Page</label>
    <br>
    <input type="number" name="page" id="" min ="0" placeholder="page" value="<?= $book['page'] ?>">
    <p><?= (isset($errors['page']) ? $errors['page'] : '') ?></p>
    <br>
    <label for="">Price</label>
    <br>
    <input type="number" name="price" min="0" id="" placeholder="price" value="<?= $book['price'] ?>">
    <p><?= (isset($errors['price']) ? $errors['price'] : '') ?></p>
    <br>
    <br>

    <button type="submit" name="btnLuu">Lưu</button>
  </form>
</body>

</html>