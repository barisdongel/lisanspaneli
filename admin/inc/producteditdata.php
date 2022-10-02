<?php

require_once '../system/function.php';

if (isset($_SESSION['admin']) != @sha1(md5(IP() . $_SESSION['id']))) {
    session_destroy();
    go(site . "/login.php");
}

if ($_POST) {
    $pname   = post('pname');
    $pcode   = post('pcode');
    $pid     = post('pid');
    $pstatus = post('pstatus');


    $squery = $db->prepare("SELECT urun_id FROM urun_tbl WHERE urun_id=:id");
    $squery->execute([':id' => $pid]);
    if ($squery->rowCount()) {
        if (!$pname || !$pcode || !$pid || !$pstatus) {
            echo 'empty';
        } else {
            $already = $db->prepare("SELECT urun_id,urun_key FROM urun_tbl WHERE urun_key=:k AND urun_id !=:id");
            $already->execute([':k' => $pcode, ':id' => $pid]);
            if ($already->rowCount()) {
                echo 'already';
            } else {
                $up = $db->prepare("UPDATE urun_tbl SET
                urun_ad =:a,
                urun_key=:k,
                urun_durum=:d 
                WHERE urun_id=:id
            ");
                $up->execute([
                    ':a' => $pname,
                    ':k' => $pcode,
                    ':d' => $pstatus,
                    ':id' => $pid
                ]);

                if ($up) {
                    echo 'ok';
                } else {
                    echo 'error';
                }
            }
        }
    } else {
        echo 'error';
    }
}
