<?php
session_start();
include("../config/db.php"); // database connection

$message = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) == 1){
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['role'] = $user['role'];
        $_SESSION['full_name'] = $user['full_name'];

        if($user['role'] == 'admin'){
            header("Location: ../admin/dashboard.php");
        } elseif($user['role'] == 'doctor'){
            header("Location: ../doctor/dashboard.php");
        } elseif($user['role'] == 'receptionist'){
            header("Location: ../receptionist/dashboard.php");
        } else {
            header("Location: ../patient/dashboard.php");
        }
        exit;
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<?php include("../includes/header.php"); ?>

<div style="
    min-height:100vh;
    display:flex;
    align-items:center;
    justify-content:center;
    background: url('../assets/img/0.jpg') no-repeat center center/cover;
    position:relative;
">
    <!-- Soft overlay -->
    <div style="
        position:absolute;
        top:0; left:0; width:100%; height:100%;
        background: rgba(0,0,0,0.25);
        backdrop-filter: blur(3px);
    "></div>

    <!-- Full-width Login Container -->
    <div style="
        position:relative;
        width:95%;
        max-width:900px;
        background: #007bff;  /* Blue background for form */
        border-radius:25px;
        padding:60px 50px;
        box-shadow:0 35px 80px rgba(0,0,0,0.3);
        display:flex;
        flex-wrap:wrap;
        color:#fff;  /* White text */
    ">
        <!-- Left Side: Info / Welcome -->
        <div style="
            flex:1 1 400px;
            padding:20px 40px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        ">
            <h1 style="font-size:42px; margin-bottom:20px;">Welcome to MediTrack</h1>
            <p style="font-size:20px; line-height:1.5;">
                Secure hospital portal login for doctors, staff, and patients. Access your dashboard to manage appointments, medical records, and hospital operations efficiently.
            </p>
        </div>

        <!-- Right Side: Login Form -->
        <div style="
            flex:1 1 350px;
            padding:20px 40px;
        ">
            <h2 style="font-size:32px; margin-bottom:20px; text-align:center;">Login</h2>
            
            <?php if(!empty($message)){ echo "<p style='color:#ffdddd; margin-bottom:20px; font-weight:600; text-align:center;'>$message</p>"; } ?>

            <form method="POST" action="">
                <input type="text" name="username" placeholder="Username" required style="
                    width:100%;
                    padding:18px;
                    margin-bottom:20px;
                    border-radius:10px;
                    border:1px solid #0056b3;
                    font-size:18px;
                    background:#0056b3;
                    color:#fff;
                    transition:0.3s;
                " onfocus="this.style.borderColor='#ffffff';" onblur="this.style.borderColor='#0056b3';">

                <input type="password" name="password" placeholder="Password" required style="
                    width:100%;
                    padding:18px;
                    margin-bottom:25px;
                    border-radius:10px;
                    border:1px solid #0056b3;
                    font-size:18px;
                    background:#0056b3;
                    color:#fff;
                    transition:0.3s;
                " onfocus="this.style.borderColor='#ffffff';" onblur="this.style.borderColor='#0056b3';">

                <button type="submit" name="login" style="
                    width:100%;
                    padding:18px;
                    background:#0056b3;
                    color:#fff;
                    border:none;
                    border-radius:10px;
                    font-size:18px;
                    font-weight:700;
                    cursor:pointer;
                    transition:0.3s;
                " onmouseover="this.style.background='#003d80'; this.style.transform='scale(1.03)';" onmouseout="this.style.background='#0056b3'; this.style.transform='scale(1)';">
                    Login
                </button>
            </form>

            <p style="margin-top:25px; font-size:16px; text-align:center;">
                Forgot your password? 
                <a href="forgot_password.php" style="color:#ffffff; text-decoration:underline;">Click here</a>
            </p>

            <p style="margin-top:10px; font-size:16px; text-align:center;">
                Don’t have an account? 
                <a href="register.php" style="color:#ffffff; text-decoration:underline; font-weight:700;">
                    Register here
                </a>
            </p>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
