<?php 
    include "lib.php";

    $post_id=$_GET['id'];
    $sql="SELECT * FROM posts WHERE id= ?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    $data=$q->fetch();

    if(!session("user")){
        back("로그인 후 이용가능 합니다.");
        exit;
    }

    if(session("user")->user_id !== $data->writer_id){
        back("삭제 권한이 없습니다.");
        exit;
    }

    if(!$data){
        back("글이 존재하지 않습니다.");
        exit;
    }

    $sql="DELETE FROM posts WHERE id=?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    if($q->rowCount()!==1){
        back("삭제도중 오류가 발생하였습니다.");
        exit;
    }else {
        go("글이 삭제되었습니다.","/index.php");
    }