<?php
$dsn = 'mysql:host=localhost;dbname=dbvd7qv7ggb27w;charset=utf8mb4';
$username = 'uer0schhg2gvk';
$password = 'Hed87djhw';

$account = "";
$errorMessage = "";
$row = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $account = isset($_POST["account"]) ? trim($_POST["account"]) : "";

    // Validate input before querying
    if ($account === "") {
        $errorMessage = "Account ID is required";
    } else {
        try {
            $pdo = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);

            $statement = $pdo->prepare(
                'SELECT *
                 FROM `accounts`
                 WHERE `Account` = :account
                 LIMIT 1'
            );
            $statement->execute(['account' => $account]);
            $row = $statement->fetch();

            if ($row === false) {
                $errorMessage = "Account not found";
            }
        } catch (PDOException $e) {
            error_log($e->getMessage());
            $errorMessage = "The database is not available.";
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Account Lookup</title>
</head>
<body>
    <h2>Account Lookup</h2>
    <form action="" method="post">
        Account ID:
        <input type="text" name="account"
               value="<?php echo htmlspecialchars($account); ?>" />
        <br /><br />

        <input type="submit" value="Look Up" />
    </form>

    <br />

    <?php
    if ($errorMessage !== "") {
        echo '<p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
    }

    if ($row !== false) {
        echo "<h3>Account Information</h3>";
        echo "<table border='1'>";
        foreach ($row as $column => $value) {
            echo "<tr>";
            echo "<th>" . htmlspecialchars($column) . "</th>";
            echo "<td>" . htmlspecialchars($value) . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    }
    ?>
</body>
</html>
