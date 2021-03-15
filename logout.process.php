<?php
    include "lib.php";

    if(!session("user")){
        back("로그인후 사용할수 있습니다.");
        exit;
    }
    
    session_destroy();
    go("로그아웃 했습니다.","/");