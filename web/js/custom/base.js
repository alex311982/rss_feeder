$(document).ready(function() {
    function ajaxManager() {
        var urlAjax, dataTypeAjax, doneCB, errorCB, parameters;

        function init(url, dataType, done, error) {
            if (!$.isFunction(done)) {
                doneCB = function (data) {};
            } else {
                doneCB = done;
            }
            if (!$.isFunction(error)) {
                errorCB = function (errorMessage) {};
            } else {
                errorCB = error;
            }
            if (!url) {
                errorCB('Url is not setup for AJAX request');
            } else {
                urlAjax = url
            }
            dataTypeAjax = dataType || 'json';

            parameters = parameterHandler();
        }

        function send() {
            if (urlAjax && dataTypeAjax) {
                var request = $.ajax({
                    url: urlAjax,
                    type: "GET",
                    data: parameters.getParameters(),
                    dataType: dataTypeAjax
                });

                request.done(function(msg) {
                    doneCB(msg);
                });

                request.fail(function(jqXHR, textStatus) {
                    errorCB(jqXHR, textStatus);
                });

                return true;
            }

            return false;
        }

        function getParameterHandler() {
            return parameters;
        }

        return {
            init: init,
            getParameterHandler: getParameterHandler,
            send: send
        }
    }

    function parameterHandler() {
        var parameters = {};

        function addParameter(key, value) {
            if ($.type(key) === "string") {
                $.extend(parameters, {key : value});

                return true;
            }

            return false;
        }

        function addParameters(params) {
            if ($.isPlainObject(params)) {
                $.extend(parameters, {key : value});

                return true;
            }

            return false;
        }

        function removeParameter(key) {
            delete parameters[key];
        }

        function getParameters() {
            return parameters;
        }

        return {
            addParameter: addParameter,
            addParameters: addParameters,
            removeParameter: removeParameter,
            getParameters: getParameters
        }
    }

    function applicationInit() {
        $('#alert').html('').hide();

        $(document).on('categoryClick', function(e, eventInfo) {
            subscribers = $('.category_link');
            subscribers.trigger('categoryClick', eventInfo);
        });
    }

    applicationInit();
});