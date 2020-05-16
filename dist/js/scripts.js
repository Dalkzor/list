$(document).ready(function () {

    // ErrorCone
    const NO_AUTHENTICATION = 1;
    const NO_PERMISSIONS = 2;
    const INVALID_INPUT_PARAMETERS = 3;
    const WRONG_LOGIN_OR_PASSWORD = 4;
    const DUPLICATE_RECORD = 5;
    const INCOMPLETE_STRING = 6;
    const FORM_NOT_FIND = 7;
    const ENTITY_NOT_FOUND = 8;

    //add or edit operator
    const INVALID_LOGIN = 9;
    const INVALID_PASSWORD = 10;
    const PASSWORDS_DID_NOT_MATCH = 11;
    const LOGIN_BUSY = 12;

    // InfoCode
    const SUCCESSFUL_LOGIN = 'success_login';
    const SUCCESSFUL_LOGOUT = 'success_logout';
    const SUCCESS_DELETED = 'success_deleted';
    const FAILED_DELETED = 'failed_deleted';

    // Авторизация
    $('#bt-login').on('click', function (event) {
        event.preventDefault();
        const $this = $(this);
        $.ajax({
            type: "POST",
            url: "/login/signin",
            dataType: 'html',
            data: $('#form_login').serialize(),
            beforeSend: function () {
                $('.error').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_AUTHENTICATION) {
                        $('.error').text('Аккаунт заблокирован!').fadeIn(200);
                        $this.text('Войти').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.error').text('Заполните все поля!').fadeIn(200);
                        $this.text('Войти').attr('disabled', false);
                    } else if (data == WRONG_LOGIN_OR_PASSWORD) {
                        $('.error').text('Неверный логин или пароль!').fadeIn(200);
                        $this.text('Войти').attr('disabled', false);
                    } else if (data === SUCCESSFUL_LOGIN) {
                        location.reload();
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });
    });


    // Выход
    $('#logout').on('click', function (event) {
        event.preventDefault();
        $.ajax({
            type: "POST",
            url: "/logout",
            data: {'logout': 'logout'},
            beforeSend: function () {
                $('.wrapper').html('<div id="logout-gif" style="margin-top: ' +
                    ((document.body.scrollHeight / 2) - 37.5) + 'px"></div>');
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == 1) {
                        alert('ERROR LOGOUT!');
                    } else if (data === SUCCESSFUL_LOGOUT) {
                        location.reload();
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 500);
            }
        });
    });


    // Дополнение к переключателю панели в минималистический вид.
    $('#menu-control-button').on('click', function () {
        if (!$('body').hasClass('sidebar-collapse')) {
            $.cookie('sidebar', 'sidebar-collapse', {path: '/'});
        } else if ($('body').hasClass('sidebar-collapse')) {
            $.cookie('sidebar', null, {path: '/'});
        }
    });


    // Подключаем календари
    $('.date-from').datepicker({
        changeMonth: true,
        changeYear: true,
    });
    $('.date-to').datepicker({
        changeMonth: true,
        changeYear: true
    });

    // Селекторы для фильтра
    let config = {
        '.office': {allow_single_deselect: true},
        '.operator': {allow_single_deselect: true},
        '.client': {allow_single_deselect: true},
        '.complaint-type': {allow_single_deselect: true},
        '.complaint-status': {allow_single_deselect: true},
    };
    for (let selector in config) {
        $(selector).chosen(config[selector]);
    }


    // Кнопка, вызов формы для добавления жалобы
    $('#btn-add-complaint').on('click', function () {
        const $this = $(this);

        let title = 'Добавление жалобы';

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {'form': 'complaint'},
            beforeSend: function () {
                $('.error').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        $this.html('<i class="fa fa-plus"></i> Добавить жалобу').attr('disabled', false);
                        $('.insert-forms-complaint').attr('title', title).html(data).dialog({
                            resizable: false,
                            width: 540,
                            height: 'auto'
                        });
                        $('body .ui-dialog-title').text(title);
                        $('.select-chosen').chosen({allow_single_deselect: true});
                        $('.select-multiple').chosen();
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });
    });


    // Вызов формы добавление нового клиента
    $('body').on('click', '.add-new-client', function () {
        const $this = $(this);

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {'form': 'client'},
            success: function (data) {
                if (data) {
                    $('.insert-forms-client').attr('title', 'Добавление клиента').html(data).dialog({
                        resizable: false,
                        width: 265,
                        height: 'auto'
                    });

                    // Проверка номера телефона
                    $('.phone').inputmask();

                    // Разделение ФИО на отдельные слова и представление их в формуе создания нового клиента
                    let result = $this.siblings('span').text().split(' ');
                    $('.last-name').val(isNaN(parseInt(result[0])) ? result[0] : '');
                    $('.first-name').val(isNaN(parseInt(result[1])) ? result[1] : '');
                    $('.middle-name').val(isNaN(parseInt(result[2])) ? result[2] : '');
                } else {
                    alert('AJAX ERROR!');
                    location.reload();
                }
            }
        });
    });


    // Кнопка, добавить клиента
    $('.insert-forms-client').on('click', '.btn-client', function (event) {
        event.preventDefault();
        const $this = $(this);

        if (!$('.last-name').val() || !$('.first-name').val() || !$('.middle-name').val() ||
            ($('.phone').val().replace(/[^0-9]/g, "").length !== 10)) {
            $('.client-info').text('Заполните все поля!').fadeIn();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/client/addclient",
            dataType: 'html',
            data: $('.form-client').serialize(),
            beforeSend: function () {
                $('.client-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.client-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить клиента').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.client-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить клиента').attr('disabled', false);
                    } else if (data == DUPLICATE_RECORD) {
                        $('.client-info').text('Номер телефона занять!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить клиента').attr('disabled', false);
                    } else if (data == INCOMPLETE_STRING) {
                        $('.client-info').text('Некорректный номер телефона!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить клиента').attr('disabled', false);
                    } else if (data) {
                        let obj = JSON.parse(data);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить клиента').attr('disabled', false);
                        $('.client-complaint').append('<option selected value="' + obj.id + '">'
                            + obj.last_name + ' ' + obj.first_name + ' ' + obj.middle_name + ' (' + obj.phone +
                            ') </option>').trigger("chosen:updated");
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Функция для добавления данных в таблицу
    function insertDataInTable(complaintTable, data) {
        let obj = JSON.parse(data);
        $.each(obj, function (key, value) {
            let rowNode = complaintTable.row.add([
                '<div class="tools text-center сontrol">' +
                '<div class="fa fa-edit"></div>' +
                '<div class="fa fa-trash-o"></div>' +
                '<div class="hide-tag complaint-id">' + value.id + '</div>' +
                '</div>',
                value.id,
                value.create_date,
                value.operator,
                value.client,
                value.phone,
                value.office + ' [' + value.office_id + ']',
                value.description,
                value.complaint_type,
                value.responsible.join(', '),
                value.complaint_status,
                value.result,
                value.reason,
            ]).draw().node();
            if (value.result) {
                $('td', rowNode).eq(11).addClass('bg-result');
            }
        });
    }


    // Строим таблиуц жалоб
    let complaintTable = $("#complaint-table").DataTable({
        "order": [[1, "desc"]]
    });

    // Дабавление жалобы в базу данных
    $('.insert-forms-complaint').on('click', '.btn-complaint', function (event) {
        event.preventDefault();
        const $this = $(this);

        if (!$('.office-complaint').val() || !$('.client-complaint').val() ||
            !$('.type-complaint').val() || !$('.description').val() ||
            !$('.responsible-complaint').val().length) {
            $('.complaint-info').text('Заполните все обязательные поля!').fadeIn();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/complaint/addcomplaint",
            dataType: 'html',
            data: $('.form-complaint').serialize(),
            beforeSend: function () {
                $('.complaint-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.complaint-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.complaint-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data == ENTITY_NOT_FOUND) {
                        $('.complaint-infoo').text('Сущность не найдена!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data) {
                        insertDataInTable(complaintTable, data);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });

    let thisEditComplaint;

    // Вызов формы редактирование жалобы
    $('#complaint-table').on('click', '.fa-edit', function () {
        const $this = $(this);
        thisEditComplaint = $this;

        if (!$this.siblings('.complaint-id').text()) {
            return false;
        }

        let title = 'Редактирование жалобы';

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {
                'form': 'complaint',
                'id': $this.siblings('.complaint-id').text()
            },
            beforeSend: function () {
                $this.removeClass().addClass('ajax-loader');
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        $this.removeClass().addClass('fa fa-edit');
                        $('.insert-forms-complaint').attr('title', title).html(data).dialog({
                            resizable: false,
                            width: 540,
                            height: 'auto'
                        });
                        $('body .ui-dialog-title').text(title);
                        $('.select-chosen').chosen({allow_single_deselect: true});
                        $('.select-multiple').chosen();
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Кнопка, редактирование жалобы
    $('.insert-forms-complaint').on('click', '.btn-complaint-edit', function (event) {
        event.preventDefault();
        let $this = $(this);

        if (!$('.office-complaint').val() || !$('.client-complaint').val() ||
            !$('.type-complaint').val() || !$('.description').val() ||
            !$('.responsible-complaint').val().length) {
            $('.complaint-info').text('Заполните все обязательные поля!').fadeIn();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/complaint/editcomplaint",
            dataType: 'html',
            data: $('.form-complaint').serialize(),
            beforeSend: function () {
                $('.complaint-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.complaint-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.complaint-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data == ENTITY_NOT_FOUND) {
                        $('.complaint-info').text('Сущность не найдена!').fadeIn(200);
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                    } else if (data) {
                        let obj = JSON.parse(data);
                        $.each(obj, function (key, value) {
                            let rowNode = complaintTable.row(thisEditComplaint.parent().parent()).data([
                                '<div class="tools text-center сontrol">' +
                                '<div class="fa fa-edit"></div>' +
                                '<div class="fa fa-trash-o"></div>' +
                                '<div class="hide-tag complaint-id">' + value.id + '</div>' +
                                '</div>',
                                value.id,
                                value.create_date,
                                value.operator,
                                value.client,
                                value.phone,
                                value.office + ' [' + value.office_id + ']',
                                value.description,
                                value.complaint_type,
                                value.responsible.join(', '),
                                value.complaint_status,
                                value.result,
                                value.reason,
                            ]).draw().node();

                            if (value.result) {
                                $('td', rowNode).eq(11).addClass('bg-result');
                            } else {
                                $('td', rowNode).eq(11).removeClass('bg-result');
                            }
                        });
                        $this.html('<i class="fa fa-address-card"></i> Добавить').attr('disabled', false);
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Удаление жалобы
    $('#complaint-table').on('click', '.fa-trash-o', function () {
        const $this = $(this);

        if (!$this.siblings('.complaint-id').text()) {
            return false;
        }

        if (confirm('Точно удалить?')) {
            $.ajax({
                type: "POST",
                url: "/complaint/deleted",
                dataType: 'html',
                data: {'complaint-id': $this.siblings('.complaint-id').text()},
                beforeSend: function () {
                    $this.removeClass().addClass('ajax-loader');
                },
                success: function (data) {
                    setTimeout(function () {
                        if (data == NO_PERMISSIONS) {
                            $this.removeClass().addClass('fa fa-trash-o');
                            alert('Недостаточно прав!');
                        } else if (data == INVALID_INPUT_PARAMETERS) {
                            $this.removeClass().addClass('fa fa-trash-o');
                            alert('Некорректные данные!');
                        } else if (data == ENTITY_NOT_FOUND) {
                            $this.removeClass().addClass('fa fa-trash-o');
                            alert('Сущность не найдена!');
                        } else if (data == FAILED_DELETED) {
                            $this.removeClass().addClass('fa fa-trash-o');
                            alert('Не удалось удалить!');
                        } else if (data == SUCCESS_DELETED) {
                            //$this.removeClass().addClass('fa fa-trash-o');
                            complaintTable.row($this.parent().parent()).remove().draw();
                        } else {
                            alert('AJAX ERROR!');
                            location.reload();
                        }
                    }, 400);
                }
            });
        }
    });


    // Кнопка: Применить фильтр
    $('#btn-filter').on('click', function (event) {
        event.preventDefault();
        const $this = $(this);

        if (!$('.date-from').val() &&
            !$('.date-to').val() &&
            !$('.office').val() &&
            !$('.client').val() &&
            !$('.complaint-type').val() &&
            !$('.complaint-status').val() &&
            !$('.operator').val()
        ) {
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/complaint/filter",
            dataType: 'html',
            data: $('.filter-form').serialize(),
            beforeSend: function () {
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        complaintTable.rows().remove().draw();
                        insertDataInTable(complaintTable, data);
                        $this.html('<i class="fa fa-filter"></i> Применить фильтр').attr('disabled', false);
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });
    });


    // Строим таблиуц клиентов
    let clientTable = $("#client-table").DataTable({
        "order": [[1, "asc"]]
    });

    let thisEditClient;

    // Вызов формы редактирование клиента
    $('#client-table').on('click', '.fa-edit', function () {
        const $this = $(this);
        thisEditClient = $this;

        if (!$this.siblings('.client-id').text()) {
            return false;
        }

        let title = 'Редактирование клиента';

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {
                'form': 'client',
                'id': $this.siblings('.client-id').text()
            },
            beforeSend: function () {
                $this.removeClass().addClass('ajax-loader');
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        $this.removeClass().addClass('fa fa-edit');
                        $('.insert-forms-client').attr('title', title).html(data).dialog({
                            resizable: false,
                            width: 265,
                            height: 'auto'
                        });

                        // Проверка номера телефона
                        $('.phone').inputmask();

                        $('body .ui-dialog-title').text(title);
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Кнопка, редактирования клиента
    $('.insert-forms-client').on('click', '.btn-client-edit', function (event) {
        event.preventDefault();
        const $this = $(this);

        if (!$('.last-name').val() || !$('.first-name').val() || !$('.middle-name').val() ||
            ($('.phone').val().replace(/[^0-9]/g, "").length !== 10)) {
            $('.client-info').text('Заполните все поля!').fadeIn();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/client/editclient",
            dataType: 'html',
            data: $('.form-client').serialize(),
            beforeSend: function () {
                $('.client-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.client-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать клиента').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.client-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать клиента').attr('disabled', false);
                    } else if (data == DUPLICATE_RECORD) {
                        $('.client-info').text('Номер телефона занять!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать клиента').attr('disabled', false);
                    } else if (data == INCOMPLETE_STRING) {
                        $('.client-info').text('Некорректный номер телефона!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать клиента').attr('disabled', false);
                    } else if (data == ENTITY_NOT_FOUND) {
                        $('.client-info').text('Сущность не найдена!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать клиента').attr('disabled', false);
                    } else if (data) {
                        let obj = JSON.parse(data);
                        clientTable.row(thisEditClient.parent().parent()).data([
                            '<div class="tools text-center сontrol">' +
                            '<div class="fa fa-edit"></div>' +
                            '<div class="hide-tag client-id">' + obj.id + '</div>' +
                            '</div>',
                            obj.id,
                            obj.phone,
                            obj.last_name,
                            obj.first_name,
                            obj.middle_name,
                            obj.create_date,
                        ]).draw().node();
                        $this.html('<i class="fa fa-address-card"></i> Редактировать клиента').attr('disabled', false);
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Строим таблиуц операторов
    let operatorTable = $("#operator-table").DataTable({
        "order": [[1, "asc"]]
    });

    let thisEditOperator;


    // Кнопка, вызов формы для добавления оператора
    $('#btn-add-operator').on('click', function () {
        const $this = $(this);

        let title = 'Добавление оператора';

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {'form': 'operator'},
            beforeSend: function () {
                $('.error').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        $this.html('<i class="fa fa-plus"></i> Добавить оператора').attr('disabled', false);
                        $('.insert-forms-operator').attr('title', title).html(data).dialog({
                            resizable: false,
                            width: 590,
                            height: 'auto'
                        });
                        $('body .ui-dialog-title').text(title);
                        $('.select-chosen').chosen({allow_single_deselect: true});
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });
    });



    // Регулярные выражения
    const REG_LOGIN = /^[a-z0-9\._-]{3,32}$/i;
    const REG_PASSWORD = /^[a-z0-9\._`"\'!~@#$%^&*(){}|?:;<>]{6,20}$/i;

    // Кнопка, добавить оператора в базу данных
    $('.insert-forms-operator').on('click', '.btn-operator', function (event) {
        event.preventDefault();
        const $this = $(this);

        let errorDate = [];
        let login = $('.login').val();
        let password = $('.password').val();
        let password_check = $('.password_check').val();
        let role = $('.role').val();
        let lastName = $('.last-name').val();
        let firstName = $('.first-name').val();
        let middleName = $('.middle-name').val();

        if (!login || !password || !password_check || !role || !lastName || !firstName || !middleName) {
            $('.operator-info').text('Заполните все обязательные поля!').fadeIn();
            return false;
        }

        if (!login.match(REG_LOGIN)) {
            errorDate.push('<p>Логин должен быть от 3 до 32 символов и содержать A–Z, a–z, 0–9.</p>');
        }

        if (!password.match(REG_PASSWORD) || !password_check.match(REG_PASSWORD)) {
            errorDate.push('<p>Длина пароля от 6 до 20 символов, допускаются A–Z, a–z, 0–9.</p>');
        } else if (password !== password_check) {
            errorDate.push('<div>Пароли не совпали.</div>');
        }

        if (errorDate.length) {
            $('.operator-info').html(errorDate).fadeIn();
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '/operator/addoperator',
            dataType: 'html',
            data: $('.form-operator').serialize(),
            beforeSend: function () {
                $('.operator-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.operator-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.operator-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == INVALID_LOGIN) {
                        $('.operator-info').text('Логин должен быть от 3 до 32 символов и содержать A–Z, a–z, 0–9.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == INVALID_PASSWORD) {
                        $('.operator-info').text('Длина пароля от 6 до 20 символов, допускаются A–Z, a–z, 0–9.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == PASSWORDS_DID_NOT_MATCH) {
                        $('.operator-info').text('Пароли не совпали.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == LOGIN_BUSY) {
                        $('.operator-info').text('Логин занят.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data) {
                        let obj = JSON.parse(data);
                        console.log(obj);
                        operatorTable.row.add([
                            '<div class="tools text-center сontrol">' +
                            '<div class="fa fa-edit"></div>' +
                            '<div class="hide-tag operator-id">' + obj.id + '</div>' +
                            '</div>',
                            obj.id,
                            obj.title,
                            obj.login,
                            obj.last_name,
                            obj.first_name,
                            obj.middle_name,
                            obj.office,
                            obj.create_date,
                        ]).draw().node();
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Вызов формы редактирование оператора
    $('#operator-table').on('click', '.fa-edit', function () {
        const $this = $(this);
        thisEditOperator = $this;

        if (!$this.siblings('.operator-id').text()) {
            return false;
        }

        let title = 'Редактирование оператора';

        $.ajax({
            type: "POST",
            url: "/form",
            dataType: 'html',
            data: {
                'form': 'operator',
                'id': $this.siblings('.operator-id').text()
            },
            beforeSend: function () {
                $this.removeClass().addClass('ajax-loader');
            },
            success: function (data) {
                setTimeout(function () {
                    if (data) {
                        $this.removeClass().addClass('fa fa-edit');
                        $('.insert-forms-operator').attr('title', title).html(data).dialog({
                            resizable: false,
                            width: 590,
                            height: 'auto'
                        });
                        $('body .ui-dialog-title').text(title);
                        $('.select-chosen').chosen({allow_single_deselect: true});
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


    // Кнопка, редактирования оператора
    $('.insert-forms-operator').on('click', '.btn-operator-edit', function (event) {
        event.preventDefault();
        const $this = $(this);

        let errorDate = [];
        let login = $('.login').val();
        let password = $('.password').val();
        let password_check = $('.password_check').val();
        let role = $('.role').val();
        let lastName = $('.last-name').val();
        let firstName = $('.first-name').val();
        let middleName = $('.middle-name').val();

        if (!login || !role || !lastName || !firstName || !middleName) {
            $('.operator-info').text('Заполните все обязательные поля!').fadeIn();
            return false;
        }

        if (!login.match(REG_LOGIN)) {
            errorDate.push('<p>Логин должен быть от 3 до 32 символов и содержать A–Z, a–z, 0–9.</p>');
        }

        if (password || password_check) {
            if (!password.match(REG_PASSWORD) || !password_check.match(REG_PASSWORD)) {
                errorDate.push('<p>Длина пароля от 6 до 20 символов, допускаются A–Z, a–z, 0–9.</p>');
            } else if (password !== password_check) {
                errorDate.push('<div>Пароли не совпали.</div>');
            }
        }

        if (errorDate.length) {
            $('.operator-info').html(errorDate).fadeIn();
            return false;
        }

        $.ajax({
            type: "POST",
            url: "/operator/editoperator",
            dataType: 'html',
            data: $('.form-operator').serialize(),
            beforeSend: function () {
                $('.client-info').fadeOut(200);
                $this.html('<img src="/dist/img/ajax/ajax-loader-blue-button.gif" alt="" />').attr('disabled', true);
            },
            success: function (data) {
                setTimeout(function () {
                    if (data == NO_PERMISSIONS) {
                        $('.client-info').text('Недостаточно прав!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать оператора').attr('disabled', false);
                    } else if (data == INVALID_INPUT_PARAMETERS) {
                        $('.client-info').text('Некорректно введены данные!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать оператора').attr('disabled', false);
                    } else if (data == ENTITY_NOT_FOUND) {
                        $('.client-info').text('Сущность не найдена!').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Редактировать оператора').attr('disabled', false);
                    } else if (data == INVALID_LOGIN) {
                        $('.operator-info').text('Логин должен быть от 3 до 32 символов и содержать A–Z, a–z, 0–9.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == INVALID_PASSWORD) {
                        $('.operator-info').text('Длина пароля от 6 до 20 символов, допускаются A–Z, a–z, 0–9.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == PASSWORDS_DID_NOT_MATCH) {
                        $('.operator-info').text('Пароли не совпали.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data == LOGIN_BUSY) {
                        $('.operator-info').text('Логин занят.').fadeIn(200);
                        $this.html('<i class="fa fa-user-plus"></i> Добавить оператора').attr('disabled', false);
                    } else if (data) {
                        let obj = JSON.parse(data);
                        operatorTable.row(thisEditOperator.parent().parent()).data([
                            '<div class="tools text-center сontrol">' +
                            '<div class="fa fa-edit"></div>' +
                            '<div class="hide-tag operator-id">' + obj.id + '</div>' +
                            '</div>',
                            obj.id,
                            obj.title,
                            obj.login,
                            obj.last_name,
                            obj.first_name,
                            obj.middle_name,
                            obj.office,
                            obj.create_date,
                        ]).draw().node();
                        $this.html('<i class="fa fa-address-card"></i> Редактировать оператора').attr('disabled', false);
                        $this.parent().parent().parent().find('.ui-dialog-content').dialog("close");
                    } else {
                        alert('AJAX ERROR!');
                        location.reload();
                    }
                }, 400);
            }
        });

    });


});//Конец Document Ready