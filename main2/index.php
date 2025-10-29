<?php
session_start(); // بداية الجلسة

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'crud_example';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = trim($_POST['identifier']); // يوزر أو ايميل
    $password   = trim($_POST['password']);

    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM tbl_users WHERE username = ? OR email = ? LIMIT 1");
    $stmt->bind_param("ss", $identifier, $identifier);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        if ($password === $row['password']) { // نص واضح كما طلبت
            // تخزين البيانات في الجلسة
            $_SESSION['user_id']   = $row['id'];
            $_SESSION['username']  = $row['username'];
            $_SESSION['user_role'] = $row['role'];

            // توجيه حسب الدور
            if ($row['role'] === 'admin') {
                header("Location: index2.php");
                exit();
            } else { // user
                header("Location: index2.php?action=attendance");
                exit();
            }
        } else {
            $msg = "كلمة المرور غير صحيحة";
        }
    } else {
        $msg = "المستخدم غير موجود";
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="ar">
<head>
<meta charset="utf-8">
<title>تسجيل دخول</title>
</head>
<body>
<h2>تسجيل دخول</h2>

<?php if ($msg !== '') echo "<p style='color:red;'>$msg</p>"; ?>

<form method="post">
  <label>اسم المستخدم أو الإيميل: <input name="identifier" required></label><br><br>
  <label>كلمة المرور: <input name="password" type="text" required></label><br><br>
  <button type="submit">دخول</button>
</form>

<a href="register.php">تسجيل حساب جديد </a>

</body>
</html>
