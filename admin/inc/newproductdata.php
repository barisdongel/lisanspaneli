<?php

require_once '../system/function.php';

if (isset($_SESSION['admin']) != @sha1(md5(IP() . $_SESSION['id']))) {
    session_destroy();
    go(site . "/login.php");
}

if ($_POST) {
    $pname = post('pname');
    $pcode = post('pcode');

    if (!$pname || !$pcode) {
        echo 'empty';
    } else {
        $already = $db->prepare("SELECT urun_key FROM urun_tbl WHERE urun_key=:k");
        $already->execute([':k' => $pcode]);
        if ($already->rowCount()) {
            echo 'already';
        } else {
            $add = $db->prepare("INSERT INTO urun_tbl SET
                urun_ad=:a,
                urun_key=:k
            ");
            $add->execute([':a' => $pname, ':k' => $pcode]);
            if ($add->rowCount()) {
                echo 'ok';
            } else {
                echo 'error';
            }
        }
    }
}
