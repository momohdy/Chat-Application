<?php
// class Call {
//     public $id ;
//     public $sender ;
//     public $receiver ;
//     public $duration ;

// }
?>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the offer from the AJAX request
    $offer = $_POST['offer'];

    // Process the offer as needed
    // Perform the necessary actions and respond back if required

    // Example response
    $response = 'Offer received';

    // Return the response to the AJAX request
    echo $response;
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>WebRTC Calling Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/d ist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />
    <script src="https://webrtc.github.io/adapter/adapter-latest.js"></script>
    <style>
        body {
            text-align: center;
            background-color: beige;
        }
    </style>
</head>

<body>


    <button id="callButton" onclick="initiateCall()" class="btn btn-outline-secondary"><i class="fa-solid fa-phone"></i> Call</button>
    <video id="localVideo" autoplay></video>
    <video id="remoteVideo" autoplay></video>
    <button id="endCallButton" onclick="endVideoCall()" class="btn btn-outline-secondary"><i class="fa-solid fa-phone-slash"></i> End Call</button>
    <a href="../views/chat.php"> <button type="button" class="btn btn-secondary m-3 w-20" styles="display:inline-block"><- CHAT PAGE </button>
    </a>
    <script>
        let localStream;
        let remoteStream;
        let localVideo = document.getElementById('localVideo');
        let remoteVideo = document.getElementById('remoteVideo');
        let peerConnection;

        async function initiateCall() {
            try {
                localStream = await navigator.mediaDevices.getUserMedia({
                    audio: true,
                    video: true});
                localVideo.srcObject = localStream;

                peerConnection = new RTCPeerConnection();
                peerConnection.ontrack = handleRemoteStreamAdded;
                localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));

                const offer = await peerConnection.createOffer();
                await peerConnection.setLocalDescription(new RTCSessionDescription(offer));

                // Send the offer to the server-side PHP script using AJAX
                const xhr = new XMLHttpRequest();
                xhr.open('POST', 'file.php');
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onload = function() {
                    // Process the response from the server if needed
                    console.log(xhr.responseText);
                };
                xhr.send(`offer=${encodeURIComponent(offer.sdp)}`);
            } catch (error) {
                console.error('Failed to initiate call:', error);
            }
        }

        function handleRemoteStreamAdded(event) {
            remoteStream = event.streams[0];
            remoteVideo.srcObject = remoteStream;
        }

        function endVideoCall() {
            // Stop the tracks in the local stream
            localStream.getTracks().forEach(track => track.stop());
            // Remove the local stream from the local video element
            localVideo.srcObject = null;
            // Remove the remote stream from the remote video element
            remoteVideo.srcObject = null;
            // Revoke the media stream permissions
            localStream.getTracks().forEach(track => track.enabled = false);
            // Add code here to disconnect from the remote peer and end the call

        }
    </script>

</body>

</html>