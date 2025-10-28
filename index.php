<?php
session_start();
require_once 'config.php';

$errors = [
    'login'=> $_SESSION['login_error'] ?? '',
    'register'=> $_SESSION['register_error'] ?? ''
];
$activeForm = $_SESSION['active_form'] ?? 'login';
session_unset();

function showError($error){ return !empty($error) ? "<p class='error-message'>$error</p>":''; }
function isActiveForm($form,$active){ return $form==$active ? 'active':'form-box'; }

$users = $conn->query("SELECT * FROM users ORDER BY id DESC")->fetch_all(MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login/Register & Users</title>
<link rel="stylesheet" href="style.css">
<script src="script.js" defer></script>
</head>
<body>

<div class="container">

  <!-- LOGIN FORM -->
  <div class="form-box <?= isActiveForm('login',$activeForm); ?>" id="login-form">
    <form action="login_register.php" method="post">
      <h2>Login</h2>
      <?= showError($errors['login']); ?>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit" name="login">Login</button>
      <p>Don't have an account? <a href="#" onclick="showForm('register-form')">Register</a></p>
    </form>
  </div>

  <!-- REGISTER FORM -->
  <div class="form-box <?= isActiveForm('register',$activeForm); ?>" id="register-form">
    <form action="login_register.php" method="post">
      <h2>Register</h2>
      <?= showError($errors['register']); ?>
      <input type="text" name="name" placeholder="Name" required>
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <select name="role" required>
        <option value="">Select Role</option>
        <option value="user">User</option>
        <option value="admin">Admin</option>
      </select>
      <button type="submit" name="register">Register</button>
      <p>Already have an account? <a href="#" onclick="showForm('login-form')">Login</a></p>
    </form>
  </div>

<!-- USERS LIST -->
<div class="form-box active">
  <h2>Users List</h2>
  <ul class="box">
    <?php foreach($users as $user): ?>
    <li>
      <p><?= htmlspecialchars($user['name']) ?> (<?= htmlspecialchars($user['role']) ?>) - <?= htmlspecialchars($user['email']) ?></p>
      <div style="display: flex; gap: 10px;">
        <button onclick="openEditModal(<?= $user['id'] ?>,'<?= $user['name'] ?>','<?= $user['email'] ?>','<?= $user['role'] ?>')">Edit</button>
        <button onclick="openDeleteModal(<?= $user['id'] ?>)">Delete</button>
      </div>
    </li>
    <?php endforeach; ?>
  </ul>
</div>


<!-- EDIT MODAL -->
<div class="form-box" id="editModal">
  <form action="edit_user.php" method="post">
    <h2>Edit User</h2>
    <input type="hidden" name="id" id="edit-id">
    <input type="text" name="name" id="edit-name" placeholder="Name" required>
    <input type="email" name="email" id="edit-email" placeholder="Email" required>
    <select name="role" id="edit-role" required>
      <option value="user">User</option>
      <option value="admin">Admin</option>
    </select>
    <button type="submit">Save</button>
    <button type="button" onclick="closeModal('editModal')">Cancel</button>
  </form>
</div>

<!-- DELETE MODAL -->
<div class="form-box" id="deleteModal">
  <form action="delete_user.php" method="post">
    <h2>Confirm Delete</h2>
    <p>Are you sure?</p>
    <input type="hidden" name="id" id="delete-id">
    <button type="submit">Delete</button>
    <button type="button" onclick="closeModal('deleteModal')">Cancel</button>
  </form>
</div>

</body>
</html>
