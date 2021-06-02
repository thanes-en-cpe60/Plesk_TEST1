<?php
//$conn = new mysqli('27.254.172.62:3306', 'PiroonAssembly','JoB0847807291', 'sql_assembly');
$conn = new mysqli('localhost','root','','sql_assembly');
if (!$conn) {
    echo "<script type='text/javascript'>";
        echo "window.location = 'login.php'; ";
        echo "alert('Error back to Update again');";
        echo "</script>";
}else {
    echo "<script type='text/javascript'>";
        echo "console.log('connection successfully');";
        echo "</script>";
}

?>