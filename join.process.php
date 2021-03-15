<?php
    include "lib.php";
    $user_id=$_POST['user_id'];
    $user_name=$_POST['user_name'];
    $password=$_POST['password'];
    $password2=$_POST['password2'];

    // 조건
    // 로그인 유무
    if(session("user")){
        back("로그인 후 사용할 수 없는 기능입니다.");
        exit;
    }
    // 비밀번호와 확인이 일치하나?
    if($password !== $password2){
        back("비밀번호와 비밀번호 확인이 일치하지 않습니다.");
        exit;
    }
    // 아이디 이메일 형식?
    if(!preg_match("/^[a-zA-Z0-9]+@[a-zA-Z0-9]+\.[a-zA-z]{2,4}$/",$user_id)){
        back("아이디는 이메일 형식이어야 합니다.");
        exit;
    }
    // 값이 비어있는가?
    if(trim($user_id)===""||trim($user_name)===""||trim($password)===""){
        back("회원정보를 입력해 주세요");
        exit;
    }

    // db
    $sql="SELECT * FROM users WHERE user_id = ?";
    $q=$conn->prepare($sql);
    $q->execute([$user_id]);
    $exist_user=$q->fetch();
    if($q->rowCount()!==0){
        back("해당이메일로 가입한 회원이 존재합니다.");
        exit;
    }
    $scr_pass=hash("SHA256",$password);
    $sql="INSERT INTO users(user_id,user_name,password) VALUES (?,?,?)";
    $q=$conn->prepare($sql);
    $q->execute([$user_id,$user_name,$scr_pass]);
    go("회원가입이 완료되었습니다.","/");