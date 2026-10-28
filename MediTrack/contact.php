<?php
include("config/db.php");

// Optional: handle form submission
$success_msg = "";
$error_msg = "";

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if(!empty($name) && !empty($email) && !empty($message)){
        $query = "
            INSERT INTO contact_messages 
            (name,email,message,date_sent) 
            VALUES ('$name','$email','$message',CURDATE())
        ";

        if(mysqli_query($conn,$query)){
            $success_msg = "Your message has been sent successfully. We will get back to you soon!";
        } else {
            $error_msg = "Failed to send message. Please try again later.";
        }
    } else {
        $error_msg = "All fields are required!";
    }
}

// Ensure the contact_messages table exists
mysqli_query($conn,"
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100),
    message TEXT,
    date_sent DATE
)
");
?>

<?php include("includes/header.php"); ?>

<!-- Hero Section -->
<div class="hero" style="
    width:100%;
    min-height:600px;
    display:flex;
    align-items:center;
    justify-content:center;
    background: url('assets/img/4.jpg') no-repeat center center/cover;
    position:relative;
">
    <div style="
        position:absolute;
        top:0; left:0; width:100%; height:100%;
        background: rgba(0,0,0,0.55);
    "></div>
    <div style="position:relative; color:#fff; text-align:center; max-width:900px; padding:0 20px;">
        <h1 style="font-size:50px; font-weight:700; margin-bottom:20px;">Contact MediTrack Hospital</h1>
        <p style="font-size:20px; line-height:1.6; margin-bottom:30px;">
            We are here to assist you. Reach out to us with any inquiries, appointments, or feedback. 
            Our team will respond promptly to ensure you get the help you need.
        </p>
    </div>
</div>

<!-- Contact Form & Info -->
<section style="max-width:1100px; margin:80px auto; padding:0 20px; display:flex; flex-wrap:wrap; gap:40px; justify-content:center;">
    <!-- Form -->
    <div style="flex:1 1 450px; background:#f9f9f9; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="color:#007bff; font-size:36px; margin-bottom:30px; text-align:center;">Send Us a Message</h2>

        <?php if($success_msg) { echo "<p style='color:green;text-align:center;margin-bottom:15px;'>$success_msg</p>"; } ?>
        <?php if($error_msg) { echo "<p style='color:red;text-align:center;margin-bottom:15px;'>$error_msg</p>"; } ?>

        <form method="POST">
            <label for="name">Full Name</label>
            <input type="text" name="name" id="name" placeholder="Your Full Name"
                   style="width:100%; padding:12px; margin:10px 0 20px 0; border-radius:5px; border:1px solid #ccc;" required>

            <label for="email">Email Address</label>
            <input type="email" name="email" id="email" placeholder="Your Email"
                   style="width:100%; padding:12px; margin:10px 0 20px 0; border-radius:5px; border:1px solid #ccc;" required>

            <label for="message">Message</label>
            <textarea name="message" id="message" rows="6" placeholder="Your Message"
                      style="width:100%; padding:12px; margin:10px 0 20px 0; border-radius:5px; border:1px solid #ccc;" required></textarea>

            <button type="submit" name="submit" style="
                width:100%;
                padding:15px;
                background:#007bff;
                color:#fff;
                font-weight:700;
                border:none;
                border-radius:8px;
                cursor:pointer;
                transition:0.3s;
            " onmouseover="this.style.background='#0056b3'" 
              onmouseout="this.style.background='#007bff'">
                Send Message
            </button>
        </form>
    </div>

    <!-- Contact Info -->
    <div style="flex:1 1 350px; background:#f4f9ff; padding:30px; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1);">
        <h2 style="color:#007bff; font-size:36px; margin-bottom:30px; text-align:center;">Contact Information</h2>

        <p style="font-size:18px; color:#555; line-height:1.8;">
            <strong>Phone:</strong> 
            <a href="auth/login.php" style="color:#007bff;">079-483-9492</a>
        </p>

        <p style="font-size:18px; color:#555; line-height:1.8;">
            <strong>Email:</strong> 
            <a href="auth/login.php" style="color:#007bff;">info@meditrack.com</a>
        </p>

        <p style="font-size:18px; color:#555; line-height:1.8;">
            <strong>Address:</strong> 
            <a href="auth/login.php" style="color:#007bff;">123 Health Avenue, Nairobi, Kenya</a>
        </p>

        <h3 style="color:#007bff; font-size:24px; margin-top:40px; margin-bottom:20px;">Follow Us</h3>
        <p>
            <a href="auth/login.php" style="color:#007bff; margin-right:15px;">Facebook</a>
            <a href="auth/login.php" style="color:#007bff; margin-right:15px;">Twitter</a>
            <a href="auth/login.php" style="color:#007bff;">LinkedIn</a>
        </p>
    </div>
</section>

<?php include("includes/footer.php"); ?>
