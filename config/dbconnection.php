<?php

function dbconnection(): mysqli
{
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    $db = new mysqli('127.0.0.1', 'root', '', 'elkap', 3306);
    $db->set_charset('utf8mb4');

    return $db;
}
