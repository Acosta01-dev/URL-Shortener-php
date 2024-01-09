<?php
session_start();

include __DIR__ . DIRECTORY_SEPARATOR . "config.php";

$long_url = $_POST["full_url"];
$mydomain = "localhost/php/short";

/* if (!empty($long_url) && filter_var($long_url, FILTER_VALIDATE_URL)) { */
if (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i", $long_url)) {

    do { //Just in case, we already have the same "short code" in the DB
        $short_code = substr(md5(microtime() . rand(0, 26)), 0, 5);

        $stmt = $conn->prepare("SELECT COUNT(*) FROM url_shortener WHERE short_code = :short_code");
        $stmt->bindParam(":short_code", $short_code);
        $stmt->execute();
        $count = $stmt->fetchColumn();
    } while ($count > 0);

    $stmt = $conn->prepare("INSERT INTO url_shortener (short_code, long_url) VALUES (:short_code , :long_url)");
    $stmt->bindParam(":short_code", $short_code);
    $stmt->bindParam(":long_url", $long_url);
    $stmt->execute();

    $_SESSION["last_code"] = $mydomain . "/?url=" . $short_code;
    $_SESSION["last_url"] = $long_url;
    /* 
   echo $short_code;
   */
} else {
    /* 
    header("HTTP/1.1 400 Bad Request"); 
    */
    $_SESSION["last_code"] = "Invalid URL";
    $_SESSION["last_url"] = "Place long URL here";
}
