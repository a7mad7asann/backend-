<?php
session_start();
require 'Database.php';

// تأكد من تسجيل الدخول
if (!isset($_SESSION['manager_id'])) {
    header('Location: login.php');
    exit();
}

// جلب معلومات الموظفين المرتبطين بالمدير
$manager_id = $_SESSION['manager_id'];
$sql = "SELECT * FROM employee WHERE manager_id = :manager_id"; // تأكد من استخدام اسم الجدول الصحيح
$stmt = $conn->prepare($sql);
$stmt->bindValue(':manager_id', $manager_id, PDO::PARAM_INT);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>صفحة الموظفين</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="text-center mb-4">
            <h1>مرحبًا، <strong><?php echo htmlspecialchars(isset($_SESSION['manager_name']) ? $_SESSION['manager_name'] : ''); ?></strong></h1>
        </div>
        <h2>موظفوك</h2>
        <table class="table table-bordered table-striped text-center">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>الاسم</th>
                    <th>البريد الإلكتروني</th>
                    <th>الهاتف</th>
                    <th>الصورة</th>
                    <th>الإجراءات</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($result)): ?>
                    <tr>
                        <td colspan="6" class="text-center">لا توجد موظفين لعرضهم.</td>
                    </tr>
                <?php else: ?>
                    <?php 
                    $counter = 1; // عداد للموظفين
                    foreach ($result as $row): ?>
                    <tr>
                        <td><?php echo $counter++; ?></td> <!-- عرض العداد -->
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['phone']); ?></td>
                        <td><img src="<?php echo htmlspecialchars($row['picture']); ?>" alt="صورة الموظف" class="img-thumbnail" width="50"></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">تعديل</a>
                            <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn btn-danger" onclick="return confirm('هل أنت متأكد أنك تريد حذف هذا الموظف؟');">حذف</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center mt-4">
            <a href="add.php" class="btn btn-primary">إضافة موظف</a>
            <a href="logout.php" class="btn btn-danger">تسجيل الخروج</a>
        </div>
    </div>
</body>
</html>

<?php

?>
