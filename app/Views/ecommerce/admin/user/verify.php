<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Verify</title>
  <link rel="stylesheet" href="<?php echo base_url('public/admin/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <div class="wrapper">
    <form id="RegisterVerifyForm" action="<?php echo site_url('public/admin/User/ajaxCodeVerify') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Admin Register</h2>
        <div class="input-field padding-bottom">
        <input type="text" name="code" id="code" required>
        <label>Enter verification Code</label>
      </div>
      
      <button type="submit">verify</button>
      <div class="register">
        <p >Don't get verification code? <a href="#" class="resend">resend code</a><br><span id="timer"></span></p>
      </div>
    </form>
  </div>
  <script>
    const ajaxRequestUrlRegisterVerify ="<?= site_url('public/admin/User/ajaxCodeVerify') ?>";
    const ajaxRequestUrlRegisterVerifyResend ="<?= site_url('public/admin/User/ajaxCodeVerifyResend') ?>";
  </script>
  <script src="<?= base_url('public/admin/js/validation.js') ?>"></script>
</body>
</html>