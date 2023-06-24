<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>回收站</title>
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
  <button class="layui-btn layui-btn-sm" lay-event="batchRestore">
    <i class="layui-icon layui-icon-refresh"></i>
    恢复数据
  </button>
  <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="batchDestroy">
    <i class="layui-icon layui-icon-delete"></i>
    彻底删除
  </button>
</script>

<!-- 状态 -->
<script type="text/html" id="status">
  <input type="checkbox" name="status" value="{{d.id}}" lay-skin="switch" lay-text="启用|停用" lay-filter="status" {{ d.status == 1 ? 'checked' : '' }} />
</script>

<script type="text/html" id="deleteTime">
  {{layui.util.toDateString(d.delete_time*1000, 'yyyy-MM-dd')}}
</script>

<!-- 字段模板 -->
{{$field_tpl}}

<!-- 操作列 -->
<script type="text/html" id="table-bar">
  <div class="layui-btn-group">
    <button class="layui-btn layui-btn-normal layui-btn-sm" lay-event="restore"><i class="layui-icon layui-icon-refresh"></i></button>
    <button class="layui-btn layui-btn-danger layui-btn-sm" lay-event="destroy"><i class="layui-icon layui-icon-delete"></i></button>
  </div>
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
        {title: '删除时间', field: 'delete_time', align:'center', templet: '#deleteTime'},
        {title: '操作', toolbar: '#table-bar', align:'center', width:195}
      ]
    ]

    //表数据
    table.render({
      elem: '#dataTable',
      url: "{:url('recycle')}",
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
      if(obj.event === 'destroy'){
        window.destroy(obj);
      } else if(obj.event === 'restore'){
        window.restore(obj);
      }
    });

    //表头工具栏事件
    table.on('toolbar(dataTable)', function(obj){
      if(obj.event === 'batchRestore'){
        window.batchRestore(obj);
      } else if(obj.event === 'batchDestroy'){
        window.batchDestroy(obj);
      }
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

    //批量恢复(工具栏)
    window.batchRestore = function(obj){
      let ids = window.getIds(obj);
      if (ids === false) {
        layer.msg("请选择id",{icon:3,time:1500});
        return false;
      }
      willphp.ajaxConfirm("{:url('restore')}?ids="+ids, '恢复'+ids, 0, function () {
        table.reload('dataTable');
      });
    }

    //批量删除(工具栏)
    window.batchDestroy = function(obj){
      let ids = window.getIds(obj);
      if (ids === false) {
        layer.msg("请选择id",{icon:3,time:1500});
        return false;
      }
      willphp.ajaxConfirm("{:url('destroy')}?ids="+ids, '删除'+ids, 0, function () {
        table.reload('dataTable');
      });
    }

    //删除单行(操作列)
    window.destroy = function(obj){
      willphp.ajaxConfirm("{:url('destroy')}?ids="+obj.data['id'], '删除'+obj.data['id'], 0, function () {obj.del()});
    }

    //恢复单行(操作列)
    window.restore = function(obj){
      willphp.ajaxConfirm("{:url('restore')}?ids="+obj.data['id'], '恢复'+obj.data['id'], 0, function () {
        table.reload('dataTable');
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