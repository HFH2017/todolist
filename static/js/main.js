/**
 * Created with JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-2
 * Time: 下午2:56
 * To change this template use File | Settings | File Templates.
 */
$(function(){
    //添加todo
    $('#btn_add_todo').live('click', function(){
        if($('#add_task').find('input').val() != '') {
            $.get('ajax.php?action=add_task', {task_title: $('#add_task').find('input').val()}, function(data){
                $('.tasks').not('.finished').prepend(data);
                $('#empty_list_tips').remove();

                //更新计数
                var count = $('.lists .active').find('.badge').html();
                count++;
                $('.lists .active').find('.badge').html(count);

                $('#add_task').find('input').val('');
            });
        }
        return false;
    });

    //添加列表
    var jq_add_list = $('#dlg_add_list');
    jq_add_list.find('button').click(function(){
        if(jq_add_list.find('input').val() != '') {
            $.get('ajax.php?action=add_list', {list_title: jq_add_list.find('input').val()}, function(data){
                $('#sidebar').find('.lists').append(data);
                jq_add_list.modal('toggle');
            });
        }
        return false;
    });

    //切换列表
    $('.lists li').live('click', function(){
        var act_li = $(this);
        $.get('ajax.php?action=load_tasks', {list_id: act_li.attr('id')}, function(data){
            $('#content').html(data);

            $('.lists .active').removeClass('active');
            $('.header .nav li.active').removeClass('active');
            act_li.addClass('active');

            $('.edit_list.clickable').parent().appendTo($('.lists .active a'));
        });
        return false;
    });

    //加载今天以及以前过期的任务
    $('#load_task_today').live('click',function(){
        $.get('ajax.php?action=load_tasks_today', function(data){
            $('#content').html(data);
            $('.lists .active').removeClass('active');
            $('.header .nav li.active').removeClass('active');
            $('#load_task_today').parent().addClass('active');

        });
        return false;
    });

    //加载未来七天以及以前过期的任务
    $('#load_task_week').live('click',function(){
        $.get('ajax.php?action=load_task_week', function(data){
            $('#content').html(data);
            $('.lists .active').removeClass('active');
            $('.header .nav li.active').removeClass('active');
            $('#load_task_week').parent().addClass('active');

        });
        return false;
    });

    $('#load_task_stared').live('click', function(){
        $.get('ajax.php?action=load_tasks_stared', function(data){
            $('#content').html(data);
            $('.lists .active').removeClass('active');
            $('.header .nav li.active').removeClass('active');
            $('#load_task_stared').parent().addClass('active');

        });
        return false;
    });



    //加星
    $('.tasks li .btn_add_star').live('click', function(){
        var act_li = $(this).parent().parent().parent();
        $.get('ajax.php?action=toggle_star', {task_id: act_li.attr('id')}, function(data){
            var the_star = act_li.find('.task-star').find('i');
            if (the_star.hasClass('icon-smoke')) {
                the_star.removeClass('icon-smoke').addClass('icon-yellow');
            } else {
                the_star.removeClass('icon-yellow').addClass('icon-smoke');
            }
        });
        return false;
    });

    //任务完成开关
    $('li .task-checkbox input').live('click', function(){
        var the_task = $('.tasks');
        var the_checkbox = $(this);
        var act_li = $(this).parent().parent().parent();

        $.get('ajax.php?action=toggle_task', {task_id: act_li.attr('id')}, function(data){
            if (the_checkbox.is(':checked')) {
                act_li.find('.task-title span').wrap("<del></del>");
                $('.tasks.finished').prepend(act_li);
            } else {
                act_li.find('del span').unwrap();
                the_task.not('.finished').prepend(act_li);
            }
        });
    });

    //编辑列表名称
    $('.edit_list.clickable').live('click', function(){
        $('#dlg_edit_list').find('input').attr('value',
            $('.lists li.active').find('span.list_name').html()
        ).end().modal('toggle');
    });

    var jq_edit_list = $('#dlg_edit_list');
    jq_edit_list.find('button').click(function(){
        if(jq_edit_list.find('input').val() != '') {
            $.get('ajax.php?action=edit_list', {list_title: jq_edit_list.find('input').val()}, function(data){
                $('.lists li.active').find('span.list_name').html(data)
                $('#add_task').find('input').attr('placeholder', '添加任务项目到 “' + data + '”...')
                jq_edit_list.modal('toggle');
            });
        }
        return false;
    });

    //任务信息修改
    var jq_task_li = $('li[id^="task-id-"]');
    //任务标题修改
    jq_task_li.find('.task-title').live('click', function(e){
        e.stopPropagation();
        var act_li = $(this).parent().parent();
        $(this).find('a').editable({
            name: 'task_title',
            pk: act_li.attr('id'),
            saveonchange: true,
            inputclass: 'input-large',
            toggle: 'manual',
            url: 'ajax.php?action=update_title'
        }).editable('show');
    });

    //任务日期修改
    jq_task_li.find('.deadline').live('click', function(e){
        e.stopPropagation();
        var act_li = $(this).parent().parent();
        $(this).find('a').editable({
            name: 'task_deadline',
            pk: act_li.attr('id'),
            saveonchange: true,
            type: 'date',
            toggle: 'manual',
            emptytext: '未设定',
            placement: 'bottom',
            url: 'ajax.php?action=update_deadline'
        }).editable('show');
    });

    //任务详情修改

    jq_task_li.find('.task-note').live('click', function(e){
        var act_li = $(this).parent().parent();

        var jq_edit_note = $('#dlg_edit_note');
        jq_edit_note.find('textarea').val($(this).find('span:hidden').html());
        jq_edit_note.find('input:hidden').val(act_li.attr('id'));
        jq_edit_note.modal('toggle');
    });

    var jq_edit_note = $('#dlg_edit_note');
    jq_edit_note.find('button').click(function(){
            $.post('ajax.php?action=update_note',
                {
                    value: jq_edit_note.find('textarea').val(),
                    pk: jq_edit_note.find('input:hidden').val(),
                    name: 'task_note'
                }, function(data){
                    var act_li = $('#' + jq_edit_note.find('input:hidden').val());

                    act_li.find('.task-note span:hidden').html(data);
                    var the_note = act_li.find('.task-note .icon-file');
                    if (the_note.hasClass('icon-smoke')) {
                        the_note.removeClass('icon-smoke').addClass('icon-gray');
                    } else {
                        if (data == '') the_note.removeClass('icon-gray').addClass('icon-smoke');
                    }
                    jq_edit_note.modal('toggle');
                });
        return false;
    });


});