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
            act_li.addClass('active');
        });
        return false;
    });
});