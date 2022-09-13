<?php
ob_start();
session_start();

if (isset($_POST['login'])) {
	$kullanici_kullaniciadi=$_POST['kullanici_kullaniciadi'];
	$sifre=md5($_POST['sifre']);

}

function kisalt($metin, $uzunluk){
	// substr ile belirlenen uzunlukta kesiyoruz
	$metin = substr($metin, 0, $uzunluk)."...";
	// kesilen metindeki son kelimeyi buluyoruz
	$metin_son = strrchr($metin, " ");
	// son kelimeyi " ..." ile değiştiriyoruz
	$metin = str_replace($metin_son," ...", $metin);

	return $metin;
}

function seo($s) {
	$tr = array('ş','Ş','ı','I','İ','ğ','Ğ','ü','Ü','ö','Ö','Ç','ç','(',')','/',' ',',','?');
	$eng = array('s','s','i','i','i','g','g','u','u','o','o','c','c','','','-','-','','');
	$s = str_replace($tr,$eng,$s);
	$s = strtolower($s);
	$s = preg_replace('/&amp;amp;amp;amp;amp;amp;amp;amp;amp;.+?;/', '', $s);
	$s = preg_replace('/\s+/', '-', $s);
	$s = preg_replace('|-+|', '-', $s);
	$s = preg_replace('/#/', '', $s);
	$s = str_replace('.', '', $s);
	$s = trim($s, '-');
	return $s;
}


function buildTree($kategoriler, $alt_ustid=0){

	$branch= array();
	foreach ($kategoriler as $kategori) {
		if ($element->parent_id == $parent_id) {
			$children = buildTree($kategoriler, $kategori->id);

			if ($children) {
				$kategori->children = $children;
			}else{
				$kategori->children = array();
			}

			$branch[] = $kategori;

		}
	}

	return $branch;
}

function drawElements($items){

	echo "<ul>";
	foreach ($items as $item) {

		echo "<li>{$item->title}</li>";

		if (sizeof($item->children) > 0) {
			drawElements($item->children);
		}

	}
	echo "</ul>";

}


/*
function kontrol () {
$yonetici_adi=$_SESSION['KULLANICI_ADI'];
$yoneticisor=mysql_query("select * from login where KULLANICI_ADI='$yonetici_adi'");
$yoneticisay=mysql_num_rows($yoneticisor);

if ($yoneticisay==0) {
header('Location:login.php');
}
}
*/
?>
