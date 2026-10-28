<?php
session_start();
include("../config/db.php");

$msg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];

    // Check if user exists
    $res = mysqli_query($conn, "SELECT * FROM users WHERE username='$username'");
    if(mysqli_num_rows($res) > 0){
        $user = mysqli_fetch_assoc($res);
        $msg = "Your current password is: <strong>" . htmlspecialchars($user['password']) . "</strong>";
    } else {
        $msg = "Username not found!";
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

    <!-- Full-width Container -->
    <div style="
        position:relative;
        width:95%;
        max-width:900px;
        background: #007bff;
        border-radius:25px;
        padding:60px 50px;
        box-shadow:0 35px 80px rgba(0,0,0,0.3);
        display:flex;
        flex-wrap:wrap;
        color:#fff;
    ">
        <!-- Left Side: Info / Welcome -->
        <div style="
            flex:1 1 400px;
            padding:20px 40px;
            display:flex;
            flex-direction:column;
            justify-content:center;
        ">
            <h1 style="font-size:42px; margin-bottom:20px;">Forgot Your Password?</h1>
            <p style="font-size:20px; line-height:1.5;">
                Enter your username on the right and we will show your password. This works offline for testing purposes. 
                You can then log in and change your password later if needed.
            </p>
        </div>

        <!-- Right Side: Form -->
        <div style="
            flex:1 1 350px;
            padding:20px 40px;
        ">
            <h2 style="font-size:32px; margin-bottom:20px; text-align:center;">Retrieve Password</h2>

            <?php if(!empty($msg)){ echo "<p style='color:#ffdddd; margin-bottom:20px; font-weight:600; text-align:center;'>$msg</p>"; } ?>

            <form method="POST" action="">
                <input type="text" name="username" placeholder="Enter your username" required style="
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

                <button type="submit" style="
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
                    Get Password
                </button>
            </form>

            <p style="margin-top:25px; font-size:16px; text-align:center;">
                Remembered your password? <a href="login.php" style="color:#ffffff; text-decoration:underline;">Back to Login</a>
            </p>
        </div>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
