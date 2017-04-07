$(document).ready(function() {

    function alert() {
        var messageToDisplay,
            isDisplay,
            alert = $('#alert');

        function run(runData) {
            var alertTemplate = templateManager.getTemplate('alert_tpl');

            if ($.isPlainObject(runData) && 'message' in runData) {
                setMessage(runData.message);
            }
            alert.append(alertTemplate({
                message: getLastMessage()
            }));
            alert.toggle(isDisplay);
        }

        function init() {
            templateManager = templateHandler();
            templateManager.process('alert_tpl');
            messagesToDisplay = [];
            isDisplay = false;

            $(document).trigger('widgetInited', {widgetName: getName()});
        }

        function setMessage(message) {
            if (message) {
                messageToDisplay = message;
                isDisplay = true;

                return true;
            }

            return false;
        }

        function getLastMessage() {
            return messageToDisplay ? messageToDisplay : null;
        }

        function getName() {
            return 'alert';
        }

        return {
            init: init,
            run: run,
            getName: getName
        }
    }

    $(document).trigger('widgetLoaded', {widgetInstance: alert()});
});