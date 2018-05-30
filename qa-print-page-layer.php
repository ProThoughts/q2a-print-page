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
            $this->output(
                '<div class="mdl-chip mdl-cell--4-col-phone mdl-cell mdl-typography--text-center mdl-color--primary">',
                '<span class="mdl-chip__text mdl-color-text--white">',
                @$this->content['q_view']['raw']['categoryname'],
                '</span>',
                '</div>'
            );
            $title = str_replace('　','&nbsp;',$this->content['title']);
            $this->output('<div>'.$title. '</div>');
        } else {
            qa_html_theme_base::title();
        }
    }

}