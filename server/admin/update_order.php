<?php
include("../src/scripts/db/connect.php");

if (empty($_SESSION["adm_id"])) {
  header('location:login.php');
  exit;
}

if (isset($_POST['update'])) {
  $form_id = $_GET['form_id'];
  $status = $_POST['status'];
  $remark = $_POST['remark'];

  $remarkStmt = $db->prepare("INSERT INTO remark(frm_id, status, remark) VALUES(:frm_id, :status, :remark)");
  $remarkStmt->execute([
    ':frm_id' => $form_id,
    ':status' => $status,
    ':remark' => $remark
  ]);

  $orderStmt = $db->prepare("UPDATE users_orders SET status = :status, vendor_remark = :remark WHERE o_id = :o_id");
  $orderStmt->execute([
    ':status' => $status,
    ':remark' => $remark,
    ':o_id' => $form_id
  ]);

  echo "<script>alert('Form Details Updated Successfully');</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title>Order Update | CenDash</title>
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

    .update-card {
      background: var(--bg-secondary);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 12px;
      padding: 2rem;
      max-width: 600px;
      margin: 0 auto;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
    }

    h2 {
      color: var(--color-primary);
      margin-bottom: 1.5rem;
      font-weight: 700;
      text-align: center;
    }

    .form-group {
      margin-bottom: 1.5rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: var(--text-muted);
      font-size: 0.9rem;
    }

    .form-control {
      background: rgba(255, 255, 255, 0.05) !important;
      border: 1px solid rgba(255, 255, 255, 0.1) !important;
      color: #fff !important;
      border-radius: 8px !important;
      padding: 0.75rem !important;
    }

    .form-control:focus {
      border-color: var(--color-primary) !important;
      box-shadow: 0 0 0 2px rgba(38, 213, 120, 0.2) !important;
    }

    .btn-group {
      display: flex;
      gap: 1rem;
      margin-top: 2rem;
    }

    .btn {
      flex: 1;
      padding: 0.75rem;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .btn-primary {
      background: var(--color-primary);
      border: none;
      color: #000;
    }

    .btn-primary:hover {
      background: var(--color-primary-hover);
      transform: translateY(-2px);
    }

    .btn-danger {
      background: #ff4757;
      border: none;
      color: #fff;
    }

    .btn-danger:hover {
      background: #ff6b81;
      transform: translateY(-2px);
    }
  </style>
</head>

<body>
  <div class="update-card">
    <h2><i class="fa fa-refresh"></i> Update Order Status</h2>
    <form name="updateticket" id="updatecomplaint" method="post">
      <div class="form-group">
        <label>Order Number</label>
        <div class="form-control"
          style="background: rgba(255,255,255,0.02) !important; border-style: dashed !important;">
          #<?php echo htmlentities($_GET['form_id']); ?>
        </div>
      </div>

      <div class="form-group">
        <label>Status</label>
        <select name="status" required="required" class="form-control">
          <option value="">Select Status</option>
          <option value="in process">On the way</option>
          <option value="closed">Delivered</option>
          <option value="rejected">Cancelled</option>
        </select>
      </div>

      <div class="form-group">
        <label>Message / Remark</label>
        <textarea name="remark" cols="50" rows="5" required="required" class="form-control"
          placeholder="Enter update details..."></textarea>
      </div>

      <div class="btn-group">
        <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check"></i> Update Order</button>
        <button type="button" class="btn btn-danger" onclick="window.close();"><i class="fa fa-times"></i>
          Close</button>
      </div>
    </form>
  </div>
</body>

</html>