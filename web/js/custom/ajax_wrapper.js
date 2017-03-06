function ajaxManager_CP() {
        var urlAjax, dataTypeAjax, dataAjax, doneCB, errorCB, isInited;

        function init(url, dataType, done, error) {
            if (!$.isFunction(done)) {
                doneCB = function (data) {};
            } else {
                doneCB = done;
            }
            if (!$.isFunction(error)) {
                error = function (jqXHR, textStatus) {};
            } else {
                errorCB = error;
            }
            if (!url) {
                errorCB('Url is not setup for AJAX request');
            } else {
                urlAjax = url
            }
            dataTypeAjax = dataType || 'json';

            isInited = true;
        }

        function send(data) {

            if (isInited) {
                dataAjax = data || {};
                sendAjax();

                return true;
            }

            return false;
        }

        function sendAjax() {
            var request = $.ajax({
                url: urlAjax,
                type: "GET",
                data: dataAjax,
                dataType: dataTypeAjax
            });

            request.done(function(msg) {
                doneCB(msg);
            });

            request.fail(function(jqXHR, textStatus) {
                errorCB(jqXHR, textStatus);
            });
        }

        function sendAjax_test() {
            var test_data = {
                news: [{
                    media: {
                        link: 'https://lenta.ru/news/2017/02/23/maslievdoping'
                    },
                    title: 'Front End Technical Lead',
                    description: '<![CDATA[Российского волейболиста австрийского клуба «Хипо Тироль» Станислава Маслиева дисквалифицировали на четыре года за употребление допинга. Проба была взята 9 ноября прошлого года после матча квалификации Лиги чемпионов с «Хапоэлем» из Мате-Ашеры. В крови спортсмена обнаружили следы стероида станозолола.]]>',
                    lastModified: 'Thu, 23 Feb 2017 20:13:00 +0300',
                },
                    {
                        media: {
                            link: 'https://lenta.ru/news/2017/02/23/maslievdoping'
                        },
                        title: 'Front End Technical Lead',
                        description: '<![CDATA[Российского волейболиста австрийского клуба «Хипо Тироль» Станислава Маслиева дисквалифицировали на четыре года за употребление допинга. Проба была взята 9 ноября прошлого года после матча квалификации Лиги чемпионов с «Хапоэлем» из Мате-Ашеры. В крови спортсмена обнаружили следы стероида станозолола.]]>',
                        lastModified: 'Thu, 23 Feb 2017 20:13:00 +0300',
                    },
                    {
                        media: {
                            link: 'https://lenta.ru/news/2017/02/23/maslievdoping'
                        },
                        title: 'Front End Technical Lead',
                        description: '<![CDATA[Российского волейболиста австрийского клуба «Хипо Тироль» Станислава Маслиева дисквалифицировали на четыре года за употребление допинга. Проба была взята 9 ноября прошлого года после матча квалификации Лиги чемпионов с «Хапоэлем» из Мате-Ашеры. В крови спортсмена обнаружили следы стероида станозолола.]]>',
                        lastModified: 'Thu, 23 Feb 2017 20:13:00 +0300',
                    }
                ],
                count: 3,
                total: 2
            };
            console.log('sendAjax_test');
            var deferred = $.Deferred();

            deferred.done(doneCB);
            deferred.fail(errorCB);

            deferred.resolve(test_data);
        }

        return {
            init: init,
            send: send
        }
    }
