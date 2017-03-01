$(document).ready(function() {
    function ajaxManager() {
        var url, dataType, data, done, error;

        function init(url, dataType, done, error) {
            if (!$.isFunction(done)) {
                done = function (data) {};
            }
            if (!$.isFunction(error)) {
                error = function (jqXHR, textStatus) {};
            }
            if (!url) {
                error('Url is not setup for AJAX request');
            }
            dataType = dataType || 'json';
        }
        function send(data) {
            data = data || {};
            var request = $.ajax({
                url: url,
                type: "GET",
                data: data,
                dataType: dataType
            });

            request.done(function(msg) {
                done(msg);
            });

            request.fail(function(jqXHR, textStatus) {
                done(jqXHR, textStatus);
            });
        }

        return {
            init: init,
            send: send
        }
    }
});
