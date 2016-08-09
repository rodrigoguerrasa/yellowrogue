<?php

/**********************************
 * ADD THE WHITEROGUE SHORTCODES
 **********************************/
/* White Rogue: Shortcodes
 * This shortcode is used for inserting the 'campanha' url parameter passed by the vmassivo email marketing to the
 * LEAD e-mail, if the LEAD comes from the marketing campaing
 *********************/

// This function is used for testing purposes.
function whiterogue_get_campanha($atts) {
    
    $pfb_campanha = filter_input(INPUT_GET,"pfb_campanha",FILTER_SANITIZE_STRING);
    $pfb_referrer = wp_get_referer();
    
    if (empty($pfb_referrer)) {
        $trackinginfo .= 'Referrer não identificado';
    } else {
        $trackinginfo .= $pfb_referrer;
    }
    
    if (empty($pfb_campanha)) {
        $trackinginfo .= 'Campanha não identificada';
    } else {
        $trackinginfo .= $pfb_campanha;
    }
    
    return $trackinginfo;
    
}
add_shortcode('pfb-campanha', 'whiterogue_get_campanha');

// These lines are necessary to make the shortcode work inside contact form 7.
function whiterogue_tracking_info($array) {
    
    $pfb_campanha = filter_input(INPUT_GET,"pfb_campanha",FILTER_SANITIZE_STRING);
    	
    if(wpautop($array['body']) == $array['body']) // The email is of HTML type
        $lineBreak = "<br/>";
    else
        $lineBreak = "\n";

    $trackinginfo = '';
    if (isset ($_SESSION['OriginalRef']) ) {
        $trackinginfo .= 'Usuário veio do site:' . ' ' . $_SESSION['OriginalRef'] . $lineBreak;
    } else {
        $trackinginfo .= 'Usuário veio do site: Problema. Avisar administrador.' . $lineBreak;
    }
    
    if (empty($pfb_campanha)) {
        $trackinginfo .= 'Usuário veio da campanha de email: Não identificada.' . $lineBreak;
    } else {
        $trackinginfo .= 'Usuário veio da campanha de email: ' . $pfb_campanha . $lineBreak;
    }
    
    $array['body'] = str_replace('[tracking-info]', $trackinginfo, $array['body']);

    return $array;

}
add_filter('wpcf7_mail_components', 'whiterogue_tracking_info');

// Set the Original Referrer 
function whiterogue_set_session_values() {

    if (!isset($_SESSION['OriginalRef'])) 
    {
        if(isset($_SERVER['HTTP_REFERER'])) {
            $_SESSION['OriginalRef'] = $_SERVER["HTTP_REFERER"];
        } else {
            $_SESSION['OriginalRef'] = 'Referenciador original não identificado.';
        }
    }

}
add_action('init', 'whiterogue_set_session_values');

