<?php 


                    $post_class = "col-sm-3 custom-column ";
                    $categories = get_the_category();
                    if(!empty($categories)){
                        foreach ($categories as $cat) {              
                            $post_class .= $cat->slug.' ';
                        }
                    }

                    $tags = get_the_tags();
                    if(!empty($tags)){
                        foreach ($tags as $tag) {              
                            $post_class .= $tag->slug.' ';
                        }
                    }

                     $thumbnail = get_the_post_thumbnail();
                     $title = get_the_title();
                     $excerpt = wp_trim_words( get_the_excerpt(), 10, '...' );
                     $permalink =get_permalink();
                     $output.=  ' <div class="'.$post_class.'" id="post-'.get_the_ID().'">
                                      <div class ="post-filter">
                                         <div class ="feature"> <a href="'.$permalink.'">'. $thumbnail.'</a></div>
                                         <div class ="custom-title"> <a href="'.$permalink.'">'.$title.'</a></div>
                                         <div class ="custom-excerpt">'.$excerpt.'</div>
                                         <div class ="btn"> <a href="'.$permalink.'">Read More</a></div>
                                       </div>  
                                   </div>';


