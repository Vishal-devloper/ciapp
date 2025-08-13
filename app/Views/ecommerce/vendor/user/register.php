<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>vendor Register</title>
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
  <div class="wrapper">
    <form  id="registerForm" action="<?= site_url('vendor/UserVendor/ajaxRegister') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Vendor Register</h2>
      <div class="input-field">
        <input type="text" name="username" required>
        <label>Enter your name</label>
      </div>
        <div class="input-field">
        <input type="email" name="email" required>
        <label>Enter your email</label>
      </div>
      <div class="input-field">
        <input type="text" name="phone" required class="phone">
        <label>Phone</label>
      </div>
      <div class="input-field">
        <input type="text" name="store_name" required class="store_name">
        <label>Store Name</label>
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
        <p>Already have an account? <a href="<?php echo base_url('public/vendor/login') ?>">Login</a></p>
      </div>
    </form>
  </div>
  <script>
    const ajaxRequestUrl ="<?= site_url('public/vendor/UserVendor/ajaxRegister') ?>";
  </script>
  <script src="<?= base_url('public/vendor/js/register.js') ?>"></script>
  <script src="<?= base_url('public/vendor/js/validation.js') ?>"></script>
</body>
</html>