<?php
/* 
 * Remember that this file is only used if you have chosen to override event pages with formats in your event settings!
 * You can also override the single event page completely in any case (e.g. at a level where you can control sidebars etc.), as described here - http://codex.wordpress.org/Post_Types#Template_Files
 * Your file would be named single-event.php
 */
/*
 * This page displays a single event, called during the the_content filter if this is an event page.
 * You can override the default display settings pages by copying this file to yourthemefolder/plugins/events-manager/templates/ and modifying it however you need.
 * You can display events however you wish, there are a few variables made available to you:
 * 
 * $args - the args passed onto EM_Events::output() 
 */
global $EM_Event;
/* @var $EM_Event EM_Event #_LOCATIONMAP */
if(!function_exists('flatep_event_single')){
    function flatep_event_single($EM_Event){
        ob_start();
        ?>
        <section id="" class="section evt-body">
            <div class="bg section-bg fill bg-fill  bg-loaded"></div>
            <div class="section-content relative">
                <div class="row row-small">
                    <div class="evt-simple-header col large-12 small-12"><h2 class="uppercase">#_CATEGORYNAME</h2></div>
                    <div class="col large-7 medium-7 small-12 row-xsmall row-masonry">#_LOCATIONIMAGE</div>
                    <div class="col large-5 medium-5 small-12 row-xsmall row-masonry">
                        <h4 class=" uppercase evt-dates is-small">#_EVENTDATES</h4>
                        <p class="evt-hours from_the_blog_excerpt "><i>#_EVENTTIMES</i></p>
                        {has_location}
                        <p>
                            <strong>#_LOCATIONLINK</strong><br/>
                            #_LOCATIONADDRESS, #_LOCATIONPOSTCODE #_LOCATIONTOWN
                        </p>
                        {/has_location}
                        <p>
                            <strong>Cours Animés par :</strong><br />
                            #_CONTACTNAME
                        </p>
    
                        #_EVENTNOTES
                        {has_bookings}
                        <h3>Réservations</h3>
                        #_BOOKINGFORM
                        {/has_bookings}
                    </div>
                    <div class="col large-12 medium-12 small-12 row-xsmall row-masonry">
                        <h2 class="uppercase" style="text-align: left;">Cours A Venir :</h2>
                        [ux_events_list_grouped style="normal" type="masonry"  columns="3" col_spacing="xsmall" og_limit="6" og_scope="future" og_category="cours-tai-chi-chuan,cours-qi-gong,meditation" image_size="medium" text_size="normal" text_hover="invert" text_bg="rgb(33, 33, 33)" text_color="dark"]
                    </div>
            </div>
        </section>
    
    
    
        <?php
        $format = ob_get_contents();
        ob_end_clean();
        echo $EM_Event->output($format);
    }
    flatep_event_single($EM_Event);  
}
else{
    
}
//echo $EM_Event->output_single();

//echo apply_filters('em_event_output_single', $EM_Event->output($format, 'html'), $EM_Event, 'html');
//echo $format;
?>