<?php
    include "lib.php";

    $post_id=$_GET['id'];
    $sql="SELECT p.*, u.user_name FROM posts AS p, users AS u WHERE p.id=? AND u.user_id = p.writer_id";
    $q=$conn->prepare($sql);
    $q->execute([$post_id]);
    $data=$q->fetch();
    if(!$data){
        back("글이 존재하지 않습니다.");
        exit;
    }
    if(!session("user")){
        back("로그인 후에 사용가능합니다.");
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
                <!-- 블로그 글 쓰기 -->
			<div class="col-md-9">

                <!-- 블로그 글쓰기 폼 -->
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title"><h2>글수정</h2></h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="modify.process.php?id=<?= $data->id?>" enctype="multipart/form-data" method="post">
                            <div class="form-group">
                                <label for="userid" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="user_id" id="user_id" placeholder="<?= $data->writer_id?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">작성자</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="<?= $data->user_name?>" readonly>
                                </div>
                            </div>							
                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">카테고리</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category" id="category">
                                        <option value="life"<?php $data->category === "life" ? "selected" : "" ?> >life</option>
                                        <option value="art" <?php $data->category === "art" ? "selected" : "" ?> >art</option>
                                        <option value="fashion"<?php $data->category === "fashion" ? "selected" : "" ?> >fashion</option>
                                        <option value="technics" <?php $data->category === "technics" ? "selected" : "" ?>>technics</option>
                                        <option value="etcs" <?php $data->category === "etcs" ? "selected" : "" ?>>etcs</option>
                                    </select>																	
                                </div>
                            </div>						
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">제목</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="<?= htmlentities($data->title)?>" value="<?= $data->title?>">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">글본문</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="8" name="comment" id="comment"><?= htmlentities($data->comment)?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">이미지</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="upimg" name="image"><?= $data->image?>
                                </div>
                            </div>													
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">글쓰기</button>
                                </div>
                            </div>
                        </form>
                        
                    </div>
                </div>
                <!-- //블로그 글쓰기 폼 -->

                </div>
                <!-- //블로그 글 쓰기 -->
                <!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->
                <?php include "struct/aside.php"?>
            </div>
            <?php include "struct/footer.php" ?>
        </div>
    </div>
</body>
</html>