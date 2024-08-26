<?php
require_once('config.php');
/* CONNECTION */
$_db_conn = @mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);

if (!$_db_conn) {
    die('Connect Error (' . mysqli_connect_errno() . ') '
            . mysqli_connect_error());
}
/* change character set to utf8 */
if (!mysqli_set_charset($_db_conn, "utf8"))
    printf("Error loading character set utf8: %s\n", mysqli_error($_db_conn));