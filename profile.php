<?php
include 'header.php';
include 'config/db.php';

if (!isset($_SESSION['uid'])) {
    header("Location: login.php");
    exit;
}

$id = (int)$_SESSION['uid'];
$user = $conn->query("SELECT * FROM users WHERE id=$id")->fetch_assoc();
?>

<div class="container">
  <h2 style="margin-top:30px">👤 My Profile</h2>

  <div class="card" style="max-width:600px;margin:30px auto;">

    <!-- AVATAR -->
    <div style="text-align:center;margin-bottom:20px">
      <?php if (!empty($user['profile_img'])): ?>
        <img 
          src="uploads/profiles/<?= $user['profile_img'] ?>" 
          style="width:100px;height:100px;border-radius:50%;object-fit:cover"
        >
      <?php else: ?>
        <div class="avatar" style="width:100px;height:100px;font-size:36px;margin:auto">
          <?= strtoupper($user['name'][0]) ?>
        </div>
      <?php endif; ?>
    </div>

    <!-- USER DETAILS -->
    <table width="100%" cellpadding="10">
      <tr>
        <td><b>Name</b></td>
        <td><?= $user['name'] ?></td>
      </tr>
      <tr>
        <td><b>Email</b></td>
        <td><?= $user['email'] ?></td>
      </tr>
      <tr>
        <td><b>Age</b></td>
        <td><?= $user['age'] ?></td>
      </tr>
      <tr>
        <td><b>Gender</b></td>
        <td><?= $user['gender'] ?></td>
      </tr>
      <tr>
        <td><b>Role</b></td>
        <td><?= $user['role'] ?></td>
      </tr>
      <a href="orders.php">My Orders</a>

    </table>
<a href="orders.php"><button class="btn">Manage Orders</button></a>

    <!-- ACTIONS -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-top:20px">

  <!-- ADMIN DASHBOARD BUTTON -->
  <?php if ($_SESSION['role'] === 'ADMIN'): ?>
    <a href="admin/dashboard.php">
      <button class="btn">🛠 Admin Dashboard</button>
    </a>
  <?php endif; ?>

  <!-- LOGOUT -->
  <a href="logout.php">
    <button class="btn" style="background:red">Logout</button>
  </a>

</div>


  </div>
</div>

<?php include 'footer.php'; ?>
