<?php
/**
 * FlaTep Structure Headers sources data.
 *
 * Header Structure.
 *
 * @package FlaTep\Structure\Complements
 */
function flatep_sources_data(){
    return array(
        //-> <script src="https://code.jquery.com/jquery-1.12.4.min.js" integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=" crossorigin="anonymous"></script>
        'jquery-cdn-1-12-4' => array(
            'type' => 'script',
            'handle' => 'jquery-core',
            'src' => 'https://code.jquery.com/jquery-1.12.4.min.js',
            'integrity' => 'sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ=',
            'crossorigin' => 'anonymous',
            'deps' => array(),
            'ver' => null,
            'on_footer' => true,
        ),
        //-> <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        'jquery-cdn-2-2-4' => array(
            'type' => 'script',
            'handle' => 'jquery-core',
            'src' => 'https://code.jquery.com/jquery-2.2.4.min.js',
            'integrity' => 'sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=',
            'crossorigin' => 'anonymous',
            'deps' => array(),
            'ver' => null,
            'on_footer' => true,
        ),
        //-> <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        'jquery-cdn-3-4-1' => array(
            'type' => 'script',
            'handle' => 'jquery-core',
            'src' => 'https://code.jquery.com/jquery-3.4.1.min.js',
            'integrity' => 'sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=',
            'crossorigin' => 'anonymous',
            'deps' => array(),
            'ver' => null,
            'on_footer' => true,
        ),
        //-> <script src="https://code.jquery.com/jquery-migrate-3.1.0.min.js" integrity="sha256-ycJeXbll9m7dHKeaPbXBkZH8BuP99SmPm/8q5O+SbBc=" crossorigin="anonymous"></script>
        'jquery-mig-cdn-3-1-0' => array(
            'type' => 'script',
            'handle' => 'jquery-migrate',
            'src' => 'https://code.jquery.com/jquery-migrate-3.1.0.min.js',
            'integrity' => 'sha256-ycJeXbll9m7dHKeaPbXBkZH8BuP99SmPm/8q5O+SbBc=',
            'crossorigin' => 'anonymous',
            'deps' => array('jquery'),
            'ver' => null,
            'on_footer' => true,
        ),
        //-> <script src="https://code.jquery.com/jquery-migrate-1.4.1.min.js" integrity="sha384-uQPAXWjjvZGmVjKnobPRQOCEJ0rkCNRXW1GBUsJkjw1w0K7TxLH6Z3zMX7wtx+Lf" crossorigin="anonymous"></script>
        'jquery-mig-cdn-1-4-1' => array(
            'type' => 'script',
            'handle' => 'jquery-migrate',
            'src' => 'https://code.jquery.com/jquery-migrate-1.4.1.min.js',
            'integrity' => 'sha384-uQPAXWjjvZGmVjKnobPRQOCEJ0rkCNRXW1GBUsJkjw1w0K7TxLH6Z3zMX7wtx+Lf',
            'crossorigin' => 'anonymous',
            'deps' => array('jquery'),
            'ver' => null,
            'on_footer' => true,
        )
    );
}
