<div class="container">
		<div class="jumbotron">
  	<h1><a href="/">Our Blog</a></h1>
  	<p>Our Blog는 우리의 꿈과 희망을 나누는 곳입니다.</p>
  	<p>
		<form class="form-inline" role="search" id="search_form">
			<div class="form-group">
				<input type="text" class="form-control" placeholder="Search" id="search" name="search">
			</div>
			<button type="button" class="btn btn-default" id="btn_submit"><span class="glyphicon glyphicon-search"></span></button>
		</form>
  	</p>
</div>

<script src="../Layout/js/jquery-1.12.3.min.js"></script>
<!-- <script type="text/javascript">
	$(.btn-submit).onclick=function(event){
		var form=$(.search_form);
		var act=document.getElementById("Search");
		console.log(act);
		if(act.value!==""){
			form.action="/index.php";
		}
	}
</script> -->
<!-- javascript -->
<script type="text/javascript">
	document.getElementById("btn_submit").onclick = function(){
		var act = document.getElementById("search");
		if(act.value !== ""){
			$("#search_form").attr("action","/index.php");
			document.getElementById("search_form").submit();
		}
	}
</script>