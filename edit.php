<?php
require 'auth.php'; // تأكد من تسجيل دخول المدير
require 'Database.php'; // استيراد كلاس قاعدة البيانات
require 'Employee.php'; // استيراد كلاس الموظف

// تحقق من وجود "id" في الرابط
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid or missing employee ID.");
}
$id = $_GET['id'];

// إنشاء اتصال بقاعدة البيانات وكائن من كلاس Employee
$employee = new Employee($conn); // تمرير الاتصال إلى كلاس Employee

// معالجة طلب POST للتعديل
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    
    // إعداد مسار حفظ الصورة
    $target_dir = "uploads/"; // تأكد من وجود هذا المجلد
    $target_file = $target_dir . basename($_FILES["picture"]["name"]);
    
    // تحقق مما إذا تم رفع صورة جديدة
    if (isset($_FILES["picture"]) && $_FILES["picture"]["error"] == 0) {
        // حاول نقل الصورة إلى المجلد المحدد
        if (move_uploaded_file($_FILES["picture"]["tmp_name"], $target_file)) {
            $picture = $target_file; // احفظ مسار الصورة
        } else {
            echo "Error uploading image.";
            $picture = $current_employee['picture']; // احتفظ بالصورة القديمة إذا فشل الرفع
        }
    } else {
        $picture = $current_employee['picture']; // احتفظ بالصورة القديمة إذا لم يتم رفع صورة جديدة
    }

    // تحديث بيانات الموظف
    if ($employee->updateEmployee($id, $name, $email, $phone, $picture)) {
        header("Location: home.php"); // إعادة التوجيه بعد الحفظ
        exit();
    } else {
        echo "Error updating employee. Please try again.";
    }
}

// استرجاع بيانات الموظف الحالي
$current_employee = $employee->getEmployeeById($id);
if (!$current_employee) {
    die("Employee not found.");
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>تعديل بيانات الموظف</title>
</head>
<body>
<div class="container mt-5">
    <h2>تعديل بيانات الموظف</h2>
    <form method="POST" action="" enctype="multipart/form-data" class="mt-4"> <!-- إضافة enctype -->
        <div class="form-group">
            <label for="name">الاسم</label>
            <input type="text" class="form-control" name="name" value="<?php echo htmlspecialchars($current_employee['name']); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">البريد الإلكتروني</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($current_employee['email']); ?>" required>
        </div>
        <div class="form-group">
            <label for="phone">رقم الهاتف</label>
            <input type="text" class="form-control" name="phone" value="<?php echo htmlspecialchars($current_employee['phone']); ?>">
        </div>
        <div class="form-group">
            <label for="picture">رابط الصورة</label>
            <input type="file" class="form-control" name="picture">
            <small class="form-text text-muted">إذا كنت ترغب في تغيير الصورة، يرجى رفع صورة جديدة.</small>
        </div>
        <button type="submit" class="btn btn-primary">تحديث بيانات الموظف</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
