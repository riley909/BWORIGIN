// 전역에 선언하여 엄격 모드 사용. 오류를 찾을 수 있다
"use strict";

// localVideo : 내 화면
// remoteVideo : 상대방 화면
// isInitiated: 
// isChannelReady:
// isStarted:
// localStream:
// remoteStream:
// pc = new RTCPeerConnection(null);
let localVideo = document.getElementById("localVideo");
let remoteVideo = document.getElementById("remoteVideo");
let isInitiated = false;
let isChannelReady = false;
let isStarted = false;
let localStream;
let remoteStream;
let pc;

// 소켓통신에 대한 부분을 정의해서 데이터 교환을 올바르게 할 수 있게 해준다.
// ice(Interactive Connectivity Establishment)
let pcConfig = {
    'iceServers': [{
        'urls': 'stun:stun.l.google.com:19302'
      }]
}
let socket = io.connect();
let room = 'foo';

if(room !==''){
	socket.emit('create or join',room);
	console.log('Attempted to create or join Room',room);
}

socket.on('created', (room,id)=>{
	console.log('Created room' + room+'socket ID : '+id);
	isInitiated = true;
})

socket.on('full', room=>{
	console.log('Room '+room+'is full');
});

socket.on('join',room=>{
	console.log('Another peer made a request to join room' + room);
	console.log('This peer is the initiator of room' + room + '!');
	isChannelReady = true;
})

socket.on('joined',room=>{
	console.log('joined : '+ room );
	isChannelReady= true;
})
socket.on('log', array=>{
	console.log.apply(console,array);
});

// 소켓통신에 대한 부분을 정의해서 데이터 교환을 올바르게 할 수 있게 해준다.
socket.on('message', (message)=>{
	console.log('Client received message :',message);
	if(message === 'got user media'){
		maybeStart();
	}else if(message.type === 'offer'){
		if(!isInitiated && !isStarted){
			maybeStart();
		}
		pc.setRemoteDescription(new RTCSessionDescription(message));
		doAnswer();
	}else if(message.type ==='answer' && isStarted){
		pc.setRemoteDescription(new RTCSessionDescription(message));
	}else if(message.type ==='candidate' &&isStarted){
		const candidate = new RTCIceCandidate({
		sdpMLineIndex : message.label,
		candidate:message.candidate
    });
	pc.addIceCandidate(candidate);
	}
})

// 시그널링 서버로 소켓정보를 전송하는 메소드이다.
// 시그널링 서버, 다른 Peer로의 데이터를 전송하는 method라고 보면 된다.
function sendMessage(message){
	console.log('Client sending message: ',message);
	socket.emit('message',message);
}

// mediaDevice 객체의 getUserMedia Method를 통해서 사용자의 미디어 데이터를 받아올 수 있다. 
// localStream과 localVideo에 출력할 영상을 내 카메라로 지정한다.
navigator.mediaDevices
	.getUserMedia({
		video: true,
		audio: false,
	})
	.then(gotStream)
	.catch((error) => console.error(error));

function gotStream(stream) {
	console.log("Adding local stream");
	localStream = stream;
	localVideo.srcObject = stream;
	sendMessage("got user media");
	if (isInitiated) {
		maybeStart();
	}
}

// RTC Peer 연결하기
// createPeerConnection을 통해 RTCPeerConnection에 대한 객체를 형성해주고 있다.
// iceCandidate는 데이터 교환을 할 대상의 EndPoint 정보라고 보면 된다.
// 따라서 iceCandidate할 대상이 생긴다면 handleIceCandidate Method를 실행하게 된다.
// 이 부분은 signaling 서버로 넘겨줘 상대방 Peer가 내 Stream을 연결할 수 있도록 한다.
// 연결된 Peer는 handleRemoteStreamAdded Method를 통해서 remoteVideo 뷰에 띄우도록 한다.
function createPeerConnection() {
	try {
		pc = new RTCPeerConnection(null);
		pc.onicecandidate = handleIceCandidate;
		pc.onaddstream = handleRemoteStreamAdded;
		console.log("Created RTCPeerConnection");
	} catch (e) {
		alert("connot create RTCPeerConnection object");
		return;
	}
}

function handleIceCandidate(event) {
	console.log("iceCandidateEvent", event);
	if (event.candidate) {
		sendMessage({
		type: "candidate",
		label: event.candidate.sdpMLineIndex,
		id: event.candidate.sdpMid,
		candidate: event.candidate.candidate,
		});
	} else {
		console.log("end of candidates");
	}
}

function handleCreateOfferError(event) {
	console.log("createOffer() error: ", event);
}

function handleRemoteStreamAdded(event) {
	console.log("remote stream added");
	remoteStream = event.stream;
	remoteVideo.srcObject = remoteStream;
}

// 자신의 RTCPeerConnection을 초기화하고 상대방의 RTCPeerConnection과 연결하는 함수이다.
// 실제로 연결이 됐다면 doCall함수를 실행시켜 데이터를 주고 받는다.
function maybeStart() {
	console.log(">>MaybeStart() : ", isStarted, localStream, isChannelReady);
	if (!isStarted && typeof localStream !== "undefined" && isChannelReady) {
		console.log(">>>>> creating peer connection");
		createPeerConnection();
		pc.addStream(localStream);
		isStarted = true;
		console.log("isInitiated : ", isInitiated);
		if (isInitiated) {
		doCall();
		}
	}else{
		console.error('maybeStart not Started!');
	}
}

// doCall과 doAnswer를 통해서 Description을 교환
// 이 과정을 통해서 내 화상 정보가 상대방에게, 상대방의 화상정보가 내 뷰에 출력됨
function doCall() {
	console.log("Sending offer to peer");
	pc.createOffer(setLocalAndSendMessage, handleCreateOfferError);
}

function doAnswer() {
	console.log("Sending answer to peer");
	pc.createAnswer().then(
		setLocalAndSendMessage,
		onCreateSessionDescriptionError
	);
}

function setLocalAndSendMessage(sessionDescription) {
	pc.setLocalDescription(sessionDescription);
	sendMessage(sessionDescription);
}

function onCreateSessionDescriptionError(error) {
	console.error("Falied to create session Description", error);
}