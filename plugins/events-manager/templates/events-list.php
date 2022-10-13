<?php
/*
 * Default Events List Template
 * This page displays a list of events, called during the em_content() if this is an events list page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output()
 * 
 */
$args = apply_filters('em_content_events_args', $args);

if( get_option('dbem_css_evlist') ) echo "<div class='css-events-list'>";
ob_start();
        ?>
        <section id="" class="section evt-body">
            <div class="bg section-bg fill bg-fill  bg-loaded"></div>
            <div class="section-content relative">
                <div class="row row-small">
                    <div class="evt-simple-header col large-12 small-12"><h2 class="uppercase">#_CATEGORYNAME</h2></div>
                    <div class="col large-7 medium-7 small-12 row-xsmall row-masonry">#_CATEGORYIMAGE</div>
                    <div class="col large-5 medium-5 small-12 row-xsmall row-masonry">
                        
                    </div>
                    <div class="col large-12 medium-12 small-12 row-xsmall row-masonry">
                        <h2 class="uppercase" style="text-align: left;">Cours A Venir :</h2>
                        [ux_events_list_grouped style="normal" type="masonry"  columns="3" col_spacing="xsmall" og_limit="6" og_scope="future" og_category="#_CATEGORYID" image_size="medium" text_size="normal" text_hover="invert" text_bg="rgb(33, 33, 33)" text_color="dark"]
                    </div>
            </div>
        </section>
    
    
    
        <?php
        $args['format'] = ob_get_contents();
        ob_end_clean();
echo EM_Events::output( $args );

if( get_option('dbem_css_evlist') ) echo "</div>";
