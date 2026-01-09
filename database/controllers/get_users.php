<?php
require('../../database/connection/connection.php');
$query = "SELECT * FROM user_table ORDER BY user_ID DESC";
$result = $conn->query($query);
?>