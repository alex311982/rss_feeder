function ajaxManager() {

    var urlAjax, dataTypeAjax, doneCB, errorCB, parameters;

    function init(url, dataType, done, error) {
        if (!$.isFunction(done)) {
            doneCB = function (jqXHR, textStatus) {
                throw {
                    message: "Error from server with status " + textStatus,
                    name: "Ajax call"
                }
            };
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

    function addParameters(params) {
        parameters.addParameters(params)
    }

    function parameterHandler() {
        var parameters = {};

        function addParameter(key, value) {
            if ($.type(key) === "string") {
                var obj = {};
                obj[key] = value;
                $.extend(parameters, obj);

                return true;
            }

            return false;
        }

        function addParameters(params) {
            if ($.isPlainObject(params)) {
                $.extend(parameters, params);

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

    return {
        init: init,
        addParameters: addParameters,
        send: send
    }
}

function templateHandler() {
    var templates = {};

    function process(ids) {
        ids = normalize(ids);

        $.map(ids, function(id) {
            var source = $('#' + id).html();
            templates[id] = Handlebars.compile(source);
        });
    }

    function getTemplate(id) {
        if ($.type(id) === "string" && id in templates) {
            return templates[id];
        }

        return null;
    }

    function normalize(ids) {
        if (!$.isArray(ids) && $.type(ids) === "string") {
            ids = [ids];
        }

        if (!$.isArray(ids)) {
            ids = [];
        }

        return ids;
    }

    return {
        process : process,
        getTemplate: getTemplate
    }
}

function errorHandler(error) {
    $(document).trigger('error', {error: error});
}