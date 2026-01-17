<?php
include("src/scripts/db/connect.php");

if (empty($_SESSION['user_id'])) {
	header('location:login.php');
}
if (isset($_GET['order_del'])) {
	$stmt = $db->prepare("DELETE FROM users_orders WHERE o_id = :o_id");
	$stmt->execute([':o_id' => intval($_GET['order_del'])]);
	header("location:orders.php");
	exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="icon" href="/assets/images/logo.png">
	<title>CenDash | My Orders</title>
	<link rel="stylesheet" href="src/styles/css/loader.css">
	<link rel="stylesheet" href="src/styles/css/navbar.css">
	<link rel="stylesheet" href="src/styles/css/main.css">
	<link rel="stylesheet" href="src/styles/css/footer.css">
	<link rel="stylesheet" href="src/styles/css/tailwind.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		crossorigin="anonymous">
</head>

<body>
	<div class="loader">
		<h1 class="loader-title">Now Loading...</h1>
		<div class="cooking">
			<div class="bubble"></div>
			<div class="bubble"></div>
			<div class="bubble"></div>
			<div class="bubble"></div>
			<div class="bubble"></div>
			<div id=area>
				<div id="sides">
					<div id="pan"></div>
					<div id="handle"></div>
				</div>
				<div id="pancake">
					<div id="pastry"></div>
				</div>
			</div>
		</div>
	</div>

	<?php include("src/includes/navbar.php"); ?>

	<div class="page-wrapper" style="min-height: 80vh;">
		<div class="container" style="padding-top: 2rem; padding-bottom: 4rem;">
			<div class="section-header">
				<h2>My Orders</h2>
				<p>Track your past and current orders.</p>
			</div>

			<div class="table-responsive">
				<table class="modern-table">
					<thead>
						<tr>
							<th>Order Details</th>
							<th class="text-center">Qty</th>
							<th>Price</th>
							<th>Status</th>
							<th>Ordered On</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php
						// Join with foods table to get the image
						$stmt = $db->prepare("
							SELECT users_orders.*, foods.img 
							FROM users_orders 
							LEFT JOIN foods ON users_orders.title = foods.title 
							WHERE u_id = :u_id 
							ORDER BY users_orders.date DESC
						");
						$stmt->execute([':u_id' => $_SESSION['user_id']]);
						$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

						if (count($orders) == 0) {
							echo '<tr><td colspan="6" class="text-center no-orders">No orders found.</td></tr>';
						} else {
							foreach ($orders as $row) {
								?>
								<tr>
									<td>
										<div class="item-with-image">
											<div class="item-img">
												<?php $image = !empty($row['img']) ? $row['img'] : 'default-food.png'; ?>
												<img src="/assets/vendorassets/foods/<?php echo $image; ?>" alt="Food">
											</div>
											<div class="item-details">
												<span class="item-name"><?php echo $row['title']; ?></span>
												<?php if (!empty($row['vendor_remark'])): ?>
													<span class="vendor-remark">
														<i class="fa-solid fa-message"></i> <?php echo $row['vendor_remark']; ?>
													</span>
												<?php endif; ?>
											</div>
										</div>
									</td>
									<td class="text-center qty-cell"><?php echo $row['quantity']; ?></td>
									<td class="price">₱<?php echo number_format($row['price'], 2); ?></td>
									<td>
										<?php
										$status = $row['status'];
										$statusClass = 'pending';
										$statusText = 'Pending';
										$icon = 'clock';

										if ($status == 'in process') {
											$statusClass = 'process';
											$statusText = 'Preparing';
											$icon = 'fire-burner';
										} elseif ($status == 'closed') {
											$statusClass = 'closed';
											$statusText = 'Delivered';
											$icon = 'check-circle';
										} elseif ($status == 'rejected') {
											$statusClass = 'rejected';
											$statusText = 'Cancelled';
											$icon = 'circle-xmark';
										}
										?>
										<span class="status-badge <?php echo $statusClass; ?>">
											<i class="fa-solid fa-<?php echo $icon; ?>"></i>
											<?php echo $statusText; ?>
										</span>
									</td>
									<td class="date-cell">
										<?php
										$date = new DateTime($row['date']);
										echo $date->format('M d, Y') . '<br><span class="time">' . $date->format('h:i A') . '</span>';
										?>
									</td>
									<td>
										<?php if ($status == '' || $status == 'NULL' || $status == 'pending'): ?>
											<a href="orders.php?order_del=<?php echo $row['o_id']; ?>"
												onclick="return confirm('Are you sure you want to cancel this order?');"
												class="btn-icon-delete" title="Cancel Order">
												<i class="fa-solid fa-trash-can"></i>
											</a>
										<?php endif; ?>
									</td>
								</tr>
							<?php }
						} ?>
					</tbody>
				</table>
			</div>
		</div>

		<footer>
			<div class="footer-container">
				<div class="footer-cta">
					<h3>Join Us</h3>
					<p>Join other vendors who benefit from having partnered with us.</p>
				</div>
				<div class="footer-copyright">
					<p><a href="../"><b>&copy; 2026</b>, <b>CenDash</b>.</a> All rights reserved.</p>
				</div>
			</div>
		</footer>
	</div>
	<script src="src/scripts/userAction/userAction.js"></script>
	<script src="src/scripts/main.js"></script>
</body>

</html>