<?php
$resultMessage = "";
$errorMessage = "";
$history = "";

if (isset($_COOKIE["history"])) {
    $history = $_COOKIE["history"];
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $num1 = isset($_POST["num1"]) ? trim($_POST["num1"]) : "";
    $num2 = isset($_POST["num2"]) ? trim($_POST["num2"]) : "";
    $op = isset($_POST["op"]) ? $_POST["op"] : "";

    // Validation - errors in red
    if ($num1 === "" || !is_numeric($num1)) {
        $errorMessage = "Input 1 is missing or not a valid number";
    } elseif ($num2 === "" || !is_numeric($num2)) {
        $errorMessage = "Input 2 is missing or not a valid number";
    } elseif ($op === "") {
        $errorMessage = "Operator not selected";
    } elseif ($op == "/" && floatval($num2) == 0) {
        $errorMessage = "Division by zero – operation not allowed";
    } else {
        $a = floatval($num1);
        $b = floatval($num2);

        // switch from Class 7
        switch ($op) {
            case "+":
                $answer = $a + $b;
                break;
            case "-":
                $answer = $a - $b;
                break;
            case "*":
                $answer = $a * $b;
                break;
            case "/":
                $answer = $a / $b;
                break;
            default:
                $errorMessage = "Operator not selected";
                $answer = null;
        }

        if ($errorMessage === "") {
            $resultMessage = $num1 . " " . $op . " " . $num2 . " = " . $answer;
            
            $newEntry = "<p>" . $resultMessage . "</p>";
            $history = $history . $newEntry;

            setcookie("history", $history, [
                "expires" => time() + 86400 * 30,
                "path" => "/"
            ]);
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Calculator</title>
</head>
<body>
    <h2>Calculator</h2>
    <form action="" method="post">
        Input 1:
        <input type="text" name="num1"
               value="<?php echo isset($_POST['num1']) ? htmlspecialchars($_POST['num1']) : ''; ?>" />
        <br /><br />

        Input 2:
        <input type="text" name="num2"
               value="<?php echo isset($_POST['num2']) ? htmlspecialchars($_POST['num2']) : ''; ?>" />
        <br /><br />

        Operation:
        <select name="op">
            <option value="">Select</option>
            <option value="+" <?php if (isset($_POST['op']) && $_POST['op'] == '+') echo 'selected'; ?>>+</option>
            <option value="-" <?php if (isset($_POST['op']) && $_POST['op'] == '-') echo 'selected'; ?>>-</option>
            <option value="*" <?php if (isset($_POST['op']) && $_POST['op'] == '*') echo 'selected'; ?>>*</option>
            <option value="/" <?php if (isset($_POST['op']) && $_POST['op'] == '/') echo 'selected'; ?>>/</option>
        </select>
        <br /><br />

        <input type="submit" value="Calculate" />
    </form>

    <br />

    <?php
    if ($errorMessage !== "") {
        echo '<p style="color: red;">' . htmlspecialchars($errorMessage) . '</p>';
    }
    if ($resultMessage !== "") {
        echo '<p style="color: blue;">' . htmlspecialchars($resultMessage) . '</p>';
    }
    ?>

    <h3>History</h3>
    <?php
    if ($history !== "") {
        echo $history;
    } else {
        echo "<p>No calculation history yet.</p>";
    }
    ?>
</body>
</html>