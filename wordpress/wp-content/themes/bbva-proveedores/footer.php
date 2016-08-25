    <div id="back-to-top">
    <a href="#" class="icon-subir" title="Back to top"><span class="textoIconoOcultar">Subir</span></a>    
    </div>
    <footer id="mainFooter" data-role="footer">
        <div class="wrapperFluid">
            <section id="footer_logos" class="colFluid"><div class="wrapperContent">
                    <ul>
                        <li class="item_01"><a target="_blank" href="https://www.bbva.es/"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVA.svg" title="logo BBVA" /></a></li>
                        <li class="item_02"><a target="_blank" href="https://www.bbvafrances.com.ar/"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVAfrances.svg" title="logo BBVA Francés" /></a></li>
                        <li class="item_03"><a target="_blank" href="http://www.bancomer.com/"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVAbancomer.svg" title="logo BBVA Bancomer" /></a></li>
                        <li class="item_04"><a target="_blank" href="https://www.bbvacontinental.pe"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVAcontinental.svg" title="logo BBVA Continental" /></a></li>
                        <li class="item_05"><a target="_blank" href="https://www.bbvacompass.com/"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVAcompass.svg" title="logo BBVA Compass" /></a></li>
                        <li class="item_06 last"><a target="_blank" href="https://www.provincial.com/"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoBlanco_BBVAprovincial.svg" title="logo BBVA Provincial" /></a></li>
                    </ul>
            </div></section>
            <section id="footer_desplegablesInfo" class="colCompleta"><div class="wrapperContent">
                 <div id="accordion" class="row"> 
                        <h3 id="accordion_tab1" class="acordeon_titulo closed"><strong>Webs BBVA</strong></h3>
                        <div id="accordion_content1" class="acordeon_texto" style="display:none;">
                            <div class="col-md-4 col-sm-6 col-xs-6 lista_websBBVA">
                                <h4><?php _e("Negocio Responsable"); ?></h4>
                                <?php print_r(get_footer_links()); ?>
                            </div>                        
                            <div class="col-md-4 col-sm-6 col-xs-6 lista_websBBVA">
                                <h4><?php _e("Redes Sociales"); ?></h4>

                                <?php print_r(get_footer_links_media()); ?>
                                <!-- SOCIAL MEDIA ACORDEON
                               <ul class="lista_websBBVA lista_1col">
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/" target="_blank"><?php _e("BBVA Social Media");?></a></li>
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/facebook/" target="_blank">Facebook</a></li>
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/twitter/" target="_blank">Twitter</a></li>
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/google/" target="_blank">Google +</a></li>
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/youtube/" target="_blank">Youtube</a></li>
                                    <li><a target="_blank" href="http://www.bbvasocialmedia.com/linkedin/" target="_blank">Linkedin</a></li>
                                </ul>

                                -->
                            </div>                                                 
                            <div class="col-md-4 col-sm-6 col-xs-6 lista_websBBVA">
                                <h4><?php _e("Accesos directos"); ?></h4>

                                <?php print_r(get_footer_links_news()); ?>
                                <!-- NEWS
                               <ul class="lista_websBBVA lista_1col">
                                    <li><a target="_blank" href="https://info.bbva.com/es/"><?php _e("Noticias BBVA");?></a></li>
                                </ul>
                                -->
                            </div>                               
                        </div>   
                </div>
            </div></section>
            
            <section id="footer_tools" class="colCompleta"><div class="wrapperContent">
                <div class="colPpal col-md-8">
                    <?php print_r(get_footer_links_media_icon()); ?>
                    <!-- SOCIAL MEDIA ICON
                    <ul id="footer_redesFollow" class="redesFollow">
                        <li class="item_01"><a target="_blank" href="http://www.bbvasocialmedia.com/facebook/" class="icon-social_FB"><span class="textoIconoOcultar">Facebook</span></a></li>
                        <li class="item_02"><a target="_blank" href="http://www.bbvasocialmedia.com/twitter/" class="icon-social_TW"><span class="textoIconoOcultar">Twitter</span></a></li>
                        <li class="item_03"><a target="_blank" href="http://www.bbvasocialmedia.com/google/" class="icon-social_IN"><span class="textoIconoOcultar">Linkedin</span></a></li>
                        <li class="item_04"><a target="_blank" href="http://www.bbvasocialmedia.com/youtube/" class="icon-social_GO"><span class="textoIconoOcultar">Google+</span></a></li>
                        <li class="item_05 last"><a target="_blank" href="http://www.bbvasocialmedia.com/linkedin/" class="icon-social_YT"><span class="textoIconoOcultar">Youtube</span></a></li>
                    </ul>
                    -->
   
                    <?php print_r(get_footer_links_bottom()); ?>
                     <!-- LINKS BOTTOM
                     <ul id="footer_politicaLinks" class="politicaLinks">
                        <li class="item_01"><a href="/contactoayuda/contacta-mapa/"><?php _e("Contacto");?></a></li>
                        <li class="item_02"><a href="/aviso-legal/"><?php _e("Aviso Legal");?></a></li>
                        <li class="item_03"><a href="/politica-de-privacidad/"><?php _e("Política de privacidad");?></a></li>
                        <li class="item_04 last"><a href="/politica-de-cookies/"><?php _e("Política de cookies");?></a></li>
                      </ul>
                      -->

                  </div>
                  <div class="colDcha col-md-4">
                      <p id="footer_logoPais"><img src="<?php echo get_template_directory_uri(); ?>/resources/images/logosPaises/logoAzul_BBVA.svg" title="logo BBVA" /></p>
                      <p id="footer_copy">&copy; 2016 Banco Bilbao Vizcaya Argentaria, S.A.</p>
                  </div>
            </div></section>
        </div>
    </footer>

</div>

<?php wp_footer(); ?>
</body>
</html>