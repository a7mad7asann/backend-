<?php
session_start();
require 'Database.php';

// إذا كان المدير مسجلاً دخوله بالفعل، أعد توجيهه إلى الصفحة الرئيسية
if (isset($_SESSION['manager_id'])) {
    header('Location: home.php');
    exit();
}

// معالجة نموذج تسجيل الدخول
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // استعلام لجلب المدير بناءً على البريد الإلكتروني
    $sql = "SELECT * FROM managers WHERE email = :email";
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    $manager = $stmt->fetch(PDO::FETCH_ASSOC);

    // تحقق من كلمة المرور
    if ($manager && password_verify($password, $manager['password'])) {
        // تخزين معلومات المدير في الجلسة
        $_SESSION['manager_id'] = $manager['id'];
        $_SESSION['manager_name'] = $manager['name'];
        header('Location: home.php');
        exit();
    } else {
        $error = "البريد الإلكتروني أو كلمة المرور غير صحيحة.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>تسجيل الدخول</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="password">كلمة المرور</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">تسجيل الدخول</button>
            <a href="register.php" class="btn btn-primary">اضافة حساب</a>
        </form>
    </div>
</body>
</html>
