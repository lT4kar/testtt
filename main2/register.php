<?php

$host = 'localhost';
$user = 'root';
$pass = '';
$db   = 'crud_example';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email    = trim($_POST['email']);
    $password = trim($_POST['password']); // 
    $role     = isset($_POST['role']) ? $_POST['role'] : 'user';

  
    if ($username === '' || $email === '' || $password === '') {
        $error = "كل الحقول مطلوبة";
    } else {
      
        $stmt = $conn->prepare("INSERT INTO tbl_users (username, email, password, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $username, $email, $password, $role);
        if ($stmt->execute()) {
            $success = "تم التسجيل بنجاحd.";
        } else {
            $error = "خطأ: " . $stmt->error;
        }
        $stmt->close();
    }
}
?>
<!doctype html>
<html lang="ar">
<head><meta charset="utf-8"><title>تسجيل</title></head>
<body>
<h2>تسجيل مستخدم</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<?php if (!empty($success)) echo "<p style='color:green;'>$success</p>"; ?>
<form method="post">
  <label>اسم المستخدم: <input name="username" required></label><br><br>
  <label>الإيميل: <input name="email" type="email" required></label><br><br>
  <label>كلمة المرور: <input name="password" type="text" required></label><br><br>
    </select>
  </label>
  <button type="submit">تسجيل</button>
  <a href="login.php">تسجيل دخول  </a>
</form>
</body>
</html>
