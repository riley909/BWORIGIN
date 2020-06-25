// 소켓을 연결
var socket = io.connect('http://localhost:3000');

// 서버에서 전달한 데이터가 있을 때 실행되는 이벤트 리스너
//receiveMessage 이벤트를 전달받으면 msg.comment를 클라이언트 콘솔에 출력+chatRoom(textarea)에 누적 출럭
socket.on('receiveMessage', function (msg) {
    console.log(msg.comment)
    $('#chatRoom').append(msg.comment);
    // TODO: 스크롤 자동으로 내려가도록 하기
    // $('#chatRoom').scrollTop($('#chatRoom')[0].scrollHeight);
});
// 새로 접속한 유저에게 user+n 의 새 이름을 배정한다
socket.on('changeName', function(name){
    $('#name').val(name);
});

let userList = [];
socket.on('update', function(users){
    userList = users;
    console.log('userList: ', userList);
    // 업데이트를 하기 전 중첩을 방지하기 위해서 이미 출력되어있던 텍스트를 지운다
    $('#userlist').empty();
    for(let i=0; i < userList.length; i++){
        $('#userlist').append(userList[i].name +'</br>')
    }
});

// 보내기 버튼의 클릭이벤트. 소켓의 데이터를 보낸다.
// comment라는 변수에 input태그(채팅입력창)값을 담아서 전송한 뒤 입력창 내용은 지운다
function sendMsg() {
    socket.emit('sendMessage', { comment: $('#chatInput').val() });
    console.log(comment);
    $('#chatInput').val('');
    $('#chatInput').focus();
}