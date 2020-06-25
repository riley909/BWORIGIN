<?php
session_start();
$session=session_destroy();

// 세션파괴되면 index로 돌아감
if($session){
  header('Location: ./index.php');
}
 ?>

 <!-- session_start()는 사용할 스크립트 최상단에 호출.
 어떤것도 먼저 브라우저에 전송되면 안됨.
 사용자의 시스템에 세션아이디를 쿠키형태로 발급해주기 때문.(?)

 session_unset
 -변수의 값을 삭제하고 변수도 소멸시킴
 session_unregister
 -변수는 그대로 두고 변수값만 지운다
 session_destroy
 -현재 모든 세션의 변수값을 없애고 변수도 없앤다

*session_unset을 사용하는 것이 좋다(왜?)

session_is_registered
-세션 변수가 현재 세션에 등록되어 있는지 조사하는 함수(?)

*웹 브라우저 메뉴/도구/인터넷옵션/보안/기본수준이 높음 일때
 도구/인터넷옵션/개인정보에서 모든쿠키 차단일때 세션 제대로 동작안함 -->