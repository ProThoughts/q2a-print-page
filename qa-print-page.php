<?php

    if ( !defined( 'QA_VERSION' ) ) { // don't allow this page to be requested directly from browser
        header( 'Location: ../' );
        exit;
    }

    class qa_print_page
    {

        private $directory;
        private $urltoroot;


        public function load_module( $directory, $urltoroot )
        {
            $this->directory = $directory;
            $this->urltoroot = $urltoroot;
        }

        public function match_request( $request )
        {
            $requestparts = qa_request_parts();

            return ( !empty( $requestparts )
                && @$requestparts[ 0 ] === 'print'
                && isset($requestparts[ 1 ]) 
            );
        }

        public function process_request( $request )
        {
            qa_set_template( 'print' );

            return require PRINT_DIR . '/pages/print-page.php';
        }
    }


    /*
        Omit PHP closing tag to help avoid accidental output
    */