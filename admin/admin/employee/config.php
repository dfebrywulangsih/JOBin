<?php
defined('server') ? null : define("server", "localhost");
defined('user') ? null : define ("user", "root");
defined('pass') ? null : define("pass","");
defined('database_name') ? null : define("database_name", "jobindb");

$this_file = str_replace('\\', '/', __FILE__);
$doc_root = $_SERVER['DOCUMENT_ROOT'];

$web_root = str_replace(array($doc_root, "include/config.php"), '', $this_file);
$server_root = str_replace('config/config.php', '', $this_file);


// Create connection
$conn = new mysqli(server, user, pass, database_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>