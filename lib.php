<?php 
    session_start();

    // db - default
    $host="localhost";
    $user_name="root";
    $user_pass="";
    $dbname="ourblog2";
    $option =[
        \PDO::ATTR_DEFAULT_FETCH_MODE=>\PDO::FETCH_OBJ,
        \PDO::ATTR_ERRMODE=>\PDO::ERRMODE_EXCEPTION,
    ];

    $conn=new\PDO("mysql:host={$host};dbname={$dbname};charset=utf8mb4",$user_name,$user_pass,$option);

    function back($msg){
        echo "<script>";
        echo "alert('$msg');";
        echo "history.back();";
        echo "</script>";
    }
    function go($msg,$url){
        echo "<script>";
        echo "alert('$msg');";
        echo "location.href = '$url';";
        echo "</script>";
    }
    function session($key,$data=''){
        if($data !== ""){
            $_SESSION[$key]=$data;
        }else{
            if(isset($_SESSION[$key])){
                return $_SESSION[$key];
            }else{
                return false;
            }
        }
    }
    function randString($strlen){
        $str="qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890";
        $result="";
        for($i=0;$i<$strlen;$i++){
            $result.=$str[rand(0,strlen($str)-1)];
        }
        return $result;
    }