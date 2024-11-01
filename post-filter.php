<?php
/*
Plugin Name:Simple Post Filter
Description:  This is a plugin to add a post list in any where , with  filter option with tags and cetagory.
Version: 2.0.2
Author: chandrima
Author URI: http://itobuz.com/
License: GPLv2
*/




function spf_enqueue_script() {
              wp_enqueue_script( 'pf-bootstrap-js', plugin_dir_url( __FILE__ ).'bootstrap/js/bootstrap.min.js',array('jquery'),'1.0.0', false );
             
              wp_enqueue_script( 'pf-isotope-js', plugin_dir_url( __FILE__ ).'js/jquery-isotope/js/isotope.pkgd.min.js',array('jquery'), false );
               
              wp_enqueue_script( 'pf-custom-js', plugin_dir_url( __FILE__ ).'js/custom.js',array('jquery','pf-isotope-js'),'1.0.1',  false );

              wp_register_style('isotope-css',plugin_dir_url( __FILE__ ).'js/jquery-isotope/css/style.css'); 
              wp_register_style( 'bootstrap-css',plugin_dir_url( __FILE__ ).'bootstrap/css/bootstrap.min.css' );
              wp_register_style( 'bootstrap-min-css',plugin_dir_url( __FILE__ ).'bootstrap/css/bootstrap-theme.min.css' );
              wp_register_style( 'pf-custom-css',plugin_dir_url( __FILE__ ).'css/style.css' );
              wp_enqueue_style( 'isotope-css' );
              wp_enqueue_style( 'bootstrap-css' );
              wp_enqueue_style( 'bootstrap-min-css' );
              wp_enqueue_style( 'pf-custom-css' );
}
add_action( 'wp_enqueue_scripts', 'spf_enqueue_script' );



add_shortcode( 'spf-cat-basic', 'spf_listing_shortcode' );
function spf_listing_shortcode( $atts ) {

             $atts = shortcode_atts(array(
                    'order' => 'ASC',
                    'no_of_post' => '5',
                    'orderby' =>'title',
                    'post-filter'=>''

                 ), $atts);

             $query = new WP_Query( array(
                   'post_type' => 'post',
                   'order' => $atts['order'],
                   'posts_per_page'=>$atts['no_of_post'],
                   'orderby' =>$atts['orderby'],
                   'post-filter'=>$atts['post-filter']

            ) );
            
            $output ="";   
                    
            switch($atts['post-filter']){
                case  'cat':
                        $categories =  get_categories();            
                        $output.= '<div class ="cateogries"><span class="cat">CATEGORIES : </span>';
                        $output.=   '<div class=" grid pf-category">';
                        $output.=      '<div class="button-group filter-button-group" data-filter-group="category">';
                                              $output.='  <button data-filter="*" class ="button is-checked">show all</button>';
                                                    foreach ($categories  as $value) {
                                                       $output.='<button data-filter=".'.$value->slug.'">'.$value->name.'</button>';
                                                   }
                        $output.=      '</div> 
                                     </div></div>';
                        break;
                case 'tags' :
                          $tags =  get_tags();
                          $output.= '<div class ="custom-filter tags"><span class ="tags">TAGS: </span>';
                          $output.=   '<div class=" grid pf-tags">';
                          $output.=   '   <div class="button-group filter-button-group" data-filter-group="tag">';
                                                $output.='  <button data-filter="*" class ="button is-checked">show all</button>'; 
                                                      foreach ($tags  as $value) {
                                                          $output.=  '<button data-filter=".'.$value->slug.'">'.$value->name.'</button>';
                                                    }
                          $output.=      '</div>
                                       </div></div>';
                          break;
                default: 
                      $categories =  get_categories();            
                        $output.= '<div class ="cateogries"><span class="cat">CATEGORIES : </span>';
                        $output.=   '<div class=" grid pf-category">';
                        $output.=      '<div class="button-group filter-button-group" data-filter-group="category">';
                                              $output.='  <button data-filter="*">show all</button>';
                                                    foreach ($categories  as $value) {
                                                       $output.='<button data-filter=".'.$value->slug.'">'.$value->name.'</button>';
                                                   }
                        $output.=      '</div> 
                                     </div></div>';
                      $tags =  get_tags();
                        $output.= '<div class ="tags"><span class ="tags">TAGS: </span>';
                        $output.=   '<div class=" grid pf-tags">';
                        $output.=   '   <div class="button-group filter-button-group" data-filter-group="tag">';
                                                $output.='  <button data-filter="*">show all</button>'; 
                                                      foreach ($tags  as $value) {
                                                          $output.=  '<button data-filter=".'.$value->slug.'">'.$value->name.'</button>';
                                                    }
                        $output.=      '</div>
                                       </div></div>';
                          break;
            } 





            $output.=  '<div class="postContainer team-listing row">';
                              while ( $query->have_posts() ) : $query->the_post(); 
                              include( 'content-page.php'); 
                                       endwhile;
                                wp_reset_postdata(); 
                                wp_reset_query();
                                
          $output.=   '</div>';
          return $output;  
                        
         }    

     //Modify excerpt length
 function spf_excerpt_length( $length ) {
          return 20;
        }
    add_filter( 'excerpt_length', 'spf_excerpt_length', 999 );
