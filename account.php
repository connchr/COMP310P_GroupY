<!DOCTYPE html>

<html>
<head>
    <title>Your Account</title>
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

        .homeLink {

            float: left;

            margin-top: 16px;

            margin-left: -320px;

            font-family: 'Permanent Marker', cursive;

            font-size: 38px;

            transform: skew(-20deg);
        }

        a{
            color: ghostwhite;
            text-decoration: none;
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

        .YourAccount{
            font-size: 30px;
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
    <a href="home.php">It's Showtime</a>
</div>
<header>
    Manage, Create and join events here!
</header>

<div class='Account'>
    <?php
    $user = $_COOKIE["firstName"]; //get cookie of user from Login Page
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
    <input type="button" value="Host Events" id="HostEvents" onclick="location.href = 'hostEvents.php';" >
    <br>
    <input type="button" value="Your Orders" id="YourOrders" onclick="location.href = 'yourOrders.php';" >

</div>

<div class="YourAccount">
    Your Account:
    <br><br>
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
    $userID=$_COOKIE["userID"];

    $sql = "SELECT User_id, First_name, Last_name, `Password`, Email FROM `user` WHERE User_id='$userID'"; //SQL search
    $result = mysqli_query($connection, $sql);
    echo '<table border="1">'; // Create table with border of 1
    echo '<tr> 
<th>User ID</th>
<th>First Name</th>
<th>Last Name</th>
<th>Password</th>
<th>Email</th>
</tr>'; //enter of headings
    while ($row = mysqli_fetch_array($result)) {
        echo '
<tr>
<td>' . $row['User_id']. '</td>
<td>'. $row['First_name'].'</td>
<td>'. $row['Last_name'].'</td>
<td>'. $row['Password'].'</td>
<td>'. $row['Email'].'</td>
</tr>';
    }
    echo '</table>'; //closing of table

    mysqli_free_result($result);
    mysqli_close($connection);

    ?>
</div>

</body>
</html>