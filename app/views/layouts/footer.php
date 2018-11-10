    <?php
        if(Session::sess('is_login') && Input::get('p') != 'front_end'){
    ?>

            </div>
        </div>
        <!-- main content area end -->
       <!-- footer area start-->
        <footer>
            <div class="footer-area">
                <p>© Copyright <?php echo date('Y') ?> . All right reserved</p>
            </div>
        </footer>
        <!-- footer area end-->
    </div>
    <!-- page container area end -->
    <?php } ?>
    <!-- jquery latest version -->
    <script src="<?php echo base_url('assets/js/vendor/jquery-2.2.4.min.js') ?>"></script>
    <!-- bootstrap 4 js -->
    <script src="<?php echo base_url('assets/js/popper.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/owl.carousel.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/metisMenu.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.slimscroll.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/jquery.slicknav.min.js') ?>"></script>

    <?php if(!empty($js)) echo $js ?>


    <!-- others plugins -->
    <script src="<?php echo base_url('assets/js/plugins.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/scripts.js') ?>"></script>
</body>

</html>
