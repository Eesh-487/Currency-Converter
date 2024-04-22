<?php
session_start();

// Connect to the database
$host = "localhost";
$user = "username";
$password = "password";
$dbname = "login";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

function login($username, $password) {
    // Query the database to check if the user exists
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        return true;
    } else {
        return false;
    }
}

if (isset($_POST['username']) && isset($_POST['password'])) {
    if (login($_POST['username'], $_POST['password'])) {
        $_SESSION['username'] = $_POST['username'];
        header("Location: ind2.html");
    } else {
        echo "Invalid username or password.";
    }
} elseif (isset($_POST['logout'])) {
    unset($_SESSION['username']);
    echo "You have been logged out.";
}

if (!isset($_SESSION['username'])):
?>

<form action="index.php" method="post">
    <h1>Login</h1>
    <div>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username">
    </div>
    <div>
        <label for="password">Password:</label>
        *<input type="password" name="password" id="password">
    </div>
    <section>
        <button type="submit">Login</button>
    </section>
</form>

<?php else:?>

<form action="index.php" method="post">
    <button type="submit" name="logout">Logout</button>
</form>

<?php endif;?>