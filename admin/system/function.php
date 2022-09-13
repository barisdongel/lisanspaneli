<?php 
@date_default_timezone_set("Europe/Istanbul");
require_once 'config.php';

function post($par){
    return strip_tags(trim($_POST[$par]));
}

function get($par){
    return strip_tags(trim($_GET[$par]));
}

function alert($status,$message){
    echo '<div class="alert alert-'.$status.'">'.$message.'</div>';
}

function go($url, $time = false){
    if($time == false){
        $yon =  header('Location:'.$url);
    }else{
        $yon =  header('refresh:'.$time.';url='.$url);
    }

    return $yon;
}

function IP(){

    if(getenv("HTTP_CLIENT_IP")){
        $ip = getenv("HTTP_CLIENT_IP");
    }elseif(getenv("HTTP_X_FORWARDED_FOR")){
        $ip = getenv("HTTP_X_FORWARDED_FOR");
        if (strstr($ip, ',')) {
            $tmp = explode (',', $ip);
            $ip = trim($tmp[0]);
        }
    }else{
        $ip = getenv("REMOTE_ADDR");
    }
    return $ip;
}



function pagination($s, $ptotal, $url){
    global $site;

    $forlimit = 3;
    if($ptotal < 2){
        null;
    }else{

        if($s > 4){
            $prev  = $s - 1;
            echo '<a style="    min-width: 50px!important;padding:10px;color:#000"; class="page-numbers site-btn btn-sm" href="'.$site.'/'.$url.'1" ><i class="icofont-rounded-left"></i> <<</a>';
            echo '<a style="    min-width: 50px!important;padding:10px;color:#000"; class="page-numbers site-btn btn-sm" href="'.$site.'/'.$url.($s-1).'" ><</a>';
        }

        for($i = $s - $forlimit; $i < $s + $forlimit + 1; $i++){
            if($i > 0 && $i <= $ptotal){
                if($i == $s){
                    echo '<span style="    min-width: 50px!important;padding:10px;background:blue ;color:#fff"; class="page-numbers current site-btn btn-sm">'.$i.'</span>';
                }else{
                    echo '<a  style="    min-width: 50px!important;padding:10px;color:#000";background:blue" class="page-numbers site-btn btn-sm" href="'.$site.'/'.$url.$i.'" >'.$i.'</a>';
                }
            }
        }

        if($s <= $ptotal - 4){
            $next  = $s + 1;
            echo '<a style="    min-width: 50px!important;color:#000"; class="page-numbers site-btn btn-sm" href="'.$site.'/'.$url.$next.'" ><i class="icofont-rounded-right"></i>></a>';
            echo '<a style="    min-width: 50px!important;padding:10px;color:#000;" class="page-numbers site-btn btn-sm" href="'.$site.'/'.$url.$ptotal.'" >>></a>';
        }
    }

}


function loc(){

    $loc =  "https://lisans.birciftyazilim.com".$_SERVER['REQUEST_URI'];
    return $loc;
}


?>