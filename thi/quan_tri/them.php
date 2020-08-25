<?php
require_once "../connection.php";
//Validate ten san phẩm và image
$errors = ['book_title' => '', 'image' => '', 'price' => null, 'page' => null];
if (isset($_POST['btnLogin'])) {
  extract($_REQUEST);
  if (trim($book_title) == '') {
    $errors['book_title'] = "Bạn cần nhập tên sách";
  }

  if ($price == '') {
    $errors['price'] = "bạn không được để trống";
  } elseif ($price <= 0) {
    $errors['price'] = "bạn cần nhập cho ngày dương";
  }

  if ($page  == '') {
    $errors['page'] = "Bạn không được để trống";
  } elseif ($page <= 0) {
    $errors['page'] = "Bạn cần nhập giá tiền lớn hơn 0";
  }
  // var_dump($price == 0);
  // var_dump($_FILES['image']);
  if ($_FILES['image']['size'] > 0) {
    // $image = $_FILES['image']['name'];
    if (
      $_FILES['image']['type'] === 'image/png' ||
      $_FILES['image']['type'] === 'image/jpg' ||
      $_FILES['image']['type'] === 'image/jpeg'
    ) {
      if ($_FILES['image']['size'] <= 2 * 1024 * 1024) {
        $image = $_FILES['image']['name'];
      } else {
        $errors['image'] = "Nhập sai kích thước ảnh";
      }
    } else {
      $errors['image'] = "Mời bạn chọn định dạng ảnh(png,jpg,jpeg);";
    }
  } else {
    $errors['image'] = "Bạn chưa nhập ảnh";
  }

  if (!array_filter($errors)) {
    //Câu lệnh sql insert
    $sql = "INSERT INTO books(book_title,image ,intro, detail, page, price, cate_id)
     VALUES('$book_title','$image', '$intro', '$detail', '$page', '$price', '$cate_id')";
     var_dump($sql);
    $stmt = $conn->prepare($sql);
    if ($stmt->execute()) {
      move_uploaded_file($_FILES['image']['tmp_name'], '../images/' . $image);
      echo "Thêm dữ liệu thành công!!!";
      header("location:dm.php?message=Cập nhật dữ liệu thành công");
    } else {
      echo "Lỗi dữ liệu";
    }
  }
}
//Câu lệnh sql Lấy dữ liệu bảng categories
$sql = "SELECT * FROM categories";
$stmt = $conn->prepare($sql);
$stmt->execute();
$cate = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Giao diện thêm danh sách dữ liệu người dùng theo tour đi </title>
  <style>
    p {
      color: red;
    }
  </style>
</head>

<body>

  <h3>Danh sách dữ liệu người dùng theo tour đi</h3>
  <form action="" method="post" enctype="multipart/form-data">
    <label for="">Tên sách</label>
    <br>
    <input type="text" name="book_title" id="" value="<?php echo $_POST['book_title'] ?? ''; ?>" placeholder="Tên sách">
    <br>
    <p><?= (isset($errors['book_title']) ? $errors['book_title'] : '') ?></p>
    <br>
    <label for="">Tên tác giả</label>
    <select name="cate_id" id="cate_id" class="input_dang_nhap">
      <?php
      foreach ($cate as $item) : ?>
        <option value="<?= $item['cate_id'] ?>" <?php echo (isset($_POST['cate_id']) && $_POST['cate_id'] == $item['cate_id']) ? 'selected' : ''; ?>>
          <?= $item['cate_name'] ?>
        </option>
      <?php endforeach; ?>
    </select>
    <br>
    <input type="file" name="image" id="" value="<?php echo $_POST['image'] ?? ''; ?>" placeholder=" image">
    <p><?= (isset($errors['image']) ? $errors['image'] : '') ?></p>

    <label for="">Nhập intro</label>
    <br>
    <input type="text" name="intro" value="<?php echo $_POST['intro'] ?? ''; ?>" min="0" id="" placeholder="intro">
    <br>

    <label for="">Deatail</label>
    <br>
    <textarea name="detail" id="" cols="30" rows="10">
    <?php echo $_POST['detail'] ?? ''; ?>
   </textarea>

    <br>
    <label for="">Page</label>
    <input type="number" name="page" id="" value="<?php echo $_POST['page'] ?? ''; ?>">
    <p><?= (isset($errors['page']) ? $errors['page'] : '') ?></p>
    <br>

    <label for=""></label>
    <input type="number" name="price" id="" value="<?php echo $_POST['price'] ?? ''; ?>">
    <p><?= (isset($errors['page']) ? $errors['page'] : '') ?></p>

    <button type="submit" name="btnLogin">Lưu</button>
  </form>
</body>

</html>