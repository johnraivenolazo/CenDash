<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION["adm_id"])) {
  header('location:login.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>User Profile | CenDash</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../src/styles/css/tailwind.css">
  <link href="../src/styles/css/admin.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <style>
    body {
      background: var(--bg-primary);
      color: var(--text-primary);
      padding: 2rem;
      font-family: 'Outfit', sans-serif;
    }

    .profile-card {
      background: var(--bg-secondary);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 2.5rem;
      max-width: 500px;
      margin: 0 auto;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
      text-align: center;
    }

    .avatar-circle {
      width: 80px;
      height: 80px;
      background: rgba(38, 213, 120, 0.1);
      color: var(--color-primary);
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 1.5rem;
      font-size: 2.5rem;
      border: 2px solid var(--color-primary);
    }

    h2 {
      margin-bottom: 2rem;
      font-weight: 700;
      font-size: 1.5rem;
    }

    .info-row {
      display: flex;
      justify-content: space-between;
      padding: 0.75rem 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      text-align: left;
    }

    .info-label {
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    .info-value {
      font-weight: 500;
      color: #fff;
    }

    .badge {
      padding: 4px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }

    .badge-success {
      background: rgba(38, 213, 120, 0.2);
      color: var(--color-primary);
    }

    .badge-danger {
      background: rgba(255, 71, 87, 0.2);
      color: #ff4757;
    }

    .btn-close {
      margin-top: 2.5rem;
      width: 100%;
      padding: 0.75rem;
      background: rgba(255, 255, 255, 0.05);
      border: 1px solid rgba(255, 255, 255, 0.1);
      color: #fff;
      border-radius: 8px;
      cursor: pointer;
      font-weight: 600;
      transition: all 0.3s ease;
    }

    .btn-close:hover {
      background: rgba(255, 255, 255, 0.1);
      transform: translateY(-2px);
    }
  </style>
</head>

<body>
  <div class="profile-card">
    <?php
    $newform_id = $_GET['newform_id'] ?? '';
    $stmt = $db->prepare("SELECT * FROM users_orders WHERE o_id = :o_id");
    $stmt->execute([':o_id' => $newform_id]);
    $ro = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($ro) {
      $stmt2 = $db->prepare("SELECT * FROM users WHERE u_id = :u_id");
      $stmt2->execute([':u_id' => $ro['u_id']]);
      $user = $stmt2->fetch(PDO::FETCH_ASSOC);

      if ($user) {
        ?>
        <div class="avatar-circle">
          <i class="fa fa-user"></i>
        </div>
        <h2><?php echo htmlentities($user['f_name'] . ' ' . $user['l_name']); ?></h2>

        <div class="info-row">
          <span class="info-label">Username</span>
          <span class="info-value"><?php echo htmlentities($user['username']); ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Email Address</span>
          <span class="info-value"><?php echo htmlentities($user['email']); ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Phone Member</span>
          <span class="info-value"><?php echo htmlentities($user['phone']); ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Joined Date</span>
          <span class="info-value"><?php echo htmlentities($user['date']); ?></span>
        </div>
        <div class="info-row">
          <span class="info-label">Current Status</span>
          <span class="info-value">
            <?php if ($user['status'] == 1): ?>
              <span class="badge badge-success">Active Account</span>
            <?php else: ?>
              <span class="badge badge-danger">Blocked</span>
            <?php endif; ?>
          </span>
        </div>

      <?php }
    } else {
      echo "<p>User not found.</p>";
    } ?>

    <button type="button" class="btn-close" onclick="window.close();">
      <i class="fa fa-times"></i> Close Window
    </button>
  </div>
</body>

</html>