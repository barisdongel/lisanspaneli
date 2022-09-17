<?php

require_once '../system/function.php';

if (isset($_SESSION['admin']) != @sha1(md5(IP() . $_SESSION['id']))) {
    session_destroy();
    go(site . "/login.php");
  }

if ($_POST) {
    $pname = post('pname');
    $ldomain = post('ldomain');
    $lcode = post('lcode');
    $ltime = post('ltime');
    if (!$pname || !$lcode || !$ldomain || !$ltime) {
        echo 'empty';
    } else {
        $date = date('Y-m-d H:i', strtotime($ltime));
        $already = $db->prepare("SELECT lisans_key FROM lisans_tbl WHERE lisans_key=:k");
        $already->execute([':k' => $lcode]);
        if ($already->rowCount()) {
            echo 'already';
        } else {
            $add = $db->prepare("INSERT INTO lisans_tbl SET
                lisans_domain=:d,
                lisans_key=:k,
                lisans_urun=:u,
                lisans_bitis=:b
            ");
            $add->execute([':d' => $ldomain, ':k' => $lcode, ':u' => $pname, ':b' => $date]);
            if ($add->rowCount()) {
                echo 'ok';
            } else {
                echo 'error';
            }
        }
    }
}
