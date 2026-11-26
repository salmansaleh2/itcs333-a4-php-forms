<?php
declare(strict_types=1);

require_once __DIR__ . '/../src/validate.php';

$name = "";
$email = "";
$message = "";
$errors = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if (isset($_POST["name"])) {
        $name = trim($_POST["name"]);
    }
    if (isset($_POST["email"])) {
        $email = trim($_POST["email"]);
    }
    if (isset($_POST["message"])) {
        $message = trim($_POST["message"]);
    }

    if (!validate_required($name)) {
        $errors["name"] = "Name is required.";
    } else if (!validate_length($name, 2, 60)) {
        $errors["name"] = "Name must be between 2 and 60 characters.";
    }

    if (!validate_required($email)) {
        $errors["email"] = "Email is required.";
    } else if (!validate_email($email)) {
        $errors["email"] = "Email is invalid.";
    }

    if (!validate_required($message)) {
        $errors["message"] = "Message is required.";
    } else if (!validate_length($message, 10, 1000)) {
        $errors["message"] = "Message must be between 10 and 1000 characters.";
    }

    if (count($errors) == 0) {
        header("Location: success.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Contact Us</title>
</head>
<body>
  <h1>Contact Us</h1>
  <form method="post" action="index.php">
    <p>
      <label>Name
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>">
      </label>
      <?php if (isset($errors["name"])) { ?>
        <span class="error"><?php echo htmlspecialchars($errors["name"]); ?></span>
      <?php } ?>
    </p>
    <p>
      <label>Email
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>">
      </label>
      <?php if (isset($errors["email"])) { ?>
        <span class="error"><?php echo htmlspecialchars($errors["email"]); ?></span>
      <?php } ?>
    </p>
    <p>
      <label>Message
        <textarea name="message"><?php echo htmlspecialchars($message); ?></textarea>
      </label>
      <?php if (isset($errors["message"])) { ?>
        <span class="error"><?php echo htmlspecialchars($errors["message"]); ?></span>
      <?php } ?>
    </p>
    <button type="submit">Send</button>
  </form>
</body>
</html>