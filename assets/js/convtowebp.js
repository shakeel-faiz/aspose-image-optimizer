var WP_AIConvToWebP = WP_AIConvToWebP || {};
window.WP_AIConvToWebP = WP_AIConvToWebP;

jQuery(function($) {

    WP_AIConvToWebP.directory = {
        tree: [],

        init() {
            const self = this;

            $("#btnChooseDirectory").on('click', function(e) {
                $("#ChooseDirModal").addClass("aspimgconv_ModalActive");
                self.initFileTree();
            });
        },

        initFileTree() {
            const self = this;
            const aiconvButton = $('#ChooseDirModal .aspimgconv-box-footer-btn');

            ajaxSettings = {
                type: 'GET',
                url: ajaxurl,
                data: {
                    action: 'aiconvtowebp_get_directory_list',
                },
                cache: false,
            };

            // Object already defined.
            if (Object.entries(self.tree).length > 0) {
                return;
            }

            createTree = $.ui.fancytree.createTree;

            self.tree = createTree('#aspimgconv_Tree', {
                autoCollapse: true,
                // Automatically collapse all siblings, when a node is expanded
                clickFolderMode: 3,
                // 1:activate, 2:expand, 3:activate and expand, 4:activate (dblclick expands)
                checkbox: true,
                // Show checkboxes
                debugLevel: 0,
                // 0:quiet, 1:errors, 2:warnings, 3:infos, 4:debug
                selectMode: 3,
                // 1:single, 2:multi, 3:multi-hier
                tabindex: '0',
                // Whole tree behaves as one single control
                keyboard: true,
                // Support keyboard navigation
                quicksearch: true,
                // Navigate to next node by typing the first letters
                source: ajaxSettings,
                lazyLoad: (event,data)=>{
                    data.result = new Promise(function(resolve, reject) {
                        ajaxSettings.data.dir = data.node.key;
                        $.ajax(ajaxSettings).done((response)=>resolve(response)).fail(reject);
                    }
                    );
                }
                ,
                loadChildren: (event,data)=>data.node.fixSelection3AfterClick(),
                // Apply parent's state to new child nodes:
                activate: function(event, data) {
                    $("#statusLine").text(event.type + ": " + data.node);
                },
                select: function(event, data) {
                    aiconvButton.prop('disabled', !+self.tree.getSelectedNodes().length);
                }
            });
        }
    };

    WP_AIConvToWebP.directory.init();
});
