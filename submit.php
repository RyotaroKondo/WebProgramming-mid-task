<?php
session_start();
if (key_exists("add", $_POST)) {
    $_SESSION["post_id"] = $_POST["id"];
    header("Location: http://localhost/WebProg/schedule/schedule_add.php", true, 301);
    exit();
} else if (key_exists("edit", $_POST)) {
    $_SESSION["post_id"] = $_POST["id"];
    header("Location: http://localhost/WebProg/schedule/schedule_edit.php", true, 301);
    exit();
} else if(key_exists("delete", $_POST)) {
    $_SESSION["post_id"] = $_POST["id"];
    header("Location: http://localhost/WebProg/schedule/schedule_delete.php", true, 301);
    exit();
}
