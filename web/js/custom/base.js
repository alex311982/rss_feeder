function ajaxManager() {
    var urlAjax, dataTypeAjax, doneCB, errorCB, parameters;

    function init(el, url, dataType, done, error) {
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

    function addParameters(params) {
        parameters.addParameters(params)
    }

    return {
        init: init,
        addParameters: addParameters,
        send: send
    }
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

function templateHandler() {
    var templates = {};

    function process(ids) {
        ids = normalize(normalize);

        $.map(ids, function(id) {
            var source = $(id).html();
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

$(document).ready(function() {
    function applicationInit() {
        $('#alert').html('').hide();

        $(document).on('categoryClickDocument', function(e, eventInfo) {
            subscribers = $('.subscribers-categoryClick');
            subscribers.trigger('categoryClick', eventInfo);
        });

        var widgets = {
            'feed': new Feed
        };
    }

    applicationInit();
});