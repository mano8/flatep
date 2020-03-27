<?php
/* 
 * Remember that this file is only used if you have chosen to override location pages with formats in your events manager settings!
 * You can also override the single location page completely in any case (e.g. at a level where you can control sidebars etc.), as described here - http://codex.wordpress.org/Post_Types#Template_Files
 * Your file would be named single-location.php
 */
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Locations::output() 
 */
global $EM_Location;
/* @var $EM_Location EM_Location */
if(!function_exists('flatep_location_single')){
    function flatep_location_single($EM_Location){
        ob_start();
        ?>
        <section id="" class="section evt-body">
            <div class="bg section-bg fill bg-fill  bg-loaded"></div>
            <div class="section-content relative">
                <div class="row row-small">
                    <div class="evt-simple-header col large-12 small-12">
                        <h2 class="uppercase">#_LOCATIONNAME</h2>
                        <span class="uppercase is-small">#_LOCATIONADDRESS, #_LOCATIONPOSTCODE #_LOCATIONTOWN</span>
                    </div>
                    <div class="col large-12 medium-12 small-12 row-xsmall row-masonry">#_LOCATIONMAP</div>
                    <div class="col large-12 medium-12 small-12 row-xsmall row-masonry">
                        <h2 class="uppercase" style="text-align: left;">Cours A Venir :</h2>
                        [ux_events_list_grouped style="normal" type="masonry" columns="3" og_scope="future" og_limit="6" og_location="#_LOCATIONID" image_size="medium" text_size="small" text_hover="invert" text_bg="rgb(33, 33, 33)" text_color="dark"]
                    </div>
            </div>
        </section>
    
    
    
        <?php
        $format = ob_get_contents();
        ob_end_clean();
        echo $EM_Location->output($format);
    }
      
}
else{
    
}
flatep_location_single($EM_Location);
?>