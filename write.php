<?php
    include "lib.php";
    if(!session("user")){
        back("로그인후 이용할 수 있습니다.");
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
                        <h3 class="panel-title"><h2>글쓰기</h2></h3>
                    </div>
                    <div class="panel-body">

                        <form class="form-horizontal" action="write.process.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="userid" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="user_id" id="user_id" value="<?= session("user")->user_id?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">작성자</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_name" id="user_name" value="<?= session("user")->user_name?>" readonly>
                                </div>
                            </div>							
                            <div class="form-group">
                                <label for="category" class="col-sm-2 control-label">카테고리</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="category" id="category">
                                        <option value="life">life</option>
                                        <option value="art">art</option>
                                        <option value="fashion">fashion</option>
                                        <option value="technics">technics</option>
                                        <option value="etcs">etcs</option>
                                    </select>																	
                                </div>
                            </div>						
                            <div class="form-group">
                                <label for="title" class="col-sm-2 control-label">제목</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="title" id="title" placeholder="글 제목">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">글본문</label>
                                <div class="col-sm-10">
                                    <textarea class="form-control" rows="8" name="comment" id="comment"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputPassword3" class="col-sm-2 control-label">이미지</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" id="image" name="image">
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