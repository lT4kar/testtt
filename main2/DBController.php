<?php
class DBController {
    private $host = "localhost";
    private $user = "root";
    private $password = "";
    private $database = "crud_example";
    private $conn;
    
    function __construct() {
        $this->conn = $this->connectDB();
    }   
    
    // الاتصال بقاعدة البيانات
    // الاتصال بقاعدة البيانات
    function connectDB() {
        $conn = mysqli_connect($this->host, $this->user, $this->password, $this->database);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        return $conn;
    }
    
    // تنفيذ استعلام بسيط (SELECT)
    function runBaseQuery($query) {
        $resultset = array(); // تعريف مسبق لتجنب Undefined variable
        $result = $this->conn->query($query);   

        if($result) { // تحقق من نجاح الاستعلام
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $resultset[] = $row;
                }
            }
            $result->free();
        } else {
            // تسجيل الخطأ في حال وجوده
            error_log("SQL Error (runBaseQuery): " . $this->conn->error);
        }
        
        return $resultset;
    }
    
    // تنفيذ استعلام مع معاملات Prepared Statements
    function runQuery($query, $param_type, $param_value_array) {
        $resultset = array();
        $sql = $this->conn->prepare($query);
        if($sql === false) {
            error_log("Prepare failed (runQuery): " . $this->conn->error);
            return $resultset;
        }
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $result = $sql->get_result();
        
        if($result) {
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $resultset[] = $row;
                }
            }
            $result->free();
        }
        
        return $resultset;
    }
    
    // ربط المعاملات في Prepared Statements
    function bindQueryParams($sql, $param_type, $param_value_array) {
        $param_value_reference = array();
        $param_value_reference[] = & $param_type;
        for($i=0; $i<count($param_value_array); $i++) {
            $param_value_reference[] = & $param_value_array[$i];
        }
        call_user_func_array(array($sql, 'bind_param'), $param_value_reference);
    }
    
    // تنفيذ INSERT
    function insert($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        if($sql === false) {
            error_log("Prepare failed (insert): " . $this->conn->error);
            return false;
        }
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        $insertId = $sql->insert_id;
        return $insertId;
    }
    
    // تنفيذ UPDATE
    function update($query, $param_type, $param_value_array) {
        $sql = $this->conn->prepare($query);
        if($sql === false) {
            error_log("Prepare failed (update): " . $this->conn->error);
            return false;
        }
        $this->bindQueryParams($sql, $param_type, $param_value_array);
        $sql->execute();
        return true;
    }
    
    // تنفيذ DELETE بدون معاملات
    function delete($query) {
        $result = $this->conn->query($query);
        if(!$result) {
            error_log("SQL Error (delete): " . $this->conn->error);
            return false;
        }
        return true;
    }
}
?>
