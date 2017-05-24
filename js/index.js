$(function () {
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

    $('textarea').on('keypress', function (e) {
        var code = (e.keyCode ? e.keyCode : e.which);
        if (code == 13) {
            $('input[name=addTask]').trigger('click');
            e.preventDefault();
            return true;
        }
    });

    $('.edit').one('click', function () {
        var td = $(this).closest('tr').children('td:first-child'),
            id = $(this).next('form').children('input[type=hidden]').val(),
            text = td.text();
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
    });
});
