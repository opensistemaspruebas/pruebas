<?php

/*
    Plugin Name: OS Impacto Widget
    Plugin URI: http://www.opensistemas.com/
    Description: Agrega un widget para mostrar los impactos
    Version: 1.0
    Author: Marta Oliver
    Author Email: moliver@opensistemas.com
    Plugin URI: http://www.opensistemas.com/
    Text Domain: os_impacto_widget
    License: GPLv2 
*/

if (!class_exists('OS_Impacto_Widget')) :

    class OS_Impacto_Widget extends WP_Widget {
        
        function __construct() {
            $options = array(
                'classname' => "impacto",
                'description' => __('Agrega un widget para mostrar los impactos','os_impacto_widget')
            );
            $this->WP_Widget('impacto', __('OS Impacto Widget', 'os_impacto_widget'), $options);
        }

        function form($instance) {
        }

            
        function update($new_instance, $old_instance) {

            return $new_instance;
        }

            
        function widget($args, $instance) {
            ?>
            <section class="pt-xl pb-lg">
                <div class="container">
                    <header class="title-description">
                        <h1>El impacto de la educación financiera</h1>
                        <div class="description-container">
                            <p>BBVA apuesta por la formación de la sociedad en diferentes países para mejorar sus oportunidades y su nivel de vida. En base a los objetivos para el 2018, estos son los últimos datos recogidos:</p>
                        </div>
                    </header>
                    <div class="row mt-md mb-lg">
                        <div class="col-xs-12 col-sm-4 text-center">
                            <!-- percicle element -->
                            <div class="circle-container blue hidden-xs hidden-sm">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">1,4</span> <span class="meter">MM</span></p>
                                        <p class="circle-label">ADULTOS</p>
                                    </div>
                                    <div class="procircle" data-value="0.5" data-size="260">
                                        <canvas width="260" height="260"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 3 MM</p>
                            </div>
                            <div class="circle-container blue hidden-md hidden-lg">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">1,4</span> <span class="meter">MM</span></p>
                                        <p class="circle-label">ADULTOS</p>
                                    </div>
                                    <div class="procircle blue" data-value="0.5" data-size="190">
                                        <canvas width="190" height="190"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 3 MM</p>
                            </div>
                            <!-- EO percicle element -->
                        </div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <!-- percicle element -->
                            <div class="circle-container yellow hidden-xs hidden-sm">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">5,2</span> <span class="meter">MM</span></p>
                                        <p class="circle-label">NIÑOS Y JÓVENES</p>
                                    </div>
                                    <div class="procircle" data-value="0.75" data-size="260">
                                        <canvas width="260" height="260"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 7 MM</p>
                            </div>
                            <div class="circle-container yellow hidden-md hidden-lg">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">5,2</span> <span class="meter">MM</span></p>
                                        <p class="circle-label">NIÑOS Y JÓVENES</p>
                                    </div>
                                    <div class="procircle yellow" data-value="0.75" data-size="190">
                                        <canvas width="190" height="190"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 7 MM</p>
                            </div>
                            <!-- EO percicle element -->
                        </div>
                        <div class="col-xs-12 col-sm-4 text-center">
                            <!-- percicle element -->
                            <div class="circle-container teel hidden-xs hidden-sm">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">120</span> <span class="meter">K</span></p>
                                        <p class="circle-label">PYMES</p>
                                    </div>
                                    <div class="procircle" data-value="0.5" data-size="260">
                                        <canvas width="260" height="260"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 200 K</p>
                            </div>
                            <div class="circle-container teel hidden-md hidden-lg">
                                <div class="circle-progress">
                                    <div class="circle-text">
                                        <p class="circle-value"><span class="label">120</span> <span class="meter">K</span></p>
                                        <p class="circle-label">PYMES</p>
                                    </div>
                                    <div class="procircle teel" data-value="0.5" data-size="190">
                                        <canvas width="190" height="190"></canvas>
                                    </div>
                                </div>
                                <p class="circle-footer">Objetivo 200 K</p>
                            </div>
                            <!-- EO percicle element -->
                        </div>
                    </div>
                    <div class="text-center">
                        <a href="" class="btn btn-bbva-aqua">Ver impactos</a>
                    </div>
                </div>
            </section>
            <?php
        }

            
    }

    add_action('widgets_init', create_function('', 'return register_widget("OS_Impacto_Widget");'));

endif;