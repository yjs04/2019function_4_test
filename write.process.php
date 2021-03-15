<?php
    include "lib.php";
    
    $title = $_POST['title'];
    $category=$_POST['category'];
    $comment=$_POST['comment'];
    $image = $_FILES['image'];

    // 로그인
    if(!session("user")){
        back("로그인 후 이용 하실 수 있습니다.");
        exit;
    }
    // 내용 검사
    if(trim($title)===""||trim($category)===""||trim($comment)===""){
        back("내용을 입력해 주세요.");
        exit;
    }
    $image_name="";

    if(is_file($image['tmp_name'])){
        if(substr($image['type'],0,5)!=="image"){
            back("이미지 파일만 업로드 할 수 있습니다.");
            exit;
        }

        $exp= mb_substr($image['name'],mb_strlen($image['name'])-4,4);
        
        do{
            $image_name= randString(30).$exp;
        }while(is_file(__DIR__."/upload/".$image_name));
    }
    
    $sql="INSERT INTO posts(writer_id,category,title,comment,image,day) VALUES (?,?,?,?,?,NOW())";

    $q=$conn->prepare($sql);
    $q->execute([session("user")->user_id,$category,$title,$comment,$image_name]);

    move_uploaded_file($image['tmp_name'],__DIR__."/upload/".$image_name);
    
    go("글이 작성되었습니다.","/");