<?php
require '/var/www/html/menu/db.php';

// 전송된 파일정보가 없으면 종료
if (empty($_FILES['file'])) {
    exit();
}
if ($_FILES['file']['name']) {
    if (!$_FILES['file']['error']) {
        $uploadDir = 'img-uploads/';
        $errorImgFile = "img-uploads/userDefault.png";
        // 문자열을 "." 기준으로 나눠서 확장자를 분리한다
        $tempImgDir = explode(".", $_FILES['file']['name']);
        // 타임스탬프를 md5함수로 암호화하고 분리해놨던 확장자를 붙여서 랜덤한 파일명 생성
        $newFileName = md5(microtime()) . '.' . $tempImgDir[1];
        $fileLocation = $_FILES['file']['tmp_name'];
        // 랜덤한 새 파일명에 저장경로를 붙여서 최종파일경로 완성
        $fileDestination = $uploadDir . $newFileName;
        move_uploaded_file($fileLocation, $fileDestination);
        echo 'img-uploads/'. $newFileName;        
    }else{
        echo $_FILES['file']['error'];
    }
}
?>
