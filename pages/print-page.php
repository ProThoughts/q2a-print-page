<?php
    if (!defined('QA_VERSION')) { // don't allow this page to be requested directly from browser
        header('Location: ../');
        exit;
    }

    $qa_content = qa_content_prepare();

    return $qa_content;


/*
    Omit PHP closing tag to help avoid accidental output
*/