<?php

/* authenticate users, connect to the database,
valid form data, retrieve database results, and
create new sessions */

session_start();

$DATABASE_HOST = 'localhost';
$DATABASE_USER = 'root';
$DATABASE_PASS = '';
$DATABASE_NAME = 'phplogin';

# Try to connect
$con = mysqli_connect($DATABASE_HOST, $DATABASE_USER, $DATABASE_PASS, $DATABASE_NAME);
if ( mysqli_connect_errno() ) {
	# If there is an error with the connection, stop the script and display the error
	exit('Failed to connect to MySQL: ' . mysqli_connect_error());
}

# Validate if the data from the login form was submitted, isset() will check if the data exists
if ( !isset($_POST['username'], $_POST['password']) ) {
	exit('Please fill both the username and password fields!');
}

# Prevent SQL injection
if ($stmt = $con->prepare('SELECT id, password FROM accounts WHERE username = ?')) {
	# Bind parameters (s = string, i = int, b = blob)
	$stmt->bind_param('s', $_POST['username']);
	$stmt->execute();
	# Store the result so we can check if the account exists in the database.
	$stmt->store_result();

    #check if username exists
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id, $password);
        $stmt->fetch();
        # Verify the password
        # Create and store hashed passwords
        if (password_verify($_POST['password'], $password)) {
            # Verification success! User has logged-in!
            # Create sessions
            session_regenerate_id();
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['name'] = $_POST["username"];
            $_SESSION['id'] = $id;
            #START HOME PAGE (logged in complete!)

            header('Location: dashboardHome.php');
        } else {
            # Incorrect password
            # echo 'Incorrect username and/or password!';
?>
            <script type="text/javascript">
                alert("You entered the wrong username and/or password! Click 'ok' to try again.");
                window.location.href = "index.html";
            </script>
<?php
        }
    } else {
        # Incorrect username
        #echo 'Incorrect username and/or password!';
?>
        <script type="text/javascript">
            alert("You entered the wrong username and/or password! Click 'ok' to try again.");
            window.location.href = "index.html";
        </script>
<?php
    }

	$stmt->close();
}
?>