<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <link rel="stylesheet" href="<?php echo base_url('public/admin/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <div class="wrapper">
    <form id="newPassword" action="<?php echo site_url('admin/User/newPassword') ?>" method="post">
      <?= csrf_field() ?>
      <h2>New Password</h2>
        
      <div class="input-field">
        <input type="password" name="password" class="password" required>
        <label>Enter New password</label>
      </div>
      <div class="input-field">
        <input type="password" name="confirmPassword" class="confirmPassword" required>
        <label>Confirm password</label>
      </div>
      
      <button type="submit">Change Password</button>
      
    </form>
  </div>
  <script>
    const newPassword ="<?= site_url('admin/User/newPassword') ?>";
  </script>
  <script src="<?= base_url('public/admin/js/validation.js') ?>"></script>
</body>
</html>