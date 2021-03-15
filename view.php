<?php
    include "lib.php";
    
    $post_id=$_GET['id'];

    $sql="SELECT posts.*, users.user_name FROM posts,users WHERE posts.id= ? AND users.user_id = posts.writer_id";

    $q = $conn->prepare($sql);
    $q->execute([$post_id]);

    $data=$q->fetch();
    
    $sql="SELECT r.*, u.user_name FROM replies AS r, users AS u WHERE u.user_id = r.writer_id AND r.post_id = ? ORDER BY id DESC";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);

    $reply_data=$q->fetchAll();
    $reply_data_num=count($reply_data);
    
    if(!$data){
        back("해당글이 존재하지 않습니다.");
        exit;
    }
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
                <!-- 블로그 글 본문 보기 -->
			<div class="col-md-9">

                <!-- 블로그 글 -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><h2><?= htmlentities($data->title) ?></h2></h3>
                    </div>
                    <div class="panel-body">
                        <p>
                            <?php if($data->image !== ""): ?>
                                <img class="img-responsive" src="upload/<?= $data->image ?>" alt="image sample">
                            <?php endif;?>
                            <?= nl2br(htmlentities($data->comment))?>
                        </p>
                    </div>
                    <div class="panel-footer">
                        <div class="row">
                            <div class="col-md-6">
                                <span class="category"><strong><?= htmlentities($data->category)?></strong></span>&nbsp;&nbsp;
                                <span class="writer"><?= htmlentities($data->writer_id)?></span>&nbsp;&nbsp;
                                <span class="date"><?= $data->day?></span>&nbsp;&nbsp;
                                <span class="commentcount">댓글수 <span class="badge"><?= htmlentities($reply_data_num)?></span></span>
                            </div>
                            <div class="col-md-6 btns">
                                <?php if(session("user") && $data->writer_id === session("user")->user_id): ?>
                                    <a href="modify.php?id=<?= $data->id?>" class="btn btn-success"><span class="glyphicon glyphicon-edit"></span> 수정</a>
                                    <a href="delete.php?id=<?= $data->id?>" class="btn btn-danger" onclick=" return confirm('정말로 삭제하시겠습니까?')"><span class="glyphicon glyphicon-trash"></span> 삭제</a>
                                <?php endif;?>
                                <a href="index.php" class="btn btn-primary"><span class="glyphicon glyphicon-th-list"></span> 목록으로</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- //블로그 글 -->

                <!-- 댓글 폼 -->
                <?php if(session("user")):?>
                    <div class="row">
                        <form class="form-horizontal" action="replies.php?id=<?= $data->id?>" method="post">
                            <div class="form-group">
                                <label for="userid" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="r_user_id" id="r_user_id" placeholder="<?= session("user")->user_id?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userid" class="col-sm-2 control-label">작성자</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="r_user_name" id="r_user_name" placeholder="<?= session("user")->user_name?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">댓글내용</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="3" name="r_comment" id="r_comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">댓글저장</button>
                                </div>
                            </div>
                        </form>
                    </div>
                <?php endif;?>
                <!-- //댓글 폼 -->

                <!-- 댓글 리스트 -->
                <?php foreach($reply_data as $item):?>
                    <div class="commentlist">
                        <div class="comment">
                            <h3><?= htmlentities($item->user_name);?> <?= htmlentities($item->writer_id);?> <?= htmlentities($item->day);?></h3>
                            <p><?= nl2br(htmlentities($item->comment))?></p>
                            <?php if(session("user")&&($item->writer_id === session("user")->user_id)): ?>
                                <a href="replies.delete.php?id=<?= $item->id?>" class="btn btn-xs btn-danger" onclick=" return confirm('정말로 삭제하시겠습니까?')"><span class="glyphicon glyphicon-trash"></span></a>
                            <?php endif;?>
                        </div>	
                    </div>
                <?php endforeach;?>
                <!-- //댓글 리스트 -->

                </div>
                <!-- //블로그 글 본문 보기 -->
                <?php include "struct/aside.php"?>
            </div>
            <?php include "struct/footer.php" ?>
        </div>
    </div>
</body>
</html>