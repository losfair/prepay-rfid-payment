<?php
session_start();

$user_id = $_SESSION["user_id"];

if(!isset($user_id)) {
    exit(json_encode(array(
        "err" => 1001,
        "msg" => "Not logged in"
    )));
} else {
    exit(json_encode(array(
        "err" => 0,
        "msg" => "OK",
        "userId" => $user_id
    )));
}
