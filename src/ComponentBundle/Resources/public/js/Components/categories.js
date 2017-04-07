$(document).ready(function() {

    function categories() {
        var templateManager,
            ajaxHandler,
            categoryLink = $('.category_link');

        function ajaxSuccess(resolvedData) {
            var categoriesTemplate = templateManager.getTemplate('categories');

            if ($.isPlainObject(resolvedData)
                && 'data' in resolvedData
                && categoriesTemplate
            ) {
                $('#categories_list').append(categoriesTemplate({
                    categories: resolvedData.data
                }));
            }
            if ($.isPlainObject(resolvedData)
                && 'error' in resolvedData
            ) {
                var error = {
                    message: resolvedData.error,
                    name: "Server error",
                    code: 500
                };
                errorHandler(error);
            }
        }

        function ajaxError(jqXHR, textStatus) {
            var error = {
                message: "Error from server with status " + textStatus,
                name: "Ajax call"
            };
            errorHandler(error);
        }

        function getCategories() {
            if (!ajaxHandler.send()) {
                var error = {
                    message: "Ajax is not inited",
                    name: "Ajax call"
                };
                errorHandler(error);
            }
        }

        function init() {
            templateManager = templateHandler();
            templateManager.process('categories');
            ajaxHandler = ajaxManager();

            ajaxHandler.init(ajaxUrlCategories, formatCategories, ajaxSuccess, ajaxError);

            $('#categories_list').on('click', '.category_link', function(e) {
                var id = $(this).data('id');
                $(document).trigger('categoryClickDocument', {category_id: id});
            });

            $(document).trigger('widgetInited', {widgetName: getName()});
        }

        function run(processData) {
            ajaxHandler.addParameters(processData);
            getCategories();
        }

        function getName() {
            return 'categories';
        }

        return {
            init: init,
            run: run,
            getName: getName
        }
    }

    $(document).trigger('widgetLoaded', {widgetInstance: categories()});
});