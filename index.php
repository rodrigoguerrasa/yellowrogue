<?php

// single out the page array
$page_array = explode( '/', $_SERVER['REQUEST_URI'] );
foreach( $page_array as $key => $item ) {
    if ( empty( $item ) ) {
        unset( $page_array[$key] );
    }
}

if ( empty ( $page_array ) ) {
    $page_array[1] = 'NA';
    $page_array[2] = 'NA';
}



// get the specific header for the page
switch ( $page_array[1] ) {
        
    case 'pfe':
        do_action( 'wrec_header', 'pfe' );
        break;
        
    default:
    case 'pff':
        do_action( 'wrec_header', 'pff' );
        break;
        
}

// get the page body
switch ( $page_array[2] ) {
    
    case 'wrec-subscribe':
        echo do_action('wrec_subscribe');
        break;
    case 'wrec-confirm':
        echo do_action('wrec_confirm');
        break;
    default:
        echo do_action('wrec_login');
        break;
}


// get the specific footer for the page
switch ( $page_array[1] ) {
        
    case 'pfe':
        do_action( 'wrec_footer', 'pfe' );
        break;
        
    default:
    case 'pff':
        do_action( 'wrec_footer', 'pff' );
        break;
     
    
}

 ?>