<?php

$rebeetlatitude = "" ;
$rebeetlatitude = "" ;

// Retrieve location data from the AJAX request
if (isset($_POST['latitude']) && $_POST['longitude']) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Sanitize and validate location data
    $latitude = filter_var($latitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    $longitude = filter_var($longitude, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
    // Connect to MySQL database
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "chat_application";
    
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Insert location data into database
    if ($latitude != $rebeetlatitude && $longitude != $rebeetlatitude) {
        session_start() ;
        $sender = $_SESSION["phone_number"] ;
        $receiver = $_SESSION["contact_phone_number"];
        $sql = "INSERT INTO `messages`(`id`, `sender`, `receiver`, `timestamp`, `content`) VALUES ('', $sender ,'$receiver', CURRENT_TIMESTAMP , 'MY LOCATION INFO IS =>  latitude : $latitude , longitude : $longitude')";
        $rebeetlatitude = $latitude;
        $rebeetlatitude = $longitude;
    }

    if ($conn->query($sql) === TRUE) {
        echo "Location data inserted successfully";
        header("location:./chat.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
}

?>


<!DOCTYPE html>
<html>

<head>
    <title>Location Form</title>
    <script>
        function getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(sendLocation);
            } else {
                alert("Geolocation is not supported by this browser.");
            }
        }

        function sendLocation(position) {
            var latitude = position.coords.latitude;
            var longitude = position.coords.longitude;

            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    //  alert(this.responseText);
                    window.location.href = "./chat.php";
                }
            };
            xhttp.open("POST", "location.php", true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("latitude=" + latitude + "&longitude=" + longitude);
        }
    </script>
</head>

<body>
    <form onsubmit="getLocation(); return false;">
        <input type="submit" value="Submit">
    </form>
</body>

</html>

