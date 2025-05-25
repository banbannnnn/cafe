<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect and sanitize input
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $company_name = trim($_POST['company_name']);
    $street = trim($_POST['street']);
    $city = trim($_POST['city']);
    $province = trim($_POST['province']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    
    // You can add validation here (e.g. check email format, required fields, etc.)

    // Update the user data in the database
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, company_name=?, street=?, city=?, province=?, phone=?, email=? WHERE id=?");
    $stmt->bind_param("ssssssssi", $first_name, $last_name, $company_name, $street, $city, $province, $phone, $email, $userId);
    
    if ($stmt->execute()) {
        // Redirect to profile with success message
        header("Location: profile.php?update=success");
        exit();
    } else {
        $error = "Failed to update profile. Please try again.";
    }
}

// Fetch user details to pre-fill the form
$stmt = $conn->prepare("SELECT first_name, last_name, company_name, street, city, province, phone, email FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();
} else {
    echo "User not found.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <title>Edit Profile - Blissful Bites</title>
    <style>
       @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');

body {
    font-family: 'Poppins', sans-serif;
    background: #fff0ee; /* match profile.php background */
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

.edit-container {
    background: #ffffff;
    padding: 40px 50px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(159, 66, 98, 0.15); /* match profile.php shadow */
    width: 520px;
    max-width: 100%;
    text-align: center;
    position: relative;
}

h2 {
    color: #9f4262; /* match profile.php heading color */
    font-weight: 600;
    margin-bottom: 30px;
    font-size: 28px;
}

form label {
    display: block;
    color: #9f4262; /* match profile.php label color */
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 14px;
    text-align: left;
}

form input[type="text"],
form input[type="email"] {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1.8px solid #e2c2c8; /* match profile.php input border */
    background: #fff0ee; /* match profile.php input bg */
    font-size: 15px;
    color: #9f4262; /* match profile.php input text */
    margin-bottom: 18px;
    outline: none;
    transition: border-color 0.3s ease;
}

form input[type="text"]:focus,
form input[type="email"]:focus {
    border-color: #9f4262; /* match profile.php input focus border */
    background: #f7e5e3; /* match profile.php input focus bg */
}

.buttons {
    margin-top: 20px;
}

.buttons button,
.buttons a {
    display: inline-block;
    background: #9f4262; /* match profile.php button bg */
    color: white;
    padding: 12px 35px;
    font-weight: 600;
    border-radius: 30px;
    text-decoration: none;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
    box-shadow: 0 4px 10px rgba(159, 66, 98, 0.4); /* match profile.php button shadow */
    margin: 0 10px;
}

.buttons button:hover,
.buttons a:hover {
    background: #7a3050; /* match profile.php button hover */
    box-shadow: 0 6px 14px rgba(122, 48, 80, 0.6); /* match profile.php button hover shadow */
}

.error {
    color: #a82e5d;
    margin-bottom: 20px;
    font-weight: 600;
}

@media (max-width: 480px) {
    .edit-container {
        padding: 30px 25px;
        width: 100%;
    }
}

    </style>
</head>
<body>
    <div class="edit-container">
        <h2>Edit Your Profile</h2>

        <?php if (!empty($error)): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

            <label for="company_name">Company Name</label>
            <input type="text" id="company_name" name="company_name" value="<?php echo htmlspecialchars($user['company_name']); ?>">

            <label for="street">Street</label>
            <input type="text" id="street" name="street" value="<?php echo htmlspecialchars($user['street']); ?>">

            <label for="city">City</label>
            <input type="text" id="city" name="city" value="<?php echo htmlspecialchars($user['city']); ?>">

            <label for="province">Province</label>
            <input type="text" id="province" name="province" value="<?php echo htmlspecialchars($user['province']); ?>">

            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>">

            <label for="email">Email</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <div class="buttons">
                <button type="submit">Save Changes</button>
                <a href="profile.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>
