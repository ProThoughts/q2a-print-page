<?php

class print_page_html_builder
{

    public static function head_print($themeobj)
    {
        $template_path = PRINT_DIR.'/html/head.html';
        $charset = $themeobj->content['charset'];
        $site_url = qa_opt('site_url');
        $corecss = $themeobj->rooturl.$themeobj->css_name();
        include $template_path;
    }

    public static function main_top()
    {
        $template_path = PRINT_DIR.'/html/main_top.html';
        include $template_path;
    }

    public static function main_bottom()
    {
        $template_path = PRINT_DIR.'/html/main_bottom.html';
        include $template_path;
    }

    public static function footer()
    {
        $footer_about = qa_lang_html('material_lite_lang/footer_about_section_terms');
        $footer_copy = qa_lang_html('material_lite_lang/footer_copy_rights');
        $template_path = PRINT_DIR.'/html/footer.html';
        include $template_path;
    }

}