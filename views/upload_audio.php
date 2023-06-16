<?php  
// validation 
if (isset($_POST['save_audio']) && $_POST['save_audio']=="upload audio"){ 
    $audio_path = basename($_FILES['audioFile']['name']); 
    if (move_uploaded_file($_FILES['audioFile']['tmp_name'], $audio_path)){ 
        echo 'uploaded successfully '; 
        saveAudio($audio_path); 
        // displayAudios(); 
    } 
} 
 
// display audio on screen 
// function displayAudios(){ 
//     $conn = mysqli_connect('localhost', 'root', '', 'chat_application'); 
//     if (!$conn){ 
//         die('server not connected'); 
//     } 
//     $qry = "SELECT * FROM audios "; 
//     $r = mysqli_query($conn, $qry); 
//     while($row = mysqli_fetch_assoc($r)){ 
//         echo '<a href="chat.php?name='.$row["filename"].'">'.$row["filename"].'</a>'; 
//         echo '<br>'; 
//     } 
// } 
 
// save audio in database 
function saveAudio($fileName){ 
    $conn = mysqli_connect('localhost', 'root', '', 'chat_application'); 
    if (!$conn){ 
        die('server not connected'); 
    } 
    session_start() ;
    $sender = $_SESSION["phone_number"];
    $receiver = $_SESSION["contact_phone_number"];
    $qry = "INSERT INTO `messages`(`id`, `sender`, `receiver`, `timestamp`, `content`) VALUES ('','$sender','$receiver', CURRENT_TIMESTAMP , '$fileName')"; 
    mysqli_query($conn, $qry); 
    if (mysqli_affected_rows($conn)){ 
        echo 'audio file path saved in database'; 
        header("location:./chat.php") ;
    } 
} 
?> 
 
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
</head> 
<body> 
    <form action="upload_audio.php" method="POST" enctype="multipart/form-data"> 
        <input type="file" name="audioFile"> 
        <input type="submit" name="save_audio" value="upload audio"> 
    </form> 
</body> 
</html>