<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>添加</title>
    <link href="__STATIC__/component/pear/css/pear.css" rel="stylesheet"/>
    <link href="__STATIC__/component/pear/css/willphp.css" rel="stylesheet"/>
    <script src="__STATIC__/component/layui/layui.js"></script>
    <script src="__STATIC__/component/pear/pear.js"></script>
</head>
<body>
<form class="layui-form" action="{:url('add')}" method="post">
    <div class="mainBox">
        <div class="main-container">
<!--表单生成开始-->
{{$form_item}}<!--表单生成结束-->
        </div>
    </div>
    <div class="bottom">
        <div class="button-container">
            <button type="submit" class="layui-btn layui-btn-normal layui-btn-sm" lay-submit="" lay-filter="save">
                <i class="layui-icon layui-icon-ok"></i>
                提交
            </button>
            <button type="reset" class="layui-btn layui-btn-primary layui-btn-sm">
                <i class="layui-icon layui-icon-refresh"></i>
                重置
            </button>
        </div>
    </div>
</form>
<script>
    let layui_module = ['form', 'jquery', 'willphp'];
    //加载模块{{$push_module}}
    layui.use(layui_module, function () {
        let form = layui.form;
        let $ = layui.jquery;
        let willphp = layui.willphp;
        //表单JS设置{{$form_js}}
        form.on('submit(save)', function (data) {
            //表单提交数据设置{{$form_post_data}}
            willphp.ajaxPost(data, 0, function () {
                parent.layer.close(parent.layer.getFrameIndex(window.name));
                parent.layui.table.reload('dataTable');
            });
            return false;
        });
    })
</script>
</body>
</html>