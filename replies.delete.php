<?php
    include "lib.php";

    $post_id=$_GET['id'];
    $sql="SELECT * FROM replies WHERE id=?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    $data=$q->fetch();

    if(!session("user")){
        back("로그인 후에 사용하실수 있습니다.");
        exit;
    }
    
    if(!$data){
        back("댓글이 존재하지 않습니다.");
        exit;
    }
    
    if(session("user")->user_id !== $data->writer_id){
        back("댓글을 제거할 권한이 없습니다.");
        exit;
    }

    $sql="DELETE FROM replies WHERE id=?";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);
    if($q->rowCount()!==1){
        back("삭제도중 오류가 발생했습니다.");
        exit;
    }else{
        go("댓글이 정상적으로 삭제되었습니다.","/view.php?id=".$data->post_id);
    }