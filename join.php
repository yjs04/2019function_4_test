<?php
    include "lib.php";
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
                        <h3 class="panel-title"><h2>회원가입</h2></h3>
                    </div>
                    <div class="panel-body">
                        <form class="form-horizontal" action="/join.process.php" method="post">
                            <div class="form-group">
                                <label for="userid" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-10">
                                    <input type="email" class="form-control" name="user_id" id="user_id" placeholder="email@domain.com" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="username" class="col-sm-2 control-label">이름</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="user_name" id="user_name" placeholder="이름" required>
                                </div>
                            </div>												
                            <div class="form-group">
                                <label for="userpass" class="col-sm-2 control-label">비밀번호</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password" id="password" placeholder="비밀번호" required>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="userpass2" class="col-sm-2 control-label">비밀번호확인</label>
                                <div class="col-sm-10">
                                    <input type="password" class="form-control" name="password2" id="password2" placeholder="비밀번호 확인 " required>
                                </div>
                            </div>																				
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-default">회원가입</button>
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