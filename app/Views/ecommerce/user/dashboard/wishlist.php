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

    <main class="main-wrapper">

        <!-- Start Wishlist Area  -->
        <div class="axil-wishlist-area axil-section-gap">
            <div class="container">
                <div class="product-table-heading">
                    <h4 class="title">My Wish List on eTrade</h4>
                </div>
                <div class="table-responsive">
                    <table class="table axil-product-table axil-wishlist-table">
                        <thead>
                            <tr>
                                <th scope="col" class="product-remove"></th>
                                <th scope="col" class="product-thumbnail">Product</th>
                                <th scope="col" class="product-title"></th>
                                <th scope="col" class="product-price">Unit Price</th>
                                <th scope="col" class="product-stock-status">Stock Status</th>
                                <th scope="col" class="product-add-cart"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="product-remove"><a href="#" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                                <td class="product-thumbnail"><a href="single-product.html"><img src="<?= base_url('public/user/images/product/electric/product-01.png') ?>" alt="Digital Product"></a></td>
                                <td class="product-title"><a href="single-product.html">Wireless PS Handler</a></td>
                                <td class="product-price" data-title="Price"><span class="currency-symbol">$</span>124.00</td>
                                <td class="product-stock-status" data-title="Status">In Stock</td>
                                <td class="product-add-cart"><a href="cart.html" class="axil-btn btn-outline">Add to Cart</a></td>
                            </tr>
                            <tr>
                                <td class="product-remove"><a href="#" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                                <td class="product-thumbnail"><a href="single-product-2.html"><img src="<?= base_url('public/user/images/product/electric/product-02.png') ?>" alt="Digital Product"></a></td>
                                <td class="product-title"><a href="single-product-2.html">Gradient Light Keyboard</a></td>
                                <td class="product-price" data-title="Price"><span class="currency-symbol">$</span>124.00</td>
                                <td class="product-stock-status" data-title="Status">In Stock</td>
                                <td class="product-add-cart"><a href="cart.html" class="axil-btn btn-outline">Add to Cart</a></td>
                            </tr>
                            <tr>
                                <td class="product-remove"><a href="#" class="remove-wishlist"><i class="fal fa-times"></i></a></td>
                                <td class="product-thumbnail"><a href="single-product-3.html"><img src="<?= base_url('public/user/images/product/electric/product-03.png') ?>" alt="Digital Product"></a></td>
                                <td class="product-title"><a href="single-product-3.html">HD CC Camera</a></td>
                                <td class="product-price" data-title="Price"><span class="currency-symbol">$</span>124.00</td>
                                <td class="product-stock-status" data-title="Status">In Stock</td>
                                <td class="product-add-cart"><a href="cart.html" class="axil-btn btn-outline">Add to Cart</a></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!-- End Wishlist Area  -->
    </main>


    <?= view('ecommerce/user/common/footer') ?>
        <?= view('ecommerce/user/common/view_cart') ?>

    
    <!-- JS
============================================ -->
    <!-- Modernizer JS -->
    <?= view('ecommerce/user/common/foot_script') ?>

</body>


<!-- Mirrored from new.axilthemes.com/demo/template/etrade/wishlist.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 15 Sep 2025 10:47:49 GMT -->
</html>