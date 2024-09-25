<?php
require 'auth.php'; // تأكد من أن المستخدم مسجل الدخول
require 'Database.php'; // الاتصال بقاعدة البيانات
require 'Employee.php'; // الكلاس المسؤول عن الموظفين

// التحقق مما إذا كان "id" موجودًا في الرابط
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // التحقق من أن "id" هو رقم صالح
    if (is_numeric($id)) {
       
        $employee = new Employee($conn); // تمرير الاتصال إلى كلاس Employee

        // استدعاء دالة الحذف
        if ($employee->deleteEmployee($id)) {
            // إعادة توجيه المستخدم إلى الصفحة الرئيسية بعد الحذف
            header("Location: home.php");
            exit();
        } else {
            echo "حدث خطأ أثناء حذف الموظف. يرجى المحاولة مرة أخرى.";
        }
    } else {
        echo "معرف غير صالح. يجب أن يكون المعرف رقماً.";
    }
} else {
    echo "لم يتم تقديم معرف الموظف.";
}
?>
