
<?php

function Myhash($data){
    $str = hash('sha256',$data);
    return hash('sha256',$str.env('APP_KEY'));
}


function UniqueHash($data){
    $str = hash('sha256',$data);
    return hash('sha256',hash('sha256',$str.env('APP_KEY').rand(0,99999999)).now());
}

?>
