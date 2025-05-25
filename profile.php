<?php
session_start();
include 'connect.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: register.php");
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user details from the database
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
    <title>Your Profile - Blissful Bites</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;600&display=swap');
        
       body {
    font-family: 'Poppins', sans-serif;
    background: #fff0ee; /* changed from #fff0f5 to match orders.php */
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 40px 20px;
}

.profile-container {
    position: relative;
    background: #ffffff;
    padding: 40px 50px;
    border-radius: 20px;
    box-shadow: 0 8px 20px rgba(159, 66, 98, 0.15); /* changed shadow color to match orders.php */
    width: 520px;
    max-width: 100%;
    text-align: center;
}

.close-btn {
    position: absolute;
    top: 20px;
    right: 25px;
    font-size: 28px;
    font-weight: bold;
    color: #9f4262; /* changed from #d24280 */
    text-decoration: none;
    cursor: pointer;
    transition: color 0.3s ease;
}

.close-btn:hover {
    color: #7a3050; /* changed from #a82e5d */
}

h2 {
    color: #9f4262; /* changed from #d24280 */
    font-weight: 600;
    margin-bottom: 30px;
    font-size: 28px;
}

.profile-info label {
    text-align: left;
    display: block;
    color: #9f4262; /* changed from #a83f74 */
    font-weight: 600;
    margin-bottom: 6px;
    font-size: 14px;
}

.profile-info input {
    width: 100%;
    padding: 10px 14px;
    border-radius: 12px;
    border: 1.8px solid #e2c2c8; /* changed from #f1c0d7 */
    background: #fff0ee; /* changed from #fff0f5 */
    font-size: 15px;
    color: #9f4262; /* changed from #5a3a54 */
    margin-bottom: 18px;
    outline: none;
    transition: border-color 0.3s ease;
}

.profile-info input:focus {
    border-color: #9f4262; /* changed from #d24280 */
    background: #f7e5e3; /* changed from #ffe6f1 */
}

.logout a {
    display: inline-block;
    background: #9f4262; /* changed from #d24280 */
    color: white;
    padding: 12px 35px;
    font-weight: 600;
    border-radius: 30px;
    text-decoration: none;
    transition: background 0.3s ease;
    box-shadow: 0 4px 10px rgba(159, 66, 98, 0.4); /* changed shadow */
}

.logout a:hover {
    background: #7a3050; /* changed from #a82e5d */
    box-shadow: 0 6px 14px rgba(122, 48, 80, 0.6); /* changed shadow */
}


        @media (max-width: 480px) {
            .profile-container {
                padding: 30px 25px;
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <a href="home.php" class="close-btn" title="Go to Home">×</a>
        <h2>Welcome, <?php echo htmlspecialchars($user['first_name']); ?>!</h2>
        <div class="profile-info">
            <label>First Name</label>
            <input type="text" value="<?php echo htmlspecialchars($user['first_name']); ?>" readonly>

            <label>Last Name</label>
            <input type="text" value="<?php echo htmlspecialchars($user['last_name']); ?>" readonly>

            <label>Company Name</label>
            <input type="text" value="<?php echo htmlspecialchars($user['company_name']); ?>" readonly>

            <label>Street</label>
            <input type="text" value="<?php echo htmlspecialchars($user['street']); ?>" readonly>

            <label>City</label>
            <input type="text" value="<?php echo htmlspecialchars($user['city']); ?>" readonly>

            <label>Province</label>
            <input type="text" value="<?php echo htmlspecialchars($user['province']); ?>" readonly>

            <label>Phone</label>
            <input type="text" value="<?php echo htmlspecialchars($user['phone']); ?>" readonly>

            <label>Email</label>
            <input type="text" value="<?php echo htmlspecialchars($user['email']); ?>" readonly>
        </div>
        <div class="logout">
            <a href="edit_profile.php">Edit</a>
        </div>
    </div>
</body>
</html>
