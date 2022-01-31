<?php

namespace AsposeImagingConverter\ConvToWebP;

class AdminSubMenu
{
    function init()
    {
        add_action('admin_menu', array($this, 'add_submenu_pages'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }

    function should_add_submenu()
    {
        return !(strlen(get_option("aspose-cloud-app-sid")) < 1);
    }

    function add_submenu_pages()
    {
        if ($this->should_add_submenu()) {
            add_submenu_page(
                'aspose_image_optimizer',
                'Convert Images to WebP',
                'Convert Images to WebP',
                'edit_published_posts',
                'aspose_image_optimizer_convtowebp',
                array($this, 'render_submenu_page'),
                30
            );
        }
    }

    function render_submenu_page()
    {
?>
    <h1>Hi Test it is submenu</hi>
<?php
    }

    function enqueue_scripts()
    {
        $current_page   = '';
        $current_screen = '';

        if (function_exists('get_current_screen')) {
            $current_screen = get_current_screen();
            $current_page   = !empty($current_screen) ? $current_screen->base : $current_page;
        }

        if (strpos($current_page, "aspose_image_optimizer_convtowebp") === false) {
            return;
        }

        wp_register_script(
            'jqfancytreedeps',
            ASPIMGCONV_URL . 'assets/js/fancytree/lib/jquery.fancytree.ui-deps.js',
            array('jquery'),
            '1.0',
            true
        );

        wp_register_script(
            'jqfancytree',
            ASPIMGCONV_URL . 'assets/js/fancytree/lib/jquery.fancytree.js',
            array('jqfancytreedeps'),
            '1.0',
            true
        );

        wp_register_script(
            'aiconvtowebp_app',
            ASPIMGCONV_URL . 'assets/js/convtowebp.js',
            array('jqfancytree'),
            '1.0',
            true
        );

        wp_enqueue_script('aiconvtowebp_app');

        wp_register_style(
            'jqfancytreecss',
            ASPIMGCONV_URL . 'assets/js/fancytree/css/ui.fancytree.css',
            array(),
            '1.0'
        );

        wp_enqueue_style('jqfancytreecss');

        wp_register_style(
            'aiconvtowebp_styles',
            ASPIMGCONV_URL . 'assets/css/aiconvtowebp_styles.css',
            array(),
            '1.0'
        );

        wp_enqueue_style('aiconvtowebp_styles');
    }
}
