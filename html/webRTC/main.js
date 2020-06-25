'use strict';

const mediaStreamConstraints = {
	video: true,
	audio: true
};

// createOffer()함수에 인자로 들어갈 변수
const offerOptions = {
	offerToReceiveVideo: 1,
};

// 통화 시작 시간(defined as connection between peers).
let startTime = null;
//HTMLMediaElement 비디오를 각각 id값으로 가져온다
const localVideo = document.getElementById('localVideo');
const remoteVideo = document.getElementById('remoteVideo');

let localStream;
let remoteStream;

let localPeerConnection;
let remotePeerConnection;

// 내 영상 스트림을 가져오는 함수
function gotLocalMediaStream(mediaStream) {
	//srcObject : HTMLMediaElement의 속성. 미디어 객체를 설정하거나 반환한다. 
	localVideo.srcObject = mediaStream;
	localStream = mediaStream;
	trace('Received local stream.');
	callButton.disabled = false;  // 통화버튼 활성화
}

// Handles error by logging a message to the console.
function handleLocalMediaStreamError(error) {
	trace(`navigator.getUserMedia error: ${error.toString()}.`);
}

// 통화할 상대방의 영상 스트림을 가져오는 함수
function gotRemoteMediaStream(event) {
	const mediaStream = event.stream;
	remoteVideo.srcObject = mediaStream;
	remoteStream = mediaStream;
	trace('Remote peer connection received remote stream.');
}


// Add behavior for video streams.

// Logs a message with the id and size of a video element.
function logVideoLoaded(event) {
	const video = event.target;
	trace(`${video.id} videoWidth: ${video.videoWidth}px, ` +
				`videoHeight: ${video.videoHeight}px.`);
}

// Logs a message with the id and size of a video element.
// This event is fired when video begins streaming.
function logResizedVideo(event) {
	logVideoLoaded(event);

	if (startTime) {
		const elapsedTime = window.performance.now() - startTime;
		startTime = null;
		trace(`Setup time: ${elapsedTime.toFixed(3)}ms.`);
	}
}

localVideo.addEventListener('loadedmetadata', logVideoLoaded);
remoteVideo.addEventListener('loadedmetadata', logVideoLoaded);
remoteVideo.addEventListener('onresize', logResizedVideo);

// TODO: 잘 모르겠다. 다시보기.
// 사용자간의 연결을 정의하는 부분
// Connects with new peer candidate.
function handleConnection(event) {
	const peerConnection = event.target;
	const iceCandidate = event.candidate;

	if (iceCandidate) {
		const newIceCandidate = new RTCIceCandidate(iceCandidate);
		const otherPeer = getOtherPeer(peerConnection);

		otherPeer.addIceCandidate(newIceCandidate)
			.then(() => {
				handleConnectionSuccess(peerConnection);
			}).catch((error) => {
				handleConnectionFailure(peerConnection, error);
			});

		trace(`${getPeerName(peerConnection)} ICE candidate:\n` +
					`${event.candidate.candidate}.`);
	}
}

// Logs that the connection succeeded.
function handleConnectionSuccess(peerConnection) {
	trace(`${getPeerName(peerConnection)} addIceCandidate success.`);
};

// Logs that the connection failed.
function handleConnectionFailure(peerConnection, error) {
	trace(`${getPeerName(peerConnection)} failed to add ICE Candidate:\n`+
				`${error.toString()}.`);
}

// Logs changes to the connection state.
function handleConnectionChange(event) {
	const peerConnection = event.target;
	console.log('ICE state change event: ', event);
	trace(`${getPeerName(peerConnection)} ICE state: ` +
				`${peerConnection.iceConnectionState}.`);
}

// Logs error when setting session description fails.
function setSessionDescriptionError(error) {
	trace(`Failed to create session description: ${error.toString()}.`);
}

// Logs success when setting session description.
function setDescriptionSuccess(peerConnection, functionName) {
	const peerName = getPeerName(peerConnection);
	trace(`${peerName} ${functionName} complete.`);
}

// Logs success when localDescription is set.
function setLocalDescriptionSuccess(peerConnection) {
	setDescriptionSuccess(peerConnection, 'setLocalDescription');
}

// Logs success when remoteDescription is set.
function setRemoteDescriptionSuccess(peerConnection) {
	setDescriptionSuccess(peerConnection, 'setRemoteDescription');
}

// Logs offer creation and sets peer connection session descriptions.
function createdOffer(description) {
	trace(`Offer from localPeerConnection:\n${description.sdp}`);

	trace('localPeerConnection setLocalDescription start.');
	localPeerConnection.setLocalDescription(description)
		.then(() => {
			setLocalDescriptionSuccess(localPeerConnection);
		}).catch(setSessionDescriptionError);

	trace('remotePeerConnection setRemoteDescription start.');
	remotePeerConnection.setRemoteDescription(description)
		.then(() => {
			setRemoteDescriptionSuccess(remotePeerConnection);
		}).catch(setSessionDescriptionError);

	trace('remotePeerConnection createAnswer start.');
	remotePeerConnection.createAnswer()
		.then(createdAnswer)
		.catch(setSessionDescriptionError);
}

// Logs answer to offer creation and sets peer connection session descriptions.
function createdAnswer(description) {
	trace(`Answer from remotePeerConnection:\n${description.sdp}.`);

	trace('remotePeerConnection setLocalDescription start.');
	remotePeerConnection.setLocalDescription(description)
		.then(() => {
			setLocalDescriptionSuccess(remotePeerConnection);
		}).catch(setSessionDescriptionError);

	trace('localPeerConnection setRemoteDescription start.');
	localPeerConnection.setRemoteDescription(description)
		.then(() => {
			setRemoteDescriptionSuccess(localPeerConnection);
		}).catch(setSessionDescriptionError);
}

// 버튼
const startButton = document.getElementById('startButton');
const callButton = document.getElementById('callButton');
const hangupButton = document.getElementById('hangupButton');

// 전화걸기, 끊기 버튼의 기본 상태 = 비활성화
callButton.disabled = true;
hangupButton.disabled = true;

// 시작버튼을 누르는 함수
// getUserMedia함수로 미디어 입력장치 사용 권한을 받아오고 수락하면 gotLocalMediaStream()실행
function startAction() {
	startButton.disabled = true;
	navigator.mediaDevices.getUserMedia(mediaStreamConstraints)
		.then(gotLocalMediaStream).catch(handleLocalMediaStreamError);
	trace('Requesting local stream.');
}

// 통화 버튼을 누르는 함수: creates peer connection.
function callAction() {
	callButton.disabled = true; // 통화버튼 비활성화
	hangupButton.disabled = false; // 끊기 버튼 활성화

	trace('Starting call.');
	startTime = window.performance.now(); // 밀리세컨드 단위로 시간을 반환해준다

	// Get local media stream tracks.
	const videoTracks = localStream.getVideoTracks();
	const audioTracks = localStream.getAudioTracks();
	if (videoTracks.length > 0) {
		trace(`Using video device: ${videoTracks[0].label}.`);
	}
	if (audioTracks.length > 0) {
		trace(`Using audio device: ${audioTracks[0].label}.`);
	}

	// STUN, TURN 서버 설정
	const servers = {
		'iceServers' : [{
			'urls' : 'stun:stun.l.google.com:19302'
		}]
	}

	// 로컬 기기와 원격 피어를 연결하는 객체 생성. 매개변수로 연결 설정 옵션을 받는다.
	localPeerConnection = new RTCPeerConnection(servers);
	trace('Created local peer connection object localPeerConnection.');

	localPeerConnection.addEventListener('icecandidate', handleConnection);
	localPeerConnection.addEventListener(
		'iceconnectionstatechange', handleConnectionChange);

	remotePeerConnection = new RTCPeerConnection(servers);
	trace('Created remote peer connection object remotePeerConnection.');

	remotePeerConnection.addEventListener('icecandidate', handleConnection);
	remotePeerConnection.addEventListener(
		'iceconnectionstatechange', handleConnectionChange);
	remotePeerConnection.addEventListener('addstream', gotRemoteMediaStream);

	// 로컬 영상 스트림을 생성한 피어 연결 객체에 담는다
	localPeerConnection.addStream(localStream);
	trace('Added local stream to localPeerConnection.');

	// createOffer 함수를 사용해서 로컬 session description 정보를 받는다
	// session description(통신 전에 교환할 미디어의 정보, 화질등)
	// createOffer 함수가 성공하면 createdOffer 함수를 실행한다.
	trace('localPeerConnection createOffer start.');
	localPeerConnection.createOffer(offerOptions)
		.then(createdOffer).catch(setSessionDescriptionError);
}

// Handles hangup action: ends up call, closes connections and resets peers.
function hangupAction() {
	localPeerConnection.close();
	remotePeerConnection.close();
	localPeerConnection = null;
	remotePeerConnection = null;
	hangupButton.disabled = true;
	callButton.disabled = false;
	trace('Ending call.');
}

// Add click event handlers for buttons.
startButton.addEventListener('click', startAction);
callButton.addEventListener('click', callAction);
hangupButton.addEventListener('click', hangupAction);


// Define helper functions.

// Gets the "other" peer connection.
function getOtherPeer(peerConnection) {
	return (peerConnection === localPeerConnection) ?
			remotePeerConnection : localPeerConnection;
}

// Gets the name of a certain peer connection.
function getPeerName(peerConnection) {
	return (peerConnection === localPeerConnection) ?
			'localPeerConnection' : 'remotePeerConnection';
}

// Logs an action (text) and the time when it happened on the console.
function trace(text) {
	text = text.trim();
	const now = (window.performance.now() / 1000).toFixed(3);

	console.log(now, text);
}