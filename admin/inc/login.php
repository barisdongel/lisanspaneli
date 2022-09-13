<?php

require_once '../system/function.php';

if ($_POST) {
    $email = post('kullanici_ad');
    $sifre = post('kullanici_sifre');
    $crypt = sha1(md5($sifre));

    if (!$email || !$sifre) {
        echo 'empty';
    } else {
        $query = $db->prepare("SELECT * FROM kullanici_tbl WHERE kullanici_ad=:ad AND kullanici_sifre=:sifre");
        $query->execute(array(
            'ad' => $email,
            'sifre' => $crypt
        ));
        if ($query->rowCount()) {
            $row = $query->fetch(PDO::FETCH_OBJ);
            $generator = sha1(md5(IP() . $row->kullanici_id));
            $_SESSION['admin'] = $generator;
            $_SESSION['kullanici_ad'] = $row->kullanici_ad;
            $_SESSION['id'] = $row->kullanici_id;
            echo 'ok';
        } else {
            echo 'error';
        }
    }
}
