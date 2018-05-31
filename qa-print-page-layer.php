<?php

require_once PRINT_DIR.'/qa-print-page-html-builder.php';

class qa_html_theme_layer extends qa_html_theme_base
{
    public function __construct($template, $content, $rooturl, $request)
    {
        parent::__construct($template, $content, $rooturl, $request);
    }

    public function head()
    {
        if ($this->template === 'print') {
            $this->output('<head>');

            $this->head_title();
            print_page_html_builder::head_print($this);

            $this->output('</head>');
        } else {
            qa_html_theme_base::head();
        }
    }

    public function body_content()
    {
        if ($this->template === 'print') {
            $this->output('<div class="mdl-layout__container">');
            $this->output('<div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">');
            $this->main();
            $this->output('</div>');
            $this->output('</div>');
        } else {
            qa_html_theme_base::body_content();
        }
    }

    public function main()
    {
        if ($this->template === 'print') {
            $this->output('<div class="mdl-layout__content">');
            $this->output('<main>');

            print_page_html_builder::main_top();

            // 注意書き
            $this->output('<div class="print-notice">','ミツバチQ&A ('.qa_opt('site_url').') 印刷用ページ','</div>');
            
            $this->page_title_error();
            $this->main_parts($this->content);

            print_page_html_builder::main_bottom();
            
            $this->output('</main>');

            $this->output('</div> <!-- END mdl-layout__content -->', '');

        } else {
            qa_html_theme_base::main();
        }
    }

    public function page_title_error() {
        if ($this->template === 'print') {

            $this->output('<h1 class="mdl-layout-title">');
            $this->title();
            $this->output('</h1>');

        } else {
            qa_html_theme_base::page_title_error();
        }
    }

    public function title() {
        if ($this->template === 'print') {
            print_page_html_builder::title($this);
        } else {
            qa_html_theme_base::title();
        }
    }

    public function q_view_main($q_view)
    {
        if ($this->template === 'print') {
            print_page_html_builder::q_view_main($this, $q_view);
        } else {
            qa_html_theme_base::q_view_main($q_view);
        }
    }

    public function avatar($item, $class, $prefix=null)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::avatar($item, $class, $prefix);
        }
    }

    public function q_view_buttons($q_view)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::q_view_buttons($q_view);
        }
    }

    public function post_avatar_meta($post, $class, $avatarprefix=null, $metaprefix=null, $metaseparator='<br/>')
    {
        if ($this->template === 'print') {
            print_page_html_builder::post_avatar_meta($this, $post, $class, $avatarprefix, $metaprefix, $metaseparator);
        } else {
            qa_html_theme_base::post_avatar_meta($post, $class, $avatarprefix, $metaprefix, $metaseparator);
        }
    }

    public function post_meta_who($post, $class)
    {
        if ($this->template === 'print') {
            $post['who']['data'] = $post['raw']['handle'];
        }
        qa_html_theme_base::post_meta_who($post, $class);
    }

    public function post_tags($post, $class)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::post_tags($post, $class);
        }
    }

    public function a_form($a_form)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::a_form($a_form);
        }
    }

    public function c_form($c_form)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::c_form($c_form);
        }
    }

    public function a_item_main($a_item)
    {
        if ($this->template === 'print') {
            print_page_html_builder::a_item_main($this, $a_item);
        } else {
            qa_html_theme_base::a_item_main($a_item);
        }
    }

    public function a_item_buttons($a_item)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::a_item_buttons($a_item);
        }
    }

    public function c_item_buttons($c_item)
    {
        if ($this->template !== 'print') {
            qa_html_theme_base::c_item_buttons($c_item);
        }
    }
}