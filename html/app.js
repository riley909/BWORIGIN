const express = require('express');
const app = express();
const http = require('http').createServer(app);
// http서버를 socket.io서버로 업그레이드
const socketIO = require('socket.io')(http);
const path = require('path');
const { isObject } = require('util');
const PORT = 3000;

// use()함수를 통해 static 폴더를 설정한다.
app.use(express.static(path.join(__dirname, 'webRTC')));
app.use(express.static(path.join(__dirname, 'node_modules')));
app.use((req, res, next) => {
    // TODO:  찾아보기(해당미들웨어의 config가 위치한뒤 next()로 다음 미들웨어로 넘어가도록 처리한다.)
    next()
});

// 모든 request가 webRTC.html를 response하도록 설정
app.get('/', (req, res) => {
    res.status(200).sendFile(path.join(__dirname + '/webRTC.html'))
})

// 채팅 접속자 명단을 저장할 배열
let onlineUser = [];
let count = 1;
// 사용자가 접속하면 socket.io에 의해 'connection' 이벤트가 자동으로 발생
socketIO.on('connection', function (socket) {
    // name : 유저 이름 생성
    let name = "user" + count++;
    console.log('user connected: ', socket.id);
    // .to(socket.id).emit(): 접속한 해당 socket.id 에만 이벤트 전달
    socketIO.to(socket.id).emit('changeName', name);
    // 채팅 접속자 명단을 출력하기 위해 push로 새로 들어오는 유저를 배열에 추가시킨다
    onlineUser.push({id: socket.id, name: name});
    console.log('list: ', onlineUser);
    // 신규 유저를 추가하기 위해 명단 업데이트
    updateUserList();
  
    // 접속이 해제되는 경우 콘솔로 소켓아이디 출력
    socket.on('disconnect', function () {
        console.log('user disconnected: ', socket.id);
        for(let i=0; i < onlineUser.length; i++){
            if(onlineUser[i].id == socket.id){
                console.log('나간사람아이디: ', onlineUser[i].id);
                console.log('나간사람: ', onlineUser[i]);
                // i번째의 인덱스 1개 삭제
                onlineUser.splice(i, 1);
                console.log(onlineUser);
            }
        }
        // 연결 종료된 유저를 제외하기 위해 명단 업데이트
        updateUserList();
    });

    // 접속자가 메세지를 보낼경우 발생하는 이벤트
    socket.on('sendMessage', function (msg) {
        console.log(msg);
        socketIO.emit('receiveMessage', {comment: name + ":" + msg.comment + '\n'});
    });

    // 새로 유저가 들어오거나 나가면 접속자 명단 업데이트 실행을 시작하는 함수
    // 클라이언트 단으로 넘어간다
    function updateUserList(){
        socketIO.emit('update', onlineUser);
    }
});

http.listen(PORT, () => {
    console.log(`Listen : ${PORT}`)
});