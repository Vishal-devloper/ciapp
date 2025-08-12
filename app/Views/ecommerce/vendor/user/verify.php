<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Vendor Verify</title>
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <div class="wrapper">
    <form id="loginForm" action="<?php echo site_url('public/vendor/User/ajaxVerify') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Vendor Register</h2>
        <div class="input-field padding-bottom">
        <input type="text" name="email" required>
        <label>Enter verification Code</label>
      </div>
      
      <button type="submit">verify</button>
      <div class="register">
        <p>Don't get verification code? <a href="<?php echo base_url('public/vendor/register') ?>">resend code</a></p>
      </div>
    </form>
  </div>
  <script>
    const ajaxRequestUrlLogin ="<?= site_url('public/vendor/User/ajaxVerify') ?>";
  </script>
  <script src="<?= base_url('public/vendor/js/validation.js') ?>"></script>
</body>
</html>