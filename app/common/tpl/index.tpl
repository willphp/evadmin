<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>列表</title>
  <link href="__STATIC__/component/pear/css/pear.css" rel="stylesheet" />
  <link href="__STATIC__/component/pear/css/willphp.css" rel="stylesheet"/>
</head>
<body class="pear-container">

<!-- 搜索 -->
{{$table_search}}

<!-- 表格 -->
<div class="layui-card">
  <div class="layui-card-body">
    <table id="dataTable" lay-filter="dataTable"></table>
  </div>
</div>

<!-- 工具栏 -->
<script type="text/html" id="table-toolbar">
  <button class="layui-btn layui-btn-sm" lay-event="add">
    <i class="layui-icon layui-icon-add-1"></i>
    新增
  </button>
  <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="batchEnable">
    <i class="layui-icon layui-icon-eye"></i>
    启用
  </button>
  <button class="layui-btn layui-btn-warm layui-btn-sm" lay-event="batchDisable">
    <i class="layui-icon layui-icon-eye-invisible"></i>
    停用
  </button>
  <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="batchRemove">
    <i class="layui-icon layui-icon-delete"></i>
    删除
  </button>
  {{$recycle}}
</script>

<!-- 操作列 -->
<script type="text/html" id="table-bar">
  <div class="layui-btn-group">
    <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="edit"><i class="layui-icon layui-icon-edit"></i></button>
    <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="remove"><i class="layui-icon layui-icon-delete"></i></button>
  </div>
</script>

<!-- 字段模板 -->
{{$field_tpl}}

<!-- 状态 -->
<script type="text/html" id="status">
  <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="启用|停用" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }} />
</script>

<script src="__STATIC__/component/layui/layui.js"></script>
<script src="__STATIC__/component/pear/pear.js"></script>
<script>
  layui.use(['table','form','jquery', 'willphp'],function () {
    let table = layui.table;
    let form = layui.form;
    let $ = layui.jquery;
    let willphp = layui.willphp;

    //表头
    let cols = [
      [
        {type:'checkbox'},
        {{$table_cols}}
        {title: '操作', toolbar: '#table-bar', align:'center', width:195}
      ]
    ]

    //表数据
    table.render({
      elem: '#dataTable',
      url: "{:url('index')}",
      response: {
        statusCode: 200
      },
      limit: {$limit},
      page: {
        layout: ['count', 'prev', 'page', 'next', 'skip', 'limit']
      },
      cols: cols ,
      skin: 'line',
      toolbar: '#table-toolbar',
      defaultToolbar: [{
        title: '刷新',
        layEvent: 'refresh',
        icon: 'layui-icon-refresh',
      }, 'filter', 'print', 'exports']
    });

    //表操作列事件
    table.on('tool(dataTable)', function(obj){
      if(obj.event === 'remove'){
        window.remove(obj);
      } else if(obj.event === 'edit'){
        window.edit(obj);
      }
    });

    //表头工具栏事件
    table.on('toolbar(dataTable)', function(obj){
      if(obj.event === 'add'){
        window.add();
      } else if(obj.event === 'refresh'){
        window.refresh();
      } else if(obj.event === 'batchRemove'){
        window.batchRemove(obj);
      } else if (obj.event === 'batchEnable') {
        window.batchState(obj, 'enable');
      } else if (obj.event === 'batchDisable') {
        window.batchState(obj, 'disable');
      } else if (obj.event === 'recycle') {
        window.recycle(obj);
      }
    });

    //状态切换事件
    form.on('switch(status)', function(data) {
      let status = data.elem.checked?1:0;
      let options = {
        form: { action: "{:url('state')}"},
        field: {
          ids: this.value,
          params: 'status-' + status
        },
      };
      willphp.ajaxPost(options, 0, function () {}, function () {
        $(data.elem).prop('checked',!$(data.elem).prop('checked'));
        form.render();
      });
    });

    function screen(width, height) {
      if (typeof width !== 'number' || width === 0) {
        width = $(window).width() * 0.8;
      }
      if (typeof height !== 'number' || height === 0) {
        height = $(window).height() - 20;
      }
      return [width + 'px', height + 'px'];
    }

    //编辑(操作列)
    window.edit = function(obj){
      layer.open({ type: 2, title: '修改', maxmin: true, shade: 0.1, area: screen(), content: "{:url('edit')}?id="+obj.data['id'] });
    }

    //删除单行(操作列)
    window.remove = function(obj){
      willphp.ajaxConfirm("{:url('del')}?ids="+obj.data['id'], '删除'+obj.data['id'], 0, function () {obj.del()});
    }

    //添加事件(工具栏)
    window.add = function(){
      layer.open({ type: 2, title: '新增', maxmin: true, shade: 0.1, area: screen(), content: "{:url('add')}" });
    }

    //回收站
    window.recycle = function() {
      layer.open({
        type: 2,
        maxmin: true,
        title: '回收站',
        shade: 0.1,
        area: screen(),
        content: "{:url('recycle')}",
        cancel: function () {
          table.reload('dataTable');
        }
      });
    }

    //获取选中的ids
    window.getIds = function (obj) {
      let data = table.checkStatus(obj.config.id).data;
      if(data.length === 0){
        return false;
      }
      let ids = "";
      for(let i = 0;i<data.length;i++){
        ids += data[i].id+",";
      }
      return ids.substr(0,ids.length-1);
    }

    //删除多行(工具栏)
    window.batchRemove = function(obj){
      let ids = window.getIds(obj);
      if (ids === false) {
        layer.msg("请选择id",{icon:3,time:1500});
        return false;
      }
      willphp.ajaxConfirm("{:url('del')}?ids="+ids, '删除'+ids, 0, function () {
        table.reload('dataTable');
      });
    }

    //批量启用或禁用(工具栏)
    window.batchState = function(obj, status){
      let ids = window.getIds(obj);
      if (ids === false) {
        layer.msg("请选择id",{icon:3,time:1500});
        return false;
      }
      let title = (status === 'enable') ? '启用' : '停用';
      let state = (status === 'enable') ? 1 : 0;
      layer.confirm('确定要' + title + '吗?'+ ids, {icon: 3, title:'提示'}, function (index) {
        layer.close(index);
        let options = {
          form: { action: "{:url('state')}"},
          field: {
            ids: ids,
            params: 'status-' + state
          },
        };
        willphp.ajaxPost(options, 0, function () {
          table.reload('dataTable');
        });
      });
    }

    //刷新表(工具栏)
    window.refresh = function(){
      table.reload('dataTable');
    }

    // 搜索提交
    form.on('submit(table-search)', function(data){
      table.reload('dataTable', { page: { curr: 1 }, where: data.field });
      return false;
    });

  })
</script>
</body>
</html>