<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Register</title>
  <link rel="stylesheet" href="<?php echo base_url('public/admin/css/user.css') ?>">
</head>
<body>
  <div class="wrapper">
    <form action="<?php echo base_url('admin/register') ?>" method="post">
      <h2>Register</h2>
      <div class="input-field">
        <input type="text" name="signup_name" required>
        <label>Enter your name</label>
      </div>
        <div class="input-field">
        <input type="email" name="signup_email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="password" name="signup_password" required class="signup_password">
        <label>Enter your password</label>
      </div>
      <div class="input-field">
        <input type="password" name="signup_confirm" required class="signup_confirm">
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
  <script src="<?= base_url('public/admin/js/register.js') ?>"></script>
</body>
</html>