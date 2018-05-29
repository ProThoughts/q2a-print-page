<?php

/*
    Plugin Name: Q2A Print Page
    Plugin URI:
    Plugin Description: Provide a page for printing on Q2A site.
    Plugin Version: 1.0
    Plugin Date: 2018-05-30
    Plugin Author: 38qa.net
    Plugin Author URI:
    Plugin License: GPLv2
    Plugin Minimum Question2Answer Version: 1.7
    Plugin Update Check URI:
*/

if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
    header('Location: ../../');
    exit;
}

// CONSTANT value
@define( 'PRINT_DIR', dirname( __FILE__ ) );
@define( 'PRINT_FOLDER', basename( dirname( __FILE__ ) ) );
@define( 'PRINT_RELATIVE_PATH', '../qa-plugin/'.AMP_FOLDER.'/');

// Phrases

// Page

// layer

/*
    Omit PHP closing tag to help avoid accidental output
*/