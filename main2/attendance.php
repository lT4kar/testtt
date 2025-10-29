<?php
require_once "header.php";
$user_role = $_SESSION['user_role'] ?? 'user';

$conn = new mysqli('localhost','root','','crud_example');

if (isset($_GET['action']) && $_GET['action'] === 'attendance-add' && $user_role === 'admin') {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $student_id = intval($_POST['student_id']);
        $present    = intval($_POST['present']);
        $absent     = intval($_POST['absent']);
        $date       = $_POST['attendance_date'];
        $conn->query("INSERT INTO tbl_attendance (student_id,present,absent,attendance_date) VALUES ($student_id,$present,$absent,'$date')");
        header("Location: index2.php");
        exit();
    }
    $students = $conn->query("SELECT * FROM tbl_student")->fetch_all(MYSQLI_ASSOC);
    ?>
    <h3>إضافة حضور</h3>
    <form method="post">
        <label>Student:
            <select name="student_id">
                <?php foreach($students as $s) { ?>
                    <option value="<?php echo $s['id']; ?>"><?php echo htmlspecialchars($s['name']); ?></option>
                <?php } ?>
            </select>
        </label><br><br>
        <label>Present: <input type="number" name="present" value="1"></label><br><br>
        <label>Absent: <input type="number" name="absent" value="0"></label><br><br>
        <label>Date: <input type="date" name="attendance_date" required></label><br><br>
        <button type="submit">حفظ</button>
    </form>
    <a href="index2.php">رجوع</a>
    <?php
    exit();
}

// عملية الحذف
if (isset($_GET['action']) && $_GET['action'] === 'attendance-delete' && $user_role === 'admin') {
    $date = $_GET['date'];
    $conn->query("DELETE FROM tbl_attendance WHERE attendance_date='$date'");
    header("Location: index2.php");
    exit();
}

if (isset($_GET['action']) && $_GET['action'] === 'attendance-edit' && $user_role === 'admin') {
    $date = $_GET['date'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $present = intval($_POST['present']);
        $absent  = intval($_POST['absent']);
        $conn->query("UPDATE tbl_attendance SET present=$present, absent=$absent WHERE attendance_date='$date'");
        header("Location: index2.php");
        exit();
    }
    $row = $conn->query("SELECT * FROM tbl_attendance WHERE attendance_date='$date' LIMIT 1")->fetch_assoc();
    ?>
    <h3>تعديل الحضور</h3>
    <form method="post">
        <label>Present: <input type="number" name="present" value="<?php echo $row['present']; ?>"></label><br><br>
        <label>Absent: <input type="number" name="absent" value="<?php echo $row['absent']; ?>"></label><br><br>
        <button type="submit">تعديل</button>
    </form>
    <a href="index2.php">رجوع</a>
    <?php
    exit();
}

$result = $conn->query("
    SELECT a.*, s.name 
    FROM tbl_attendance a 
    JOIN tbl_student s ON a.student_id = s.id 
    ORDER BY a.attendance_date DESC
")->fetch_all(MYSQLI_ASSOC);
?>

<div style="text-align: right; margin: 20px 0px 10px;">
<?php if ($user_role === 'admin') { ?>
    <a id="btnAddAction" href="index2.php?action=attendance-add">
        <img src="image/icon-add.png" />Add Attendance
    </a>
<?php } ?>
</div>

<div id="toys-grid">
    <table cellpadding="10" cellspacing="1" class="attendance_table">
        <thead>
            <tr>
                <th><strong>Name</strong></th>
                <th><strong>Date</strong></th>
                <th><strong>Present</strong></th>
                <th><strong>Absent</strong></th>
                <?php if ($user_role === 'admin') { ?>
                    <th><strong>Action</strong></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody>
        <?php foreach($result as $row) {
            $date = date("m-d-Y", strtotime($row['attendance_date']));
        ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo $date; ?></td>
                <td><?php echo $row['present']; ?></td>
                <td><?php echo $row['absent']; ?></td>
                <?php if ($user_role === 'admin') { ?>
                <td>
                    <a href="index2.php?action=attendance-edit&date=<?php echo $row['attendance_date']; ?>"><img src="image/icon-edit.png" /></a>
                    <a href="index2.php?action=attendance-delete&date=<?php echo $row['attendance_date']; ?>"><img src="image/icon-delete.png" /></a>
                </td>
                <?php } ?>
            </tr>
        <?php } ?>
        </tbody>
    </table>
</div>
</body>
</html>
