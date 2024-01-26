<?php
$username = $_POST['email'];  // Use proper case for _POST, and remove the & before _POST.
$password = $_POST['password']; // Use proper case for _POST.

if (!empty($username) || !empty($password)) {
    $host = "localhost";
    $dbusername = 'root';
    $dbpassword = '';
    $dbname = "youtube";

    $conn = new mysqli($host, $dbusername, $dbpassword, $dbname);

    if (mysqli_connect_error()) {
        die('Connect Error (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
    } else {
        $SELECT = "SELECT email FROM register WHERE email = ? LIMIT 1";
        $INSERT = "INSERT INTO register (username, password) VALUES (?, ?)";
        
        $stmt = $conn->prepare($SELECT);
        $stmt->bind_param("s", $username); // Correct the variable name to $username.
        $stmt->execute();
        $stmt->store_result();
        $rnum = $stmt->num_rows; // Add a missing semicolon.

        if ($rnum == 0) {
            $stmt->close();

            $stmt = $conn->prepare($INSERT);

            $stmt->bind_param("ss", $username, $password); // You only have two parameters, so use "ss" for string values.
            $stmt->execute();
            echo "New record inserted successfully";
        } else {
            echo "Someone already registered using this email";
        }
        $stmt->close();
        $conn->close(); // Add a missing semicolon and () to close the connection properly.
    }
}
else{
    echo all feild are require;
    die();
}
?>
