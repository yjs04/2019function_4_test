<?php

$sql="SELECT posts.*, users.user_name FROM posts LEFT JOIN users ON users.user_id = posts.writer_id  ";
$q=$conn->prepare($sql);
$q->execute();
$all=count($q->fetchAll());

$q=$conn->prepare($sql." WHERE category = 'life' ");
$q->execute();
$life=count($q->fetchAll());

$q=$conn->prepare($sql." WHERE category = 'art' ");
$q->execute();
$art=count($q->fetchAll());

$q=$conn->prepare($sql." WHERE category = 'fashion' ");
$q->execute();
$fashion=count($q->fetchAll());

$q=$conn->prepare($sql." WHERE category = 'technics' ");
$q->execute();
$technics=count($q->fetchAll());

$q=$conn->prepare($sql." WHERE category = 'etcs' ");
$q->execute();
$etcs=count($q->fetchAll());

$sql="SELECT posts.writer_id, users.user_name FROM posts LEFT JOIN users ON users.user_id = posts.writer_id ";
$q=$conn->prepare($sql);
$q->execute();
$data_num=$q->fetchALL();
if(session("user") !== false){
	$user_id = session('user')->user_id;
	$sql="SELECT * FROM posts WHERE writer_id = '$user_id'";
	$q=$conn->prepare($sql);
	$q->execute();
	$session_writer_num=count($q->fetchAll());
}

$sql="SELECT distinct users.user_id FROM users,posts WHERE users.user_id = posts.writer_id";
$q=$conn->prepare($sql);
$q->execute();
$data=$q->fetchAll();

?>
<div class="col-md-3">

				<div class="loginarea">
					<div class="panel panel-default">
						<?php if(!session("user")): ?>
							<div class="panel-body">
								<form class="form-horizontal" action="login.process.php" method="post">
									<div class="form-group">
										<div class="col-sm-12">
										<input type="email" class="form-control" name="user_id" id="user_id" placeholder="email@domain.com" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
										<input type="password" class="form-control" name="password" id="password" placeholder="비밀번호" required>
										</div>
									</div>
									<div class="form-group">
										<div class="col-sm-12">
										<button type="submit" class="btn btn-default">로그인</button>
										<a href="/join.php" type="button" class="btn btn-info">회원가입</a>
										</div>
									</div>
								</form>
							</div>
						<?php else: ?>
							<div class="panel-body">
								<form class="form-horizontal">
									<div class="form-group">
										<div class="col-sm-12">
											<?= session("user")->user_name ?>
											<br>
											<span class="badge"><?= session("user")->user_id ?></span>											
											<br>
											등록한 글의 갯수 : <?= $session_writer_num?>개
											<br>
											<a href="/logout.process.php" type="button" class="btn btn-info">로그아웃</a>
										</div>
									</div>
								</form>
							</div>
						<?php endif; ?>
					</div>					
				</div>
				<?php if(session("user")): ?>
					<div>
						<a href="write.php" class="writebtn btn btn-primary btn-lg col-sm-12"><span class="glyphicon glyphicon-pencil"></span> 글쓰기</a>
					</div>
				<?php endif;?>
				<div class="categories">
					<h3>Categories</h3>
					<ul>
						<li><a href="/index.php">전체보기</a> <span class="badge"><?= $all?></span></li>
						<li><a href="/index.php?cate=life">life</a> <span class="badge"><?= $life?></span></li>
						<li><a href="/index.php?cate=art">art</a> <span class="badge"><?= $art?></span></li>
						<li><a href="/index.php?cate=fashion">fashion</a> <span class="badge"><?= $fashion?></span></li>
						<li><a href="/index.php?cate=technics">technics</a> <span class="badge"><?= $technics?></span></li>
						<li><a href="/index.php?cate=etcs">etcs</a> <span class="badge"><?= $etcs?></span></li>
					</ul>
				</div>

				<div class="authors">
					<h3>Authors</h3>
					<ul>
						<?php foreach($data as $item):?>
							<li>
								<?php 
									$user = $item->user_id;
									$sql="SELECT * FROM posts WHERE posts.writer_id = '$user'";
									$q=$conn->prepare($sql);
									$q->execute();
									$count=$q->fetchAll();
									$num=count($count);

									$sql="SELECT users.user_name FROM users WHERE users.user_id = '$user'";
									$q=$conn->prepare($sql);
									$q->execute();
									$name=$q->fetch();
								?>
								<a href="/index.php?user=<?=$user?>"><?= $name->user_name?></a> <span class="badge"><?= $num?></span>
							</li>
						<?php endforeach;?>
					</ul>					
				</div>

</div>
<!-- 오른쪽 칼럼(로그인, 카테고리, 글쓴이 목록) -->