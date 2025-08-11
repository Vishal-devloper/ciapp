<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Register</title>
  <link rel="stylesheet" href="<?php echo base_url('public/admin/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="wrapper">
    <form  id="registerForm" action="<?= site_url('admin/User/ajaxRegister') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" name="username" required>
        <label>Enter your name</label>
      </div>
        <div class="input-field">
        <input type="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="password" required class="signupPassword" autocomplete="">
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="password" name="signupConfirm" required class="signupConfirm" autocomplete="">
        <label>Confirm password</label>
      </div>
    
      <div style="margin-top:15px;">
      </div>
      <button type="submit">Register</button>
      <div class="register">
        <p>Already have an account? <a href="<?php echo base_url('public/admin/login') ?>">Login</a></p>
      </div>
    </form>
  </div>
  <script>
    const ajaxRequestUrl ="<?= site_url('public/admin/User/ajaxRegister') ?>";
  </script>
  <script src="<?= base_url('public/admin/js/register.js') ?>"></script>
  <script src="<?= base_url('public/admin/js/validation.js') ?>"></script>
</body>
</html>