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
        if ($this->is_print_page()) {
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
        if ($this->is_print_page()) {
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
        if ($this->is_print_page()) {
            $this->output('<div class="mdl-layout__content">');
            $this->output('<main>');

            print_page_html_builder::main_top();

            // 注意書き
            print_page_html_builder::output_notice($this);
            
            $this->page_title_error();
            $this->main_parts($this->content);

            $this->output(
                '</div><!-- END mdl-cell--12-col -->',
                '</div> <!-- END mdl-grid -->'
            );

            $this->output('</div><!-- END mdl-card__supporting-text -->');

            print_page_html_builder::main_bottom();
            
            $this->output('</main>');

            $this->output('</div> <!-- END mdl-layout__content -->', '');

        } else {
            qa_html_theme_base::main();
        }
    }

    public function page_title_error() {
        if ($this->is_print_page()) {

            $this->output('<h1 class="mdl-layout-title">');
            $this->title();
            $this->output('</h1>');

        } else {
            qa_html_theme_base::page_title_error();
        }
    }

    public function title() {
        if ($this->is_print_page()) {
            print_page_html_builder::title($this);
        } else {
            qa_html_theme_base::title();
        }
    }

    public function q_view_main($q_view)
    {
        if ($this->is_print_page()) {
            print_page_html_builder::q_view_main($this, $q_view);
        } else {
            qa_html_theme_base::q_view_main($q_view);
        }
    }

    public function q_view_content($q_view)
    {
        if ($this->is_print_page()) {
            if (isset($q_view['content'])) {
                $q_view['content'] = print_page_html_builder::replace_youtube($q_view['content']);
            } else {
                $content = '';
            }
        }
        qa_html_theme_base::q_view_content($q_view);
    }

    public function avatar($item, $class, $prefix=null)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::avatar($item, $class, $prefix);
        }
    }

    public function q_view_buttons($q_view)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::q_view_buttons($q_view);
        }
    }

    public function post_avatar_meta($post, $class, $avatarprefix=null, $metaprefix=null, $metaseparator='<br/>')
    {
        if ($this->is_print_page()) {
            print_page_html_builder::post_avatar_meta($this, $post, $class, $avatarprefix, $metaprefix, $metaseparator);
        } else {
            qa_html_theme_base::post_avatar_meta($post, $class, $avatarprefix, $metaprefix, $metaseparator);
        }
    }

    public function post_meta_who($post, $class)
    {
        if ($this->is_print_page()) {
            $post['who']['data'] = $post['raw']['handle'];
        }
        qa_html_theme_base::post_meta_who($post, $class);
    }

    public function post_tags($post, $class)
    {
        if ($this->is_print_page()) {
            qa_html_theme_base::post_tags($post, $class);
        }
    }

    public function a_form($a_form)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::a_form($a_form);
        }
    }

    public function c_form($c_form)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::c_form($c_form);
        }
    }

    public function c_list($c_list, $class)
    {
        if ($this->template === 'print-blog') {
            print_page_html_builder::c_list_blog($this, $c_list, $class);
        } else {
            qa_html_theme_base::c_list($c_list, $class);
        }
    }

    public function c_list_items($c_items)
    {
        if ($this->template === 'print-blog') {
            print_page_html_builder::c_list_items_blog($this, $c_items);
        } else {
            qa_html_theme_base::c_list_items($c_items);
        }
    }

    public function a_item_main($a_item)
    {
        if ($this->is_print_page()) {
            print_page_html_builder::a_item_main($this, $a_item);
        } else {
            qa_html_theme_base::a_item_main($a_item);
        }
    }

    public function a_item_buttons($a_item)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::a_item_buttons($a_item);
        }
    }

    public function c_item_buttons($c_item)
    {
        if (!$this->is_print_page()) {
            qa_html_theme_base::c_item_buttons($c_item);
        }
    }

    public function a_item_content($a_item)
    {
        if ($this->is_print_page()) {
            $a_item['content'] = print_page_html_builder::replace_youtube($a_item['content']);
        }
        qa_html_theme_base::a_item_content($a_item);
    }

    public function c_item_content($c_item)
    {
        if ($this->is_print_page()) {
            $c_item['content'] = print_page_html_builder::replace_youtube($c_item['content']);
        }
        qa_html_theme_base::c_item_content($c_item);
    }

    public function a_list_items($a_items)
    {
        if ($this->is_print_page()) {
            foreach ($a_items as $a_item) {
                $this->a_list_item($a_item);
            }
        } else {
            qa_html_theme_base::a_list_items($a_items);
        }
    }

    private function is_print_page()
    {
        return ($this->template === 'print' || $this->template === 'print-blog');
    }
}