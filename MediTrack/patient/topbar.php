<?php
// Make sure session is started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Only patients should include this topbar
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'patient') {
    return; // silently do not display
}
?>

<style>
.topbar {
    width: 100%;
    background: #007bff;
    color: #fff;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 25px;
    border-radius: 0 0 10px 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.topbar .status {
    display: flex;
    align-items: center;
    gap: 10px;
    font-weight: 600;
}

.topbar .status .online-dot {
    width: 12px;
    height: 12px;
    background: #27ae60;
    border-radius: 50%;
    animation: pulse 1.5s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); opacity: 1; }
    50% { transform: scale(1.4); opacity: 0.6; }
    100% { transform: scale(1); opacity: 1; }
}

.topbar .logout-btn {
    background: #ffffff;
    color: #007bff;
    border: none;
    padding: 8px 15px;
    border-radius: 6px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
    text-decoration: none;
}

.topbar .logout-btn:hover {
    background: #0056b3;
    color: #fff;
    transform: scale(1.05);
}
</style>

<div class="topbar">
    <div class="status">
        <div class="online-dot"></div>
        Online as <?php echo $_SESSION['full_name']; ?>
    </div>
    <a href="../auth/logout.php" class="logout-btn">Logout</a>
</div>
