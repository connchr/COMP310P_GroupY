<!DOCTYPE html>

<html>
<head>
    <title>Your Orders</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

    <style>
        body {
            background: url('http://localhost/Events%20project/Background2.jpg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-position: 0px 0px;
        }
        header{
            text-align: center;
            color: white;
            font-size: 50px;
            padding-top:30px;
            padding-bottom: 30px;
            margin:5px;
            border-radius: 10px;
            border: inset 5px;
            background-color: #A0793D;
        }
        .homeLinkBackgroundPad{

            margin-top: 10px;

            float: left;

            margin-left: 20px;

            border-top: 85px solid black;

            border-left: 70px solid transparent;

            border-right: 85px solid transparent;

            height: 0;

            width: 225px;

            transform: skew(-20deg);

        }

        .homeLinkPad{

            float: left;

            margin-top: 15px;

            margin-left: -370px;

            border-top: 75px solid #502900;

            border-left:65px solid transparent;

            border-right: 80px solid transparent;

            height: 0;

            width: 215px;

            transform: skew(-20deg);

        }

        .homeLink{

            float: left;

            margin-top: 16px;

            margin-left: -320px;

            font-family: 'Permanent Marker', cursive;

            font-size: 38px;

            transform: skew(-20deg);

            color: ghostwhite;

        }
        .Account{
            font-family: "Brush Script MT";
            font-size: 35px;
            text-align: center;
            vertical-align: middle;
            width:290px;
            float:left;
            margin:5px;
            border-radius: 10px;
            background-color: #C8A165;
            border: inset;
            color: white;
            height: 100px;
        }

        .Selection{
            padding: 20px;
            width:250px;
            clear: left;
            float:left;
            margin:5px;
            text-align: center;
            border-radius: 10px;
            background-color: #E6BF83;
            border: inset;
            height: 200px;
        }

        input{
            font-size: 25px;
            margin-bottom:20px;
            border-radius: 10px;
            background-color: whitesmoke;
        }

        .YourOrders{
            font-size: 20px;
            margin:5px;
            border: inset;
            border-radius: 10px;
            height: 370px;
            background-color: transparent;
        }

    </style>
</head>
<body>
<div class="homeLinkBackgroundPad"></div>
<div class="homeLinkPad"></div>
<div class="homeLink">
    It's Showtime
</div>
<header>
    Manage, Create and join events here!
</header>

<div class='Account'>
    <?php
    $user = $_COOKIE["firstName"]; //get cookie of user from Login Page
    $userID = $_COOKIE["userID"]; // get cookie of userID from Login Page
    echo "Welcome ".$user; //Show Account details
    ?>
    <br>
    <form action="It'sShowtime(Start Point).php"> <!-- Link to main page after Log out -->
        <input type="submit" value="Log Out" id="Logout">
        <?php
        setcookie("firstName", "", time() - 1); //reset Cookie
        setcookie("userID","",time()-1); //reset Cookie
        ?>
    </form>


</div>

<div class='Selection'>
    <input type="button" value="Search Events" id="SearchEvents" onclick="location.href = 'home.php';" >
    <br>
    <input type="button" value="Your Events" id="YourEvents" onclick="location.href = 'yourEvents.php';" >
    <br>
    <input type="button" value="Your Account" id="YourAccount" onclick="location.href = 'account.php';" >
    <br>
    <input type="button" value="Host Events" id="HostEvents" onclick="location.href = 'hostEvents.php';" >
</div>

<div class="YourOrders">
    <h3>Your Orders:</h3>
    <br>
    <?php

    function connect() {
        $dbuser = 'root';
        $dbpass = 'root';
        $dbname = 'events';
        $dbhost = 'localhost';

        $connection = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname);

        if (!$connection) {
            echo "Error: Unable to connect to MySQL." . PHP_EOL;
            echo "Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
            echo "Debugging error: " . mysqli_connect_error() . PHP_EOL;
            exit;
        }

        return $connection;
    }

    $message="";

    $connection = connect();

    //sql search for shows hosted by the user

    $sql1 = "SELECT `event`.Title, show_details.Venue, show_details.Start_time, show_details.End_time, show_details.date, sales.Tickets_brought, `event`.`Event_id`, `show_details`.`Show_id` FROM `event`
JOIN `show` ON `show`.`Event_id` = `event`.`Event_id`
JOIN `show_details` ON `show_details`.`Show_id` = `show`.`Show_id`
JOIN `sales` ON `show_details`.`Show_id` = sales.Show_id
WHERE sales.User_id = '$userID'";
    $result1 = mysqli_query($connection, $sql1);



    if (mysqli_num_rows($result) === 0) {
        $message = "*Sorry, you have no upcoming events";
    }
    else {
        echo '<table border="1">';
        echo '<tr>
<th>Title</th>
<th>Venue</th>
<th>Start Time</th>
<th>End Time</th>
<th>Date</th>
<th>Tickets Brought</th>
<th>Reminder</th>
<th>Review</th>
</tr>';
        while ($row1 = mysqli_fetch_array($result1)) {
            $ShowID = $row1['Show_id'];
            echo '
<tr>
<td>' . $row1['Title']. '</td>
<td>'. $row1['Venue'].'</td>
<td>'. $row1['Start_time'].'</td>
<td>'. $row1['End_time'].'</td>
<td>'. $row1['date'].'</td>
<td>'. $row1['Tickets_brought'].'</td>
<td>'.'<form action="emailSent.php" method="post"><button name="SendEmail" value='.$ShowID.' type="submit">Send email</button></form>'.'</td> <!-- form submitted to emailSent.php-->
<td>'.'<form action="feedback.php"><button name="Feedback" value='.$ShowID.' type="submit">Feedback</button></form>'.'</td> <!-- form submitted to feedback.php-->
</tr>';
        }
        echo '</table>';
    }

    mysqli_free_result($result1);
    mysqli_close($connection);

    echo $message;
    ?>
</div>

</body>
</html>
