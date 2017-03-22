$(document).ready(function() {

    var widgets = {};

    $(document).on('widgetLoaded', function (e, eventInfo) {
        var widget = eventInfo.widgetInstance,
            name = widget.getName();
        widgets[name] = widget;
        widgets[name].init();
    });

    $(document).on('widgetInited', function (e, eventInfo) {
        var name = eventInfo.widgetName;
        widgets[name].run();
    });

    $(document).on('moreClickDocument', function (e, eventInfo) {

    });

    $(document).on('error', function (e, eventInfo) {
        var error = eventInfo.error,
            alertMessage = {message : 'Ошибка ' + error.name + ':' + error.message}
        widgets['alert'].run(alertMessage);
    });

    $(document).on('categoryClickDocument', function(e, eventInfo) {
        widgets['news'].clearContent();
        widgets['news'].run({slug : eventInfo.category_slug});
    });
});