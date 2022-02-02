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
        <style>
            #btnChooseDirectory {
                box-sizing: border-box;
                cursor: pointer;
                display: inline-block;
                border-width: 2px;
                border-style: solid;
                border-color: transparent;
                border-radius: 4px;
                text-decoration: none;
                text-align: center;
                min-width: 80px;
                padding: 5px 14px;
                text-transform: uppercase;
                background-color: #17A8E3;
                color: #fff;
            }
        </style>


        <button id="btnChooseDirectory">Choose Directory</button>

        <div id="ChooseDirModal" class="aspimgconv_Modal">
            <div class="aspimgconv_ModalOverlay"></div>
            <div class="aspimgconv_Content">
                <div class="aspimgconv-box">
                    <div class="aspimgconv-box-header">
                        <h3 class="aspimgconv-box-title">Choose Directory</h3>
                        <div class="aspimgconv-btn-div">
                            <button class="aspimgconv-btn-close">&times;</button>
                        </div>
                    </div>
                    <div class="aspimgconv-box-body">
                        <p class="aspimgconv-box-body-description">Please choose the folder which contains the images that you want to optimize. <i>Aspose Image Optimizer</i> will automatically include the images from this folder as well as from all its subfolders.</p>
                        <div id="aspimgconv_Tree"></div>
                    </div>
                    <div class="aspimgconv-box-footer">
                        <button class="aspimgconv-box-footer-btn" disabled>
                            <div class="aic-btn-text">Choose directory</div>
                            <div class="aic-btn-loader" style="margin: 0 50px;display:none;">
                                <div class="aic-progress-loader"></div>
                            </div>
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="ProgressModal" class="aspimgconv_Modal">
            <div class="aspimgconv_ModalOverlay"></div>
            <div class="aspimgconv_Content">
                <div class="aspimgconv-box">
                    <div class="aspimgconv-box-header">
                        <h3 class="aspimgconv-box-title">Optimizing your images ...</h3>
                        <div class="aspimgconv-btn-div">
                            <button class="aspimgconv-btn-close">&times;</button>
                        </div>
                    </div>
                    <div class="aspimgconv-box-body">
                        <p class="aspimgconv-box-body-description">Images are being compressed and optimized, please do not close this dialog.</p>
                        <div id="aspimgconv_Progress">
                            <div class="aic-progress-block">
                                <div class="aic-progress">
                                    <div style="margin: 0 10px;">
                                        <div class="aic-progress-loader"></div>
                                    </div>
                                    <div class="aic-progress-text">
                                        <span>0%</span>
                                    </div>
                                    <div class="aic-progress-bar">
                                        <span style="width:0"></span>
                                    </div>
                                </div>
                            </div>
                            <div style="text-align:center">
                                <div id="ProgressStateText">Optimizing images
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="aspimgconv-box-footer">
                        <button class="aspimgconv-box-footer-btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
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
