<?php
session_start();
include("../config/db.php");

/* Restrict access to receptionist only */
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'receptionist') {
    header("Location: ../auth/login.php");
    exit;
}

/* Handle form submission */
if (isset($_POST['register'])) {
    $full_name = $_POST['full_name'];
    $gender = $_POST['gender'];
    $age = $_POST['age'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $sql = "INSERT INTO patients (full_name, gender, age, phone, address, date_registered)
            VALUES ('$full_name', '$gender', '$age', '$phone', '$address', CURDATE())";

    if (mysqli_query($conn, $sql)) {
        $success = "Patient registered successfully.";
    } else {
        $error = "Error registering patient.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Patient | MediTrack HMS</title>

    <style>
        body {
            margin: 0;
            font-family: "Segoe UI", Arial, sans-serif;
            background: url("../assets/img/111.jpg") no-repeat center center fixed;
            background-size: cover;
        }

        .overlay {
            min-height: 100vh;
            background: rgba(255,255,255,0.92);
        }

        .container {
            width: 95%;
            max-width: 900px;
            margin: auto;
            padding: 40px 0;
        }

        h1 {
            color: #0056b3;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;
            margin-bottom: 25px;
        }

        .card {
            background: #ffffff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.12);
        }

        label {
            font-weight: 600;
            display: block;
            margin-top: 15px;
            color: #333;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            margin-top: 5px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 15px;
        }

        textarea {
            resize: none;
        }

        .btn {
            margin-top: 25px;
            background: #007bff;
            color: #fff;
            border: none;
            padding: 14px;
            font-size: 16px;
            border-radius: 10px;
            cursor: pointer;
            width: 100%;
            font-weight: bold;
        }

        .btn:hover {
            background: #0056b3;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
            color: #007bff;
            font-weight: 600;
        }

        .success {
            background: #d4edda;
            color: #155724;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>
<div class="overlay">

    <!-- TOP BAR -->
    <?php include("topbar.php"); ?>

    <div class="container">

        <h1>Register New Patient</h1>
        <p class="subtitle">Front Desk Patient Registration</p>

        <div class="card">

            <?php if (isset($success)) echo "<div class='success'>$success</div>"; ?>
            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>

            <form method="POST">

                <label>Full Name</label>
                <input type="text" name="full_name" required>

                <label>Gender</label>
                <select name="gender" required>
                    <option value="">-- Select Gender --</option>
                    <option>Male</option>
                    <option>Female</option>
                </select>

                <label>Age</label>
                <input type="number" name="age" required>

                <label>Phone Number</label>
                <input type="text" name="phone" required>

                <label>Address</label>
                <textarea name="address" rows="3" required></textarea>

                <button type="submit" name="register" class="btn">
                    Register Patient
                </button>
            </form>

            <a href="dashboard.php" class="back-link">← Back to Receptionist Dashboard</a>
        </div>

    </div>
</div>
</body>
</html>
