$(function () {

    $('.addTaskForm').on('submit', function (e) { // Обработка формы добавления задачи
        var description = $('textarea'),
            form = $(this);

        $.post({ // Отправка ajax запроса на добавление задачи
            url: 'controller.php',
            data: {addTask: 'true', task: description.val()},
            dataType: 'json',
            cache: false,
            success: function (data) { // При успехе добавляем задачу в таблицу
                var tableRow =
                    $('<tr style="background-color: lightgreen">' +
                    '<td>' + data['description'] + '</td>' +
                    '<td style="color: orange">В процессе</td>' +
                    '<td>' + data['date_added'] + '</td>' +
                    '<td>' +
                    '<p class=\'edit link\'>Изменить &#9998; </p>' +
                    '<p class=\'done link\'>Выполнить &#10004; </p>' +
                    '<p class=\'delete link\'>Удалить &cross; </p>' +
                    '<input type="hidden" value="' + data['id'] + '">' +
                    '</td>' +
                    '</tr>').css({
                        backgroundColor: 'lightgreen'
                    });

                var table = $('table');
                if (table.length === 1) { // Если таблица есть, просто вставить задачу (+ анимация цвета при добавлении)
                    table.append(tableRow);
                    if(($('tr').length-1)%2 === 0) { // Если четная - фон ряда серый, если нечетная - фон ряда белый
                        tableRow.animate({
                            backgroundColor:'#eeeeee'
                        }, 2000);
                    } else {
                        tableRow.animate({
                            backgroundColor:'white'
                        }, 2000);
                    }
                } else { // Если таблицы нет, создаем ее и добавляем туда задачу (+ анимация цвета при добавлени)
                    var tr = tableRow[0]['outerHTML'];
                    $('.tasks').html(
                        '<table>' +
                        '<tr>' +
                        '<td>Задача</td>' +
                        '<td>Статус</td>' +
                        '<td>Дата добавления</td>' +
                        '<td>Действия</td>' +
                        '</tr>' +
                        tr +
                        '</table>'
                    );
                    $('table tr:eq(1)').animate({
                        backgroundColor:'white'
                    }, 2000);
                }
            },
            error: function (data) { // При ошибке показать уведомление
                console.log(data);
                form.prepend('<p class="notice" style="color: red">Произошла ошибка, попробуйте еще раз! (' + data.responseText + ')</p>');
                $('.notice').delay(1500).fadeOut(1000, function () {
                    $(this).css({
                        'display': 'block',
                        'visibility': 'hidden'
                    }).animate({
                        'height': '0',
                        'margin': '0'
                    }, function () {
                        $(this).remove();
                    });
                });
            }
        });
        description.val(''); // Чистим textarea
        e.preventDefault(); // Отменяем стандартное поведение формы
    });


    // Отправка содержимого textarea на enter
    $('textarea').on('keypress', function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code === 13) {
            $('input[name=addTask]').trigger('click');
            e.preventDefault();
            return true;
        }
    });

    // Отметить задачу, как выполненную
    $(document).on('click', '.done', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val();

        if (div.closest('tr').children('td:eq(1)').text() === 'Выполнено') { // Если уже выполненная, то ничего не делать
            return;
        }

        $.post({
            url: 'controller.php',
            data: {done: 'true', id: id},
            success: function (data) {
                div.closest('tr').children('td:eq(1)').text(data).css({
                    'color': 'green'
                });
                div.fadeOut('fast');
            }
        });
    });

    // Удалить задачу
    $(document).on('click', '.delete', function () {
        var div = $(this),
            id = div.closest('td').find('input[type=hidden]').val();

        $.post({
            url: 'controller.php',
            data: {delete: 'true', id: id},
            success: function () {
                div.closest('tr').remove();
                if ($('table tr').length - 1 === 0) { // Если мы удаляем последную задачу, убрать таблицу
                    $('.tasks').html(
                        '<p class="smile">&#9785;</p>' +
                        '<p style="text-align: center;">Вы пока не добавили ни одной задачи</p>'
                    );
                }
            }
        });
    });

    // Отредактировать задачу
    $(document).on('click', '.edit', function () {
        var td = $(this).closest('tr').children('td:first-child'),
            id = $(this).closest('td').find('input[type=hidden]').val(),
            text = td.text();

        // Убрать текст задачи, показать форму для изменения
        td.fadeOut('fast', function () {
            var replaceElement = $('<td>' +
                '<form method="POST" class="editTaskForm">' +
                '<input type="text" name="editDescription" value="' + text + '"><br>' +
                '<input type="submit" value="Изменить" name="editTask" class="button">' +
                '<input type="hidden" name="id" value="' + id + '">' +
                '</form>' +
                '</td>').hide();

            td.replaceWith(replaceElement);
            replaceElement.fadeIn('fast');
        });

        // При подтверждении изменения изменить и вставить изменения
        $(document).on('submit', '.editTaskForm', function (e) {
            var form = $(this);
            $.post({
                url: 'controller.php',
                data: $(this).serialize(),
                success: function (data) {
                    form.replaceWith(data);
                }
            });

            e.preventDefault();
        })
    });

});
