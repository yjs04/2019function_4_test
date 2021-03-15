<?php
    include "lib.php";

    // 로그인 여부
    if(session("user")){
        back("로그인 후 이용할 수 없는 기능입니다.");
        exit;
    }

    $userid=$_POST['user_id'];
    $userpass=$_POST['password'];
    
    // sql
    $sql="SELECT * FROM users WHERE user_id = ?";
    $q=$conn->prepare($sql);
    $q->execute([$userid]);
    $user=$q->fetch();
    // 유저가 없는가?
    if(!$user){
        back("해당 아이디와 일치하는 유저가 존재하지 않습니다.");
        exit;
    }
    // 비밀번호가 일치 하나?
    if($user->password !== hash("sha256",$userpass)){
        back("비밀번호가 일치하지 않습니다.");
        exit;
    }
    session("user",$user);
    go("로그인 되었습니다.","/");