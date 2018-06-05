<?php

class print_page_html_builder
{

    public static function head_print($theme_obj)
    {
        $template_path = PRINT_DIR.'/html/head.html';
        $charset = $theme_obj->content['charset'];
        $site_url = qa_opt('site_url');
        $corecss = $theme_obj->rooturl.$theme_obj->css_name();
        if ($theme_obj->template === 'print') {
            $customcss = PRINT_RELATIVE_PATH.'css/print-page.css';
        } else {
            $customcss = PRINT_BLOG_RELATIVE_PATH.'css/print-page.css';
        }
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

    public static function output_notice($theme_obj)
    {
        if ($theme_obj->template === 'print') {
            $url = qa_path(qa_request_part(1), null, qa_opt('site_url'));
        } else {
            $url = qa_path(qa_request_part(1).'/'.qa_request_part(2), null, qa_opt('site_url'));
        }
        $notice = qa_lang_sub('print_lang/head_notice', $url);
        $theme_obj->output(
            '<div class="print-notice">',
            $notice,
            '</div>'
        );
    }

    public static function title($theme_obj)
    {
        $q_view = @$theme_obj->content['q_view'];
        $title = str_replace('<span', '<div', $theme_obj->content['title']);
        $title = str_replace('</span>', '</div>', $title);
        $category_class = qa_theme_utils::get_category_class($q_view['raw']['categoryname']);
        $theme_obj->output(
            '<div class="mdl-cell--4-col-phone mdl-typography--text-center">',
            '<span class="mdl-chip__text">',
            $q_view['raw']['categoryname'],
            '</span>',
            '</div>'
        );
        $title = str_replace('　','&nbsp;',$title);
        $theme_obj->output('<div>'.$title. '</div>');
    }

    public static function q_view_main($theme_obj, $q_view)
    {
        $theme_obj->output('<div class="qa-q-view-main">');

        $theme_obj->output('<div class="mdl-navigation flex-style">');
        $theme_obj->post_avatar_meta($q_view, 'qa-q-view');
        $theme_obj->output('</div>');
        $suffix=isset($q_view['when']['suffix']) ? $q_view['when']['suffix'] : '';
        $theme_obj->output('<div class="mdl-color-text--grey-400 margin--bottom-16px margin--top-16px">');
        $theme_obj->output(qa_lang_html('material_lite_lang/post_date'));
        $theme_obj->output($q_view['when']['data'].$suffix);
        $theme_obj->output(',  ');
        $theme_obj->view_count($q_view);
        $theme_obj->output('</div>');
        $theme_obj->q_view_content($q_view);
        $theme_obj->q_view_extra($q_view);
        $theme_obj->q_view_follows($q_view);
        $theme_obj->q_view_closed($q_view);
        $theme_obj->post_tags($q_view, 'qa-q-view');

        if (count($q_view['c_list']['cs']) > 0) {
            $theme_obj->c_list(@$q_view['c_list'], 'qa-q-view');
        }

        $theme_obj->output('</div> <!-- END qa-q-view-main -->');

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

    public static function a_item_main($theme_obj, $a_item)
    {
        $theme_obj->output('<div class="qa-a-item-main mdl-card__supporting-text">');


        if ($a_item['hidden']) {
            $theme_obj->output('<div class="qa-a-item-hidden">');
        }
        $theme_obj->error(@$a_item['error']);

        //要素が横並びになるようにflexスタイルを適用
        $theme_obj->output('<div class="flex-style">');
        $theme_obj->post_avatar_meta($a_item, 'qa-a-item');
        $theme_obj->output('</div><!-- END flex-style -->');
        //flexスタイルここまで
        $suffix = isset($a_item['when']['suffix']) ? $a_item['when']['suffix'] : '';
        $theme_obj->output('<div class="mdl-color-text--grey-400 margin--bottom-16px margin--top-16px">'. qa_lang_html('material_lite_lang/post_date') . $a_item['when']['data']. $suffix);

        if(isset($a_item['flags'])) {
            $theme_obj->output(', ' . $a_item['flags']['prefix'] . $a_item['flags']['data'] . $a_item['flags']['suffix']);
        }

        $theme_obj->output('</div>');
        $theme_obj->a_item_content($a_item);

        if ($a_item['hidden']) {
            $theme_obj->output('</div>');
        }


        if (count($a_item['c_list']['cs']) > 0) {
            $theme_obj->output('<div class="comment-wrap">');
            $theme_obj->c_list(@$a_item['c_list'], 'qa-a-item');

            // c_formに回答のIDを追加
            @$a_item['c_form']['parentid'] = $a_item['raw']['postid'];

            $theme_obj->output('</div><!-- END comment-wrap -->');
        }
        $theme_obj->output('</div> <!-- END qa-a-item-main -->');
    }

    public static function replace_youtube($content)
    {
        $regex = '/<a href="[^"]*(youtube|youtu\.be)[^"]*"[^>]*>([^<]*)<\/a>/i';
        $replace = qa_lang('print_lang/youtube_movie').'$2';
        $res = preg_replace($regex, $replace, $content);
        return $res;
    }

    public static function c_list_blog($theme_obj, $c_list, $class)
    {
        if (!empty($c_list)) {
            $theme_obj->output('', '<div class="'.$class.'-c-list"'.(@$c_list['hidden'] ? ' style="display:none;"' : '').' '.@$c_list['tags'].'>');
            $comment_count = count($c_list['cs']);
            $theme_obj->output('<h2 class="mdl-typography--title-color-contrast mdl-typography--font-bold">');
            $temp = qa_lang_html('material_lite_lang/comments_count');
            $theme_obj->output(strtr($temp, array('^1' => $comment_count)));
            $theme_obj->output('</h2>');
            $theme_obj->c_list_items($c_list['cs']);
        }
    }

    public static function c_list_items_blog($theme_obj, $c_items)
    {
        //ブログページの場合comment-wrapで囲む
        if($theme_obj->template === 'print-blog') {
            $theme_obj->output('<div class="comment-wrap">');
            $theme_obj->output('<div id="blog-c-list">');
        }
        
        foreach ($c_items as $c_item)
            $theme_obj->c_list_item($c_item);

    }

}