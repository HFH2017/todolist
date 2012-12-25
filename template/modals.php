<?php
/**
 * Created by JetBrains PhpStorm.
 * User: horsley
 * Date: 12-12-24
 * Time: 下午10:17
 * To change this template use File | Settings | File Templates.
 */?>
<!-- global modal dialogs -->
<div id="dlg_add_list" class="modal hide fade">
    <div class="modal-header">
        <h4>添加列表</h4>
    </div>
    <div class="modal-body">
        <div class="form-inline">
            <input type="text" placeholder="输入列表名称...">
            <button class="btn btn-primary">添加</button>
            <a href="#" class="btn" data-dismiss="modal">取消</a>
        </div>
    </div>
</div>

<div id="dlg_edit_list" class="modal hide fade">
    <div class="modal-header">
        <h4>列表重命名</h4>
    </div>
    <div class="modal-body">
        <div class="form-inline">
            <input type="text" placeholder="输入列表名称...">
            <button class="btn btn-primary">确定</button>
            <a href="#" class="btn" data-dismiss="modal">取消</a>
        </div>
    </div>
</div>


<div id="dlg_edit_note" class="modal hide fade">
    <div class="modal-header clearfix">
        <h4>任务附注</h4>
    </div>
    <div class="modal-body t-center" >
        <textarea style="width: 95%;height: 100px;"></textarea>
        <input type="hidden" name="note-tid">
    </div>
    <div class="modal-footer">
        <div>
            <button class="btn btn-primary">确定</button>
            <a href="#" class="btn" data-dismiss="modal">取消</a>
        </div>
    </div>
</div>