<?php

	include 'Connection/connection.php';

    // Start the session
    session_start();

     // Start the session
    session_start();

    if(isset($_SESSION['username'])) {
        echo "<script type='text/javascript'> window.location.href = 'showleads/index.php'; </script>";
    } else {
    	
    }

    include 'Connection/connection.php';

    if(isset($_POST['email']) && isset($_POST['password'])) {
        $email =$_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `access` WHERE `username` = '$email' AND BINARY `password` = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows == 1) {

            while($row = $result->fetch_assoc()){

                $_SESSION['username'] = $row['username'];

                echo "<script type='text/javascript'> window.location.href = 'showleads/index.php'; </script>";

            }
        } else {
            echo "
                <script type='text/javascript'>
                    alert('Incorrect username or password');
                    window.location.href = 'index.php';
                </script>
            ";
        }

        $con->close();

    }

?>

<html lang="en">
	<head>
	    <meta charset="UTF-8">
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	    <title>Site Visit Leads Manager</title>
	    <!--Bootstrap Latest compiled and minified CSS -->
	    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	    <!--fontawesome cdn -->
	    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
	   	<!-- common styles -->
	    <link rel="stylesheet" href="Styles/primarystyles.css">
	    <!-- manifest file -->
	    <link rel="manifest" href="manifest.json">
	    <!-- ios support -->
	    <link rel="apple-touch-icon" href="Images/icon-96x96.png">
	    <meta name="apple-mobile-web-app-status-bar" content="#5f9ea0">
	</head>
	<body>


	    <div class="Login-Container">
	        <div class="Login text-center">

	            <img src="Images/logo.png" alt="Livnest Logo" width="174" height="48"><br />

	            <small>Livnest CRM Login Page</small>

	            <form action="" method="POST">
	                <div>
	                    <label for="email">Username</label>
	                    <input type="text" id="email" name="email" autocomplete="off" onfocus="loginLabelPushUp(this.id)" onblur="loginLabelPushDown(this.id)" required>
	                </div>

	                <div>
	                    <label for="password">Password</label>
	                    <input type="password" id="password" name="password" onfocus="loginLabelPushUp(this.id)" onblur="loginLabelPushDown(this.id)" required>
	                </div>

	                <input type="submit">
	            </form>

	        </div>
	    </div>

	    <script type="text/javascript">
	    	
			//login page label transition
			function loginLabelPushUp(id) {
			    $(`#${id}`).prev().css({'top': '0%', 'left': '0%', 'transform': 'none', 'color': 'rgb(38,87,125)', 'font-weight': 'bolder'});
			    $(`#${id}`).css({'border-bottom': '1px solid rgb(38,87,125)'});
			}

			function loginLabelPushDown(id) {
			    if($(`#${id}`).val() === "") {
			        $(`#${id}`).prev().css({'top': '50%', 'left': '50%', 'transform': 'translate(-50%, -50%)', 'color': 'red', 'font-weight': 'bolder'});
			        $(`#${id}`).css({'border-bottom': '1px solid red'});

			    } else {
			        $(`#${id}`).prev().css({'top': '0%', 'left': '0%', 'transform': 'none'});
			    }
			}

	    </script>


	    <!-- jQuery library -->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	    <!-- Popper JS -->
	    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>

	    <!-- Bootstrap Latest compiled JavaScript -->
	    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	</body>
</html>