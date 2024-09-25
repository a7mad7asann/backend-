<?php
require 'auth.php';
require 'Database.php';
require 'Employee.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // معالجة رفع الصورة
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true); // إنشاء المجلد إذا لم يكن موجودًا
    }

    // تنظيف اسم الملف المرفوع
    $filename = preg_replace("/[^a-zA-Z0-9.]/", "_", basename($_FILES["picture"]["name"]));
    $target_file = $target_dir . $filename;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // التحقق من أن الملف المرفوع هو صورة
    $check = getimagesize($_FILES["picture"]["tmp_name"]);
    if ($check !== false) {
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            // إذا تم رفع الصورة بنجاح، نمرر المسار إلى كلاس Employee
            $employee = new Employee($conn);  // تمرير الاتصال إلى كلاس Employee
            $employee->addEmployee($name, $email, $phone, $target_file, $_SESSION['manager_id']);
            header("Location: home.php");
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    } else {
        echo "File is not an image.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Add Employee</title>
</head>
<body>
<div class="container mt-5">
    <h2>إضافة موظف جديد</h2>
    <form method="POST" action="" enctype="multipart/form-data" class="mt-4">
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" name="name" placeholder="الاسم" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control" name="email" placeholder="البريد الإلكتروني" required>
        </div>
        <div class="form-group">
            <label for="phone">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" placeholder="رقم الهاتف">
        </div>
        <div class="form-group">
            <label for="picture">رفع صورة</label>
            <input type="file" class="form-control-file" name="picture" accept="image/*">
        </div>
        <button type="submit" class="btn btn-primary">إضافة موظف</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
