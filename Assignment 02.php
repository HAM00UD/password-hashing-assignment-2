<?php
session_start();

function hash_password($password)
{
    return password_hash($password, PASSWORD_BCRYPT);
}

function verify_password($password, $hash)
{
    return password_verify($password, $hash);
}

$password = "";
$hash = "";
$result = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["hash"])) {
        $password = $_POST["password"];
        $hash = hash_password($password);
        $_SESSION["hash"] = $hash;
    }

    if (isset($_POST["verify"])) {
        $password = $_POST["password"];
        if (isset($_SESSION["hash"])) {
            $hash = $_SESSION["hash"];
            if (verify_password($password, $hash)) {
                $result = "match";
            } else {
                $result = "no match";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Password Hashing</title>
</head>
<body>

<form method="post">
    <input type="password" name="password" placeholder="Enter password" required>
    <br><br>
    <input type="submit" name="hash" value="Hash">
    <input type="submit" name="verify" value="Verify">
</form>

<br>

<?php
if ($password != "") {
    echo "Password: " . $password . "<br><br>";
}

if ($hash != "") {
    echo "Hash: " . $hash . "<br><br>";
}

if ($result != "") {
    echo "Result: " . $result;
}
?>

</body>
</html>
