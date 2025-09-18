<div class="axil-mainmenu">
    <div class="container">
        <div class="header-navbar">
            <div class="header-brand">
                <a href="<?= base_url('user/home')?>" class="logo logo-dark">
                    <img src="<?= base_url('public/user/images/logo/logo.png') ?>" alt="Site Logo">
                </a>
                <a href="<?= base_url('user/home')?>" class="logo logo-light">
                    <img src="<?= base_url('public/user/images/logo/logo-light.png') ?>" alt="Site Logo">
                </a>
            </div>
            <div class="header-main-nav">
                <!-- Start Mainmanu Nav -->
                <nav class="mainmenu-nav">
                    <button class="mobile-close-btn mobile-nav-toggler"><i class="fas fa-times"></i></button>
                    <div class="mobile-nav-brand">
                        <a href="<?= base_url('user/home')?>" class="logo">
                            <img src="<?= base_url('public/user/images/logo/logo.png') ?>" alt="Site Logo">
                        </a>
                    </div>
                    <ul class="mainmenu">
                        <li class="menu-item-has-children">
                            <a href="<?= base_url('user/home')?>">Home</a>
                        </li>
                        <li class="menu-item-has-children">
                            <a href="<?= base_url('user/shop') ?>">Shop</a>
                            
                        </li>
                        
                        <li><a href="<?= base_url('user/about-us') ?>">About</a></li>
                        <li class="menu-item-has-children">
                            <a href="<?= base_url('user/blog') ?>">Blog</a>
                            
                        </li>
                        <li><a href="<?= base_url('user/contact') ?>">Contact</a></li>
                    </ul>
                </nav>
                <!-- End Mainmanu Nav -->
            </div>
            <div class="header-action">
                <ul class="action-list">
                    <li class="axil-search">
                        <a href="javascript:void(0)" class="header-search-icon" title="Search">
                            <i class="flaticon-magnifying-glass"></i>
                        </a>
                    </li>
                    <li class="wishlist">
                        <a href="wishlist.html">
                            <i class="flaticon-heart"></i>
                        </a>
                    </li>
                    <li class="shopping-cart">
                        <a href="#" class="cart-dropdown-btn">
                            <span class="cart-count">3</span>
                            <i class="flaticon-shopping-cart"></i>
                        </a>
                    </li>
                    <li class="my-account">
                        <a href="javascript:void(0)">
                            <i class="flaticon-person"></i>
                        </a>
                        <div class="my-account-dropdown">
                            <span class="title">QUICKLINKS</span>
                            <ul>
                                <li>
                                    <a href="<?= base_url('user/my-account') ?>">My Account</a>
                                </li>
                                <li>
                                    <a href="#">Initiate return</a>
                                </li>
                                <li>
                                    <a href="<?= base_url('user/contact') ?>">Support</a>
                                </li>
                                
                            </ul>
                            <div class="login-btn">
                                <a href="<?= base_url('user/login') ?>" class="axil-btn btn-bg-primary">Login</a>
                            </div>
                            <div class="reg-footer text-center">No account yet? <a href="<?= base_url('user/register') ?>"
                                    class="btn-link">REGISTER HERE.</a></div>
                        </div>
                    </li>
                    <li class="axil-mobile-toggle">
                        <button class="menu-btn mobile-nav-toggler">
                            <i class="flaticon-menu-2"></i>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>