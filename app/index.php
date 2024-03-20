<?php
$host = "startrek-payroll-mysql";
$db_name = $_SERVER["MYSQL_DATABASE"];
$db_username = $_SERVER["MYSQL_USER"];
$db_password = $_SERVER["MYSQL_PASSWORD"];

$conn = new mysqli($host, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
if (!isset($_POST['s'])) {
?>
    <center>
        <form action="" method="post">
            <h2>Payroll Login</h2>
            <table style="border-radius: 25px; border: 2px solid black; padding: 20px;">
                <tr>
                    <td>User</td>
                    <td><input type="text" name="user"></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" name="password"></td>
                </tr>
                <tr>
                    <td><input type="submit" value="OK" name="s">
                </tr>
            </table>
        </form>
    </center>
<?php
}
?>

<?php
if ($_POST) {
    $user = $_POST['user'];
    error_log("USERNAME:" . $user);
    $pass = $_POST['password'];
    error_log("PASSWORD:" . $pass);

    // Use prepared statement to prevent SQL injection
    $sql = "select username, salary from users where username = ? and password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $user, $pass);
    $stmt->execute();

    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<center>";
        echo "<h2>Welcome, " . $user . "</h2><br>";
        echo "<table style='border-radius: 25px; border: 2px solid black;' cellspacing=30>";
        echo "<tr><th>Username</th><th>Salary</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr><td>" . $row['username'] . "</td><td>" . $row['salary'] . "</td></tr>";
        }
        echo "</table></center>";
    } else {
        echo "<center><h2>Login failed. Please try again.</h2></center>";
    }

    $stmt->close();
}
?>
