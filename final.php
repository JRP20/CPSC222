<?php
	session_start();
?>
<html>
	<title>CPSC222 Final Exam</title>
</html>
<?php


function sanitize_input($input) {
    return preg_replace("/[^a-zA-Z0-9]/", "", $input);
}

function header_section() {
    echo "<h1>CPSC222 Final Exam</h1>";
}

function footer() {
    $currentDateTime = (new DateTime())->format('Y-m-d h:i:s A');
    echo "<hr>";
    echo "<footer><a style='text-decoration: none; color: inherit; cursor: default;' href='final.php?page=87'>$currentDateTime</a></footer>";
}

function authenticate($username, $password) {
    $file = fopen("auth.db", "r");
    while (($line = fgets($file)) !== false) {
        list($stored_user, $stored_hashed_password) = explode("\t", trim($line));
        if ($stored_user === $username && password_verify($password, $stored_hashed_password)) {
            fclose($file);
            return true;
        }
    }
    fclose($file);
    return false;
}

if (isset($_GET['logout']) && $_GET['logout'] === 'true') {
    header("Location: final_logout.php"); 
}

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header_section();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = sanitize_input($_POST["username"]);
        $password = sanitize_input($_POST["password"]);

        if (authenticate($username, $password)) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $username;
            header("Location: final.php");
            exit;
        } else {
            echo "<p>Invalid username or password.</p>";
        }
    }

    ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <input type="submit" value="Login">
    </form>
    <?php
    footer();
    return;
}

header_section();
echo "<h3>Welcome, " . $_SESSION['username'] . "! (<a href='final_logout.php'>Log Out</a>) </h3>";

function displaydash() {
    echo "<p>Dashboard: </p>";
    echo "<ul>";
    echo "<li><a href='final.php?page=1'>User List</a></li>";
    echo "<li><a href='final.php?page=2'>Group List</a></li>";
    echo "<li><a href='final.php?page=3'>Syslog</a></li>";
    echo "</ul>";
}

$page = isset($_GET['page']) ? trim(sanitize_input($_GET['page'])) : "";

if ($page === "1") {
    echo "<p><a href='final.php'>< Back to Dashboard</a></p>";
    echo "<h4>User list</h4>";
    echo "<table border='1'>";
    echo "<tr><th>Username</th><th>Password</th><th>UID</th><th>GID</th><th>Display Name</th><th>Home Directory</th><th>Default Shell</th></tr>"; 
    $passwrd = file("/etc/passwrd");
    foreach ($passwrd as $line) {
        $fields = explode(":", $line);
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<td>$field</td>";
        }
        echo "</tr>";
    }
    echo "</table>";
} elseif ($page === "2") {
    // Group list 
    echo "<p><a href='final.php'>< Back to Dashboard</a></p>";
    echo "<h4>Group list</h4>";
    echo "<table border='1'>";
    echo "<tr><th>Group Name</th><th>Password</th><th>GID</th><th>Members</th></tr>"; 
    $group = file("/etc/group");
    foreach ($group as $line) {
        $fields = explode(":", $line);
        echo "<tr>";
        foreach ($fields as $field) {
            echo "<td>$field</td>";
        }
        echo "</tr>";
    }
    echo "</table>";

} elseif ($page === "3") {
    // Syslog
    echo "<p><a href='final.php'>< Back to Dashboard</a></p>";
    echo "<h4>Syslog</h4>";
    echo "<table border='1'>";
    echo "<tr><th>Date</th><th>Hostname</th><th>Application[PID]</th><th>Message</th></tr>"; 
    $syslines = file("/var/log/syslog");
    foreach ($syslines as $line) {
        $parts = explode(' ', $line, 5);
        if (count($parts) === 5) {
            $date_time = $parts[0] . ' ' . $parts[1] . ' ' . $parts[2];
            $host_name = $parts[3];
            $rest = explode(':', $parts[4], 2);
            $application = $rest[0];
            $message = $rest[1];
            echo "<tr><td>$date_time</td><td>$host_name</td><td>$application</td><td>$message</td></tr>";
        }
    }
    echo "</table>";
} elseif ($page === "") {
    displaydash();
} else {
	echo "<p><a href='final.php'>< Back to Dashboard</a></p>";
	echo "<p>Invalid page.</p>";
}

footer();
?>
