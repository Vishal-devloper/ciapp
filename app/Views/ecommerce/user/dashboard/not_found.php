<!doctype html>
<html class="no-js" lang="en">


<?= view('ecommerce/user/common/head') ?>


<body class="sticky-header">
    
    <a href="#top" class="back-to-top" id="backto-top"><i class="fal fa-arrow-up"></i></a>
    
    <!-- Start Header -->
    <header class="header axil-header header-style-5">
        
        <?= view('ecommerce/user/common/nav') ?>
        
    </header>
    <!-- End Header -->

    <section class="error-page onepage-screen-area">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="content" data-sal="slide-up" data-sal-duration="800" data-sal-delay="400">
                        <span class="title-highlighter highlighter-secondary"> <i class="fal fa-exclamation-circle"></i> Oops! Somthing's missing.</span>
                        <h1 class="title">Page not found</h1>
                        <p>It seems like we dont find what you searched. The page you were looking for doesn't exist, isn't available loading incorrectly.</p>
                        <a href="<?= base_url('user/home')?>" class="axil-btn btn-bg-secondary right-icon">Back To Home <i class="fal fa-long-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="thumbnail" data-sal="zoom-in" data-sal-duration="800" data-sal-delay="400">
                        <img src="<?= base_url('public/user/images/others/404.png') ?>" alt="404">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?= view('ecommerce/user/common/footer') ?>
        <?= view('ecommerce/user/common/view_cart') ?>

    
    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <?= view('ecommerce/user/common/foot_script') ?>

</body>


<!-- Mirrored from new.axilthemes.com/demo/template/etrade/404.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Sep 2025 10:47:51 GMT -->
</html>