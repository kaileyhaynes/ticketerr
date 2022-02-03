<?php
#signup verification

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
} else if ( !isset($_POST['firstName'], $_POST['lastName'])) {
    exit("Please fill both your first and last name!");
} else if ( !isset($_POST['email'])) {
    exit("Please fill the email field!");
} //add else if for LNum

/*
if ($stmt->num_rows > 0) {
    exit("Sorry, an identical account already exists. Try again.");
} else {
*/

#prepare and bind
    $stmt = $con->prepare("INSERT INTO accounts (username, password, email, firstName, lastName, LNum) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssi", $username, $password, $email, $firstName, $lastName, $LNum);

    #set parameters
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $email = $_POST["email"];
    $username = $_POST["username"];
    $LNum = $_POST["LNum"];
    #make and store the hash of a password
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT);
    if ($LNum == NULL) {
        $LNum = NULL;
    }
    $stmt->execute();

    #echo "Account successfully made!";

    header('Location: index.html');
$stmt->close();

?>