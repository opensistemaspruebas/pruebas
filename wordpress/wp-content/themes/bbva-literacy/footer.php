        <?php $url_youtube = get_option('youtube-url'); ?>
        <?php $url_twitter = get_option('twitter-url'); ?>
        <?php $url_facebook = get_option('facebook-url'); ?>



        <footer class="footer-bbva">
            <!-- footer -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-lg-8 footer-text"><span><?php echo bloginfo('name'); ?></span></div>
                    <div class="col-xs-12 col-sm-2 col-lg-4 footer-logo text-right"><span class="footer-iniciative"><?php _e('Una iniciativa de'); ?></span><span class="bbva-icon-BBVA"></span></div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-10 col-md-8 col-lg-8">
                        <div class="footer-menu-list">
                        <?php $menu_items = wp_get_nav_menu_items('menu-footer'); ?>
                            <?php foreach($menu_items as $key => $item): ?>
                            <a href="<?php echo $item->url; ?>"><?php echo $item->title; ?></a>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="hidden-xs col-sm-2 col-md-4 col-lg-4">
                        <ul class="footer-menu footer-social">
                            <?php if(!empty($url_facebook)) : ?><li><a target="_blank" href="<?php echo $url_facebook; ?>"><span class="bbva-icon-facebook_link"></span></a></li> <?php endif; ?>
                            <?php if(!empty($url_twitter)) : ?><li><a target="_blank" href="<?php echo $url_twitter; ?>"><span class="bbva-icon-twitter_link"></span></a></li> <?php endif; ?>
                            <?php if(!empty($url_youtube)) : ?><li><a target="_blank" href="<?php echo $url_youtube; ?>"><span class="bbva-icon-youtube"></span></a></li> <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 footer-copyright-group">
                        <p class="footer-copyright">&copy; 2016 BBVA</p>
                    </div>
                    <div class="visible-xs col-xs-12">
                        <ul class="footer-menu footer-social">
                            <?php if(!empty($url_facebook)) : ?><li><a target="_blank" href="<?php echo $url_facebook; ?>"><span class="bbva-icon-facebook_link"></span></a></li> <?php endif; ?>
                            <?php if(!empty($url_twitter)) : ?><li><a target="_blank" href="<?php echo $url_twitter; ?>"><span class="bbva-icon-twitter_link"></span></a></li> <?php endif; ?>
                            <?php if(!empty($url_youtube)) : ?><li><a target="_blank" href="<?php echo $url_youtube; ?>"><span class="bbva-icon-youtube"></span></a></li> <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- EO footer -->
        </footer>
    </div>
    
    <!--<script src="<?php //echo get_template_directory_uri(); ?>/resources/js/data.js"></script>-->
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/bootstrap.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.mmenu.min.all.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery-ui.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/js.cookie.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/bootstrap-select.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/modernizr.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/wow.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/picturefill.min.js"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDj_bv7e4BrxwnaEVfLCPMKAyKoQnv15Lo"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/moment.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/moment-precise-range.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/progressbar.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/underscore-min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/jquery.touchSwipe.min.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/ofi.browser.js"></script>
    <script src="<?php echo get_template_directory_uri(); ?>/resources/js/app.js"></script>

    <?php wp_footer(); ?>

</body>

</html>