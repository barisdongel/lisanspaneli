<?php

@session_start();
@ob_start();

try {
	$db = new PDO("mysql:host=localhost;dbname=lisans_db", 'root', '');
	//https://stackoverflow.com/questions/4361459/php-pdo-charset-set-names
	$db->exec("set names utf8");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$site = "http://localhost/lisanspaneli/admin";
define('site', $site);


function IP2()
{

	if (getenv("HTTP_CLIENT_IP")) {
		$ip = getenv("HTTP_CLIENT_IP");
	} elseif (getenv("HTTP_X_FORWARDED_FOR")) {
		$ip = getenv("HTTP_X_FORWARDED_FOR");
		if (strstr($ip, ',')) {
			$tmp = explode(',', $ip);
			$ip = trim($tmp[0]);
		}
	} else {
		$ip = getenv("REMOTE_ADDR");
	}
	return $ip;
}

/*
if (isset($_SESSION['admin']) == @sha1(md5(IP2() . $_SESSION['id']))) {

	$kullanicisor = $db->prepare("SELECT * FROM kullanici_tbl WHERE kullanici_id=:id");
	$kullanicisor->execute(array('id' => $_SESSION['kullanici_id']));
	$kullanicicek = $kullanicisor->fetch(PDO::FETCH_ASSOC);

	if (!isset($_SESSION['kullanici_id'])) {
		$qrow = $query->fetch(PDO::FETCH_OBJ);
		$yid = $qrow->kullanici_id;
		$ykadi = $qrow->kullanici_ad;
		session_destroy();
	}
} else {
	session_destroy();
}
*/