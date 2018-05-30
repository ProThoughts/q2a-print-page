<?php

class print_page_html_builder
{

    public static function head_print($theme_obj)
    {
        $template_path = PRINT_DIR.'/html/head.html';
        $charset = $theme_obj->content['charset'];
        $site_url = qa_opt('site_url');
        $corecss = $theme_obj->rooturl.$theme_obj->css_name();
        $customcss = PRINT_RELATIVE_PATH.'/css/print-page.css';
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

    public static function post_avatar_meta($theme_obj, $post, $class, $avatarprefix = null, $metaprefix = null, $metaseparator = '<br/>')
    {
        if($class === "qa-q-item") {
            // delete post update meta
            // 投稿が編集された時などに以下の情報が含まれている
            $activity_info = array('when_2', 'who_2', 'what_2');
            foreach($activity_info as $key) {
                if (array_key_exists($key, $post)) {
                unset($post[$key]);
                }
            }

            $theme_obj->output('<nav class="'.$class.'-avatar-meta flex-style">');
            $theme_obj->post_meta($post, $class, $metaprefix, $metaseparator);
            $theme_obj->output('</nav>');

        } else {
            //コメントリストの場合はflex-styleで囲む
            $c_item_class = ($class === "qa-c-item") ? 'flex-style' :  '' ;

            $post_meta_show = true;
            $hide_post_meta = array('qa-q-view', 'qa-a-item', 'qa-c-item', 'blog-widget');
            if(in_array($class, $hide_post_meta)) {
                $post_meta_show = false;
            }

            if($post_meta_show) {
                $theme_obj->post_meta($post, $class, $metaprefix, $metaseparator);
            }

            $userId = $post['raw']['userid'];
            $handle = $post['raw']['handle'];
            if (!isset($userId)) {
                return;
            }

            $profile_show_views = array('qa-q-view', 'qa-a-item', 'qa-c-item', 'blog-widget');
            if(!in_array($class, $profile_show_views)) {
                return;
            }
            if(qa_theme_utils::is_edit($theme_obj->content)) {
                return;
            }

            $profileItems = qa_theme_utils::getUserprofile($userId);
            self::displayUserprofile($theme_obj, $post, $profileItems, $userId, $handle, $class);
        }

    }

    private static function displayUserprofile($theme_obj, $post,$profileItems, $userId, $handle = null, $class = null)
    {
        //プロフィール表示
        $theme_obj->output('<div class="profile">');
        $theme_obj->output('<div class="mdl-typography--subhead">');
        $theme_obj->post_meta_who($post, 'meta');
        //活動場所を表示
        $location = !empty($profileItems['location']) ? $profileItems['location'] : '';
        $theme_obj->output('<span class="mdl-chip__text"><span class="mdl-typography--font-bold">'.qa_lang_html('material_lite_lang/user_location').'</span>：'.$location.'</span>');
        $theme_obj->output('</div>');
        $theme_obj->output('</div>');
    }

}