$(function () {

    //Смена статуса задачи
    $('.change-status').on('click', function () {
        const item = $(this).closest('.item');
        item.toggleClass('done');
        const data = {
            id: item.data('id'),
            status: item.hasClass('done') ? 1 : 2
         }


        $.ajax({
            url: '/ajax/toggleTaskStatus.php',
            method: 'post',
            dataType: 'json',
            data: data,
            success: function(data){
                console.log('data', data);
            },
            error: function (e) {
                console.log('error', e);
            }
        });

    })

    //Открываем форму добавления задачи
    $('.add-task').on('click', function () {
        $('.edit-task-form').removeClass('active');
        $('.new-task-form').toggleClass('active');
    });

    //Добавление новой задачи
    $('.new-task-form .btn').on('click', function (e) {
        e.preventDefault();
        const data = {
            name: $('#name').val() || 'Новая задача',
            comment: $('#comment').val()
        }
        $.ajax({
            url: '/ajax/newTask.php',
            method: 'post',
            dataType: 'html',
            data: data,
            success: function(data){
                $('main.content').html(data);
            },
            error: function (e) {
                console.log('error', e);
            }
        });
    });

    //Редактирование задачи
    $('.tasks__edit').on('click', function (e) {
        $('.new-task-form').removeClass('active');
        const $item = $(this).closest('.item');
        const $form = $('.edit-task-form');
        // const data = {
        //     name: $item.find('.task__name').text().trim(),
        //     dateCreate: $item.find('.task__date-create').text().trim(),
        //     status: $item.hasClass('done') ? 1 : 2,
        //     comment: $item.find('.task__comment').text().trim(),
        // }

        $form.find('#edit-name').val($item.find('.task__name').text().trim());
        $form.find('#edit-comment').val($item.find('.task__comment').text().trim());
        $form.addClass('active');
        // con??sole.log(data);

        $('.edit-task-form .btn').on('click', function (e) {
            e.preventDefault();
            const data = {
                id: $item.data('id'),
                name: $form.find('#edit-name').val(),
                comment: $form.find('#edit-comment').val()
            }
            $.ajax({
                url: '/ajax/editTask.php',
                method: 'post',
                dataType: 'html',
                data: data,
                success: function(data){
                    $('main.content').html(data);
                },
                error: function (e) {
                    console.log('error', e);
                }
            });
        });
    })

    //Зыкрыть форму
    $('.form-close').on('click', function () {
        $('.task-form').removeClass('active');
    })
})


