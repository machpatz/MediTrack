<?php
session_start();
include("../config/db.php");

$message = "";
$success = "";

if(isset($_POST['register'])){

    $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
    $username  = mysqli_real_escape_string($conn, $_POST['username']);
    $phone     = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender    = mysqli_real_escape_string($conn, $_POST['gender']);
    $age       = intval($_POST['age']);
    $address   = mysqli_real_escape_string($conn, $_POST['address']);

    $password  = mysqli_real_escape_string($conn, $_POST['password']);

    // Check if username exists
    $check = mysqli_query($conn,"SELECT user_id FROM users WHERE username='$username'");

    if(mysqli_num_rows($check) > 0){
        $message = "Username already exists!";
    } else {

        // PATIENT ONLY
        $role = "patient";

        // Insert into USERS
        $insertUser = mysqli_query($conn,"
            INSERT INTO users (full_name, username, password, phone, role)
            VALUES ('$full_name','$username','$password','$phone','$role')
        ");

        if($insertUser){

            $user_id = mysqli_insert_id($conn);

            // Insert into PATIENTS (linked)
            $insertPatient = mysqli_query($conn,"
                INSERT INTO patients
                (user_id, full_name, gender, age, phone, address, date_registered)
                VALUES
                ($user_id,'$full_name','$gender',$age,'$phone','$address',NOW())
            ");

            if($insertPatient){
                $success = "Registration successful! You can now login.";
            } else {
                $message = "Patient profile error: ".mysqli_error($conn);
            }

        } else {
            $message = "User creation failed: ".mysqli_error($conn);
        }
    }
}
?>

<?php include("../includes/header.php"); ?>

<div style="
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background:url('../assets/img/0.jpg') no-repeat center center/cover;
    position:relative;
">

    <!-- Overlay -->
    <div style="
        position:absolute;
        inset:0;
        background:rgba(0,0,0,0.25);
        backdrop-filter:blur(3px);
    "></div>

    <!-- Register Container -->
    <div style="
        position:relative;
        width:95%;
        max-width:900px;
        background:#007bff;
        border-radius:25px;
        padding:60px 50px;
        box-shadow:0 35px 80px rgba(0,0,0,0.3);
        display:flex;
        flex-wrap:wrap;
        color:#fff;
    ">

        <!-- LEFT -->
        <div style="
            flex:1 1 400px;
            padding:20px 40px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        ">
            <h1 style="font-size:42px;margin-bottom:20px;">Patient Registration</h1>
            <p style="font-size:20px;line-height:1.5;">
                Create your MediTrack patient account and manage appointments and records securely.
            </p>
        </div>

        <!-- RIGHT FORM -->
        <div style="flex:1 1 350px;padding:20px 40px;">

            <h2 style="font-size:32px;margin-bottom:20px;text-align:center;">
                Create Account
            </h2>

            <?php
            if(!empty($message)){
                echo "<p style='color:#ffdddd;margin-bottom:20px;font-weight:600;text-align:center;'>$message</p>";
            }

            if(!empty($success)){
                echo "<p style='color:#ddffdd;margin-bottom:20px;font-weight:600;text-align:center;'>$success</p>";
            }
            ?>

            <form method="POST">

                <input type="text" name="full_name" placeholder="Full Name" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">

                <input type="text" name="username" placeholder="Username" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">

                <input type="tel" name="phone" placeholder="Phone" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">

                <select name="gender" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">
                    <option value="">Select Gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <input type="number" name="age" placeholder="Age" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">

                <textarea name="address" placeholder="Address" required style="
                    width:100%;padding:18px;margin-bottom:18px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                "></textarea>

                <input type="password" name="password" placeholder="Password" required style="
                    width:100%;padding:18px;margin-bottom:22px;
                    border-radius:10px;border:1px solid #0056b3;
                    background:#0056b3;color:#fff;
                ">

                <button type="submit" name="register" style="
                    width:100%;padding:18px;
                    background:#0056b3;color:#fff;
                    border:none;border-radius:10px;
                    font-size:18px;font-weight:700;
                    cursor:pointer;
                ">
                    Register
                </button>
            </form>

            <p style="margin-top:20px;text-align:center;">
                Already have an account?
                <a href="login.php" style="color:white;text-decoration:underline;font-weight:700;">
                    Login here
                </a>
            </p>

        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
