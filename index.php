<?php
    include "lib.php";

    $sql="SELECT posts.*, users.user_name FROM posts LEFT JOIN users ON users.user_id = posts.writer_id";
    $param=[];

    if(isset($_GET['search'])&& trim($_GET['search']) !== ""){
        $search_data=$_GET['search'];
        $sql.=" WHERE comment LIKE ? OR title LIKE ?";
        array_push($param,"%".$search_data."%","%".$search_data."%");
    }

    if(isset($_GET['cate'])){
        $category=$_GET['cate'];
        $sql.=" WHERE posts.category = '$category'";
    }

    if(isset($_GET['user'])){
        $user=$_GET['user'];
        $sql.=" WHERE posts.writer_id = '$user'";
    }

    $q=$conn->prepare($sql);
    $q->execute($param);
    $posts=$q->fetchAll();
    $page_all=count($posts);
    $list_num=ceil($page_all/5);

    if(!isset($_GET['i']) || $_GET['i'] < 1 || !is_numeric($_GET['i'])){
        $now_page=1;
    }
    else{
        $now_page=$_GET['i'];
    }
    if($now_page > $list_num){
        $now_page=$list_num;
    }

    $limit_data=($now_page-1)*5;

    if($limit_data<0){
        $limit_data=0;
    }

    $now_block=ceil($now_page/5);
    $start=($now_block-1)*5 +1;
    $end=$start + 5 -1 > $list_num ? $list_num : $start + 5 -1;

    if($now_page == 0){
        $start=$end=1;
        $now_page=1;
    }
    
    $sql.=" ORDER BY id DESC LIMIT $limit_data,5";

    $q=$conn->prepare($sql);
    $q->execute($param);
    $posts=$q->fetchAll();

?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <?php include "struct/head.php"?>
</head>
<body>
    <div class="container">
        <?php include "struct/banner.php"?>
		<div class="row">
                <!-- 블로그 글 목록 -->
                <div class="col-md-9">

                    <!-- 블로그 글 -->
                    <?php foreach($posts as $item): ?>
                    <?php 
                        $sql="SELECT r.*, u.user_name FROM replies AS r, users AS u WHERE u.user_id = r.writer_id AND r.post_id = ? ORDER BY id DESC";
                        $q=$conn->prepare($sql);
                        $q->execute([$item->id]);
                    
                        $reply_data=$q->fetchAll();
                        $reply_data_num=count($reply_data);
                    ?>
                        <div class="panel panel-info">
                            <div class="panel-heading">
                                <h3 class="panel-title"><h2><?= htmlentities($item->title) ?></h2></h3>
                            </div>
                            <div class="panel-body">
                                <p>
                                    <?php if($item->image !== ""): ?>
                                        <img class="img-responsive list-img" src="upload/<?= $item->image?>" width="200" height="133" alt="image sample" align="left">
                                    <?php endif;?>
                                    <?= mb_strlen($item->comment)>301 ? nl2br(htmlentities(mb_substr($item->comment,0,300))): nl2br(htmlentities($item->comment))?>
                                </p>
                            </div>
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6">
                                        <span class="category"><strong><?= $item->category ?></strong></span>&nbsp;&nbsp;
                                        <span class="writer"><?= $item->writer_id?></span>&nbsp;&nbsp;
                                        <span class="name"><?= $item->user_name?></span>&nbsp;&nbsp;
                                        <span class="date"><?= $item->day?></span>&nbsp;&nbsp;
                                        <span class="commentcount">댓글수 <span class="badge"><?= $reply_data_num?></span></span>
                                    </div>
                                    <div class="col-md-6 btns">
                                        <?php if( session("user") && $item->writer_id === session("user")->user_id): ?>
                                            <a href="modify.php?id=<?= $item->id?>" class="btn btn-success"><span class="glyphicon glyphicon-edit">수정</span> </a>
                                            <a href="delete.php?id=<?= $item->id?>" class="btn btn-danger" onclick=" return confirm('정말로 삭제하시겠습니까?')"><span class="glyphicon glyphicon-trash"></span> 삭제</a>
                                        <?php endif;?>
                                        <a href="view.php?id=<?= $item->id?>" class="btn btn-primary"><span class="glyphicon glyphicon-zoom-in"></span> 더보기</a>
                                    </div>
                                </div>						
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <!-- //블로그 글 -->
                    
                    <!-- 페이지네이션(pagination) -->
                    <nav>
                        <ul class="pagination pagination-lg">
                        <?php $pre_page=$now_page-1; $next_page=$now_page+1; ?>
                            <li>
                                <a href="/index.php?i=<?= isset($_GET['search']) ? "{$pre_page}&search=".$_GET['search'] : "{$pre_page}" ?><?= isset($_GET['cate']) ? "&cate=".$_GET['cate'] : "" ?><?= isset($_GET['user']) ? "&user=".$_GET['user'] : "" ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                                <?php for($i=$start;$i<=$end;$i++){ ?>
                                    <?php $page=$i;?>
                                    <li><a href="/index.php<?= isset($_GET['search']) ? "?i={$page}&search=". $_GET['search'] : "?i={$page}"?><?= isset($_GET['cate']) ? "&cate=". $_GET['cate'] : ""?><?= isset($_GET['user']) ? "&user=". $_GET['user'] : ""?>" style="background-color:<?= $now_page == $i ? 'gray' : 'white'?>"><?= $i?></a></li>    
                                <?php }; ?>
                            <li>
                                <a href="/index.php?i=<?= isset($_GET['search']) ? "{$next_page}&search=".$_GET['search'] : "{$next_page}" ?><?= isset($_GET['cate']) ? "&cate=".$_GET['cate'] : "" ?><?= isset($_GET['user']) ? "&user=".$_GET['user'] : "" ?>" aria-label="Next">
                                
                                <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>				

                </div>
                <!-- //블로그 글 목록 -->

                <!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->
                <?php include "struct/aside.php"?>
            </div>
            <?php include "struct/footer.php" ?>
        </div>
    </div>
</body>
</html>