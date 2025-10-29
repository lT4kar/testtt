<?php
if (session_status() == PHP_SESSION_NONE) session_start();
$user_role = $_SESSION['user_role'] ?? 'user';
$username  = $_SESSION['username']  ?? 'Guest';
?>

<html>
<head>
<title>How to Create PHP Crud using OOPS and MySQLi</title>
<link href="style.css" rel="stylesheet">
</head>
<body>
<h2> How to Create PHP Crud using OOPS and MySQLi </h2>
<div>
<p style="color:green; font-weight:bold;">
    <?php echo htmlspecialchars($user_role); ?>!
</p>


<?php if ($user_role === 'admin') { ?>
    <ul class="menu-list">
        <li><a href="index2.php">Student</a></li>
        <li><a href="index2.php?action=attendance">Attendance</a></li>
        <li><a href="logout.php" style="color:red;">Logout</a></li>
    </ul>
<?php } else { ?>
    <a href="logout.php" style="color:red;">Logout</a>
<?php } ?>
</div>
</body>
</html>
