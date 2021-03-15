<?php 
    include "lib.php";

    $post_id=$_GET['id'];
    $comment=$_POST['r_comment'];

    if(!session("user")){
        back("로그인 후 이용할 수 있습니다.");
        exit;
    }

    $sql="SELECT * FROM posts WHERE id = ?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    $data=$q->fetch();

    if(!$data){
        back("댓글을 작성할 게시물이 존재하지 않습니다.");
        exit;
    }

    if(trim($comment) === ""){
        back("내용을 입력해주세요.");
        exit;
    }
    $sql="INSERT INTO replies(writer_id,post_id,comment,day) VALUES (?,?,?,NOW())";
    $q=$conn->prepare($sql);
    $q->execute([session("user")->user_id,$post_id,$comment]);
    if($q->rowCount()!==1){
        back("작성하는 도중 문제가 발생했습니다.");
        exit;
    }

    go("댓글이 작성되었습니다.","/view.php?id=".$post_id);