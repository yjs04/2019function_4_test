<?php 
    include "lib.php";

    $post_id=$_GET['id'];
    $category=$_POST['category'];
    $title=$_POST['title'];
    $comment=$_POST['comment'];
    $image=$_FILES['image'];

    if(!session("user")){
        back("로그인 후 사용 할 수 있습니다.");
        exit;
    }
    
    $sql="SELECT * FROM posts WHERE id = ?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    $data=$q->fetch();

    if(session("user")->user_id !== $data->writer_id){
        back("글을 수정할 권한이 없습니다.");
        exit;
    }

    if(trim($category)===""||trim($title)===""||trim($comment)===""){
        back("내용을 입력해주세요.");
        exit;
    }

    $image_name="";

    if(is_file($image['tmp_name'])){
        if(substr($image['type'],0,5)!=="image"){
            back("이미지 파일만 업로드 할 수 있습니다.");
            exit;
        }

        $exp=mb_strlen($image['name'],mb_strlen($image['name'])-4,4);

        do{
            $image_name=randString(30).$exp;
        }while(is_file(__DIR__."/upload/".$image_name));
    }
    $sql="UPDATE posts SET title = ?, category = ?, comment = ?, image = ? WHERE id = ?";
    $q=$conn->prepare($sql);
    $q->execute([$title,$category,$comment,$image_name,$post_id]);

    move_uploaded_file($image['tmp_name'],__DIR__."/upload/".$image_name);
    go("글이 수정되었습니다.","/view.php?id=".$post_id);