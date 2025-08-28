<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Forgot Password</title>
  <link rel="stylesheet" href="<?php echo base_url('public/vendor/css/user.css') ?>">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  
</head>
<body>
  <div class="wrapper">
    <form id="forgotPassword" action="<?php echo site_url('vendor/User/forgotPassword') ?>" method="post">
      <?= csrf_field() ?>
      <h2>Forgot Password</h2>
        <div class="input-field padding-bottom">
        <input type="email" name="email" id="email" required>
        <label>Enter Email</label>
      </div>
      
      <button type="submit">Get Code</button>
      
    </form>
  </div>
  <script>
    const ajaxRequestUrlForgotPassword ="<?= site_url('vendor/User/forgotPassword') ?>";
    
  </script>
  <script src="<?= base_url('public/vendor/js/validation.js') ?>"></script>
</body>
</html>