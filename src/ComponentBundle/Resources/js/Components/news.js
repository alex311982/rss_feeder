$(document).ready(function() {
    function news() {
        var templateManager,
            ajaxHandler,
            offsetHandler,
            isClearContent,
            moreButton = $('#more'),
            mainNews = $('#main_news');

        function offsetManager() {
            var offset = 0;

            function getOffset () {
                return offset;
            }
            function addOffset (count) {
                offset += count;
            }
            function clearOffset () {
                offset = 0;
            }
            function setOffset (count) {
                offset = count;
            }

            return {
                getOffset : getOffset,
                setOffset : setOffset,
                clearOffset: clearOffset,
                addOffset: addOffset
            }
        }

        function ajaxSuccess(resolvedData) {
            var newsTemplate = templateManager.getTemplate('news');

            if ($.isPlainObject(resolvedData)
                && 'data' in resolvedData
                && newsTemplate
            ) {
                if (isClearContent) {
                    mainNews.empty();
                    isClearContent = false;
                }
                mainNews.append(newsTemplate({
                    news: resolvedData.data
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

            offsetHandler.addOffset(resolvedData.count);
            ajaxHandler.addParameter('offset', offsetHandler.getOffset());

            if (offsetHandler.getOffset() >= resolvedData.total) {
                moreButton.hide();
            } else {
                moreButton.show();
            }
        }

        function ajaxError(jqXHR, textStatus) {
            var error = {
                message: "Error from server with status " + textStatus,
                name: "Ajax call"
            };
            errorHandler(error);
        }

        function getNews() {
            if (!ajaxHandler.send()) {
                var error = {
                    message: "Ajax is not inited",
                    name: "Ajax call"
                };
                errorHandler(error);
            }
        }

        function init() {
            moreButton.hide();
            offsetHandler = offsetManager();
            offsetHandler.clearOffset();
            templateManager = templateHandler();
            templateManager.process('news');
            ajaxHandler = ajaxManager();
            ajaxHandler.init('{{ ajax_url }}', '{{ format }}', ajaxSuccess, ajaxError);

            isClearContent = false;

            moreButton.click(function () {
                $(document).trigger('moreClickDocument', {});
                getNews();
            });

            $(document).trigger('widgetInited', {widgetName: getName()});
        }

        function run(processData) {
            ajaxHandler.addParameters(processData);
            getNews();
        }

        function clearContent() {
            isClearContent = true;
            offsetHandler.clearOffset();
            ajaxHandler.addParameter('offset', offsetHandler.getOffset());
        }

        function getName() {
            return 'news';
        }

        return {
            init: init,
            run: run,
            clearContent: clearContent,
            getName: getName
        }
    }

    $(document).trigger('widgetLoaded', {widgetInstance: news()});
});