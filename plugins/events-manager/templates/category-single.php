<?php
/*
 * This page displays a single event, called during the em_content() if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Category;
/* @var $EM_Category EM_Category */
if(!function_exists('flatep_evt_cat_single')){
    function flatep_evt_cat_single($EM_Category){
        ob_start();
        ?>
        <section id="" class="section evt-body">
            <div class="bg section-bg fill bg-fill  bg-loaded"></div>
            <div class="section-content relative">
                <div class="row row-small">
                    <div class="evt-simple-header col large-12 small-12"><h2 class="uppercase">#_CATEGORYNAME</h2></div>
                    <div class="col large-12 medium-12 small-12 row-xsmall row-masonry">
                        [ux_events_list_grouped style="normal" type="masonry"  columns="3" col_spacing="xsmall" og_scope="future" og_limit="6" og_category="#_CATEGORYID" image_size="medium" text_size="normal" text_hover="invert" text_bg="rgb(33, 33, 33)" text_color="dark"]
                    </div>
            </div>
        </section>
    
    
    
        <?php
        $format = ob_get_contents();
        ob_end_clean();
        echo $EM_Category->output($format);
    }
    flatep_evt_cat_single($EM_Category);  
}
else{
    
}
//echo $EM_Category->output_single();
?>