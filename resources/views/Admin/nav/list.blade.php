<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="Bookmark" href="/favicon.ico" >
    <link rel="Shortcut Icon" href="/favicon.ico" />
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <link rel="stylesheet" type="text/css" href="/css/page.css">
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>导航列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 导航管理 <span class="c-gray en">&gt;</span> 导航列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <div class="text-c"> 所属分类：
        <select name="parentId" id="parentId">
            <option value="0">--请选择--</option>
            @foreach($menu as $v)
            <option value="{{ $v['id'] }}">{{ $v['nav_name'] }}</option>
            @endforeach
        </select>
        <input type="text" class="input-text" style="width:250px" placeholder="输入导航名称" id="keyword" name="keyword">
        <button type="submit" class="btn btn-success" id="" name="" onclick="search()"><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
    </div>
    <div class="cl pd-5 bg-1 bk-gray mt-20"> <span class="l"><a href="javascript:;" onclick="datadel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a> <a href="javascript:;" onclick="admin_add('添加导航','/admin/nav/add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加导航</a></span> <span class="r">共有数据：<strong id="statistics">{{ $total }}</strong> 条</span> </div>
    <table class="table table-border table-bordered table-bg" id="list">
        <thead>
        <tr>
            <th scope="col" colspan="9">导航列表</th>
        </tr>
        <tr class="text-c">
            <th width="25"><input type="checkbox" name="" value=""></th>
            <th width="40">ID</th>
            <th width="150">导航名称</th>
            <th width="150">所属分类</th>
            <th width="90">url</th>
            <th width="150">所在位置</th>
            <th width="100">操作</th>
        </tr>
        </thead>
        <tbody id="list-item">
        @foreach($data as $v)
        <tr class="text-c">
            <td><input type="checkbox" value="{{ $v->id }}" name="ids"></td>
            <td>{{ $v->id }}</td>
            <td>{{ $v->nav_name }}</td>
            <td>@if(!empty($v->parent->nav_name)) {{ $v->parent->nav_name }} @else 顶级分类 @endif</td>
            <td>{{ $v->url }}</td>
            <td>@if($v->position == 0)头尾@elseif($v->position == 1)头部@elseif($v->position == 2)尾部@endif</td>
            <td class="td-manage">{{--<a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> --}}<a title="编辑" href="javascript:;" onclick="admin_edit('导航编辑','/admin/nav/edit','{{ $v->id }}','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{ $v->id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
        </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
</div>
<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/My97DatePicker/4.8/WdatePicker.js"></script>
<script type="text/javascript" src="/admin/lib/datatables/1.10.0/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="/admin/lib/laypage/1.2/laypage.js"></script>
<script type="text/javascript">
    /*
        参数解释：
        title	标题
        url		请求的url
        id		需要操作的数据id
        w		弹出层宽度（缺省调默认值）
        h		弹出层高度（缺省调默认值）
    */
    /*导航-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*导航-删除*/
    function admin_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/nav/del',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data){
                    $(obj).parents("tr").remove();
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*导航-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url + '/' + id,w,h);
    }
    /*导航-停用*/
    /*function admin_stop(obj,id){
        layer.confirm('确认要停用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……

            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_start(this,id)" href="javascript:;" title="启用" style="text-decoration:none"><i class="Hui-iconfont">&#xe615;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-default radius">已禁用</span>');
            $(obj).remove();
            layer.msg('已停用!',{icon: 5,time:1000});
        });
    }

    导航-启用*/
    /*function admin_start(obj,id){
        layer.confirm('确认要启用吗？',function(index){
            //此处请求后台程序，下方是成功后的前台处理……


            $(obj).parents("tr").find(".td-manage").prepend('<a onClick="admin_stop(this,id)" href="javascript:;" title="停用" style="text-decoration:none"><i class="Hui-iconfont">&#xe631;</i></a>');
            $(obj).parents("tr").find(".td-status").html('<span class="label label-success radius">已启用</span>');
            $(obj).remove();
            layer.msg('已启用!', {icon: 6,time:1000});
        });
    }*/

    /*搜索事件*/
    function search() {
        var parentId = $('#parentId') . val();
        var keyword = $('#keyword') . val();
        $.ajax({
            type: 'get',
            url: '/admin/nav/index',
            data: {
                parentId: parentId,
                keyword: keyword,
                _token: "{{ csrf_token() }}"
            },
            dataType: 'json',
            success: function(info){
                //console.log(info);
                $('#list-item') . empty();
                $('#statistics') . empty();
                var data = info.data;
                var total = info.paginate;
                $('#statistics') . append(total);

                var str = '';

                str += '<tr class="text-c">' +
                    '<td><input type="checkbox" value="' + data.id + '" name="ids"></td>' +
                    '<td>' + data.id + '</td>' +
                    '<td>' + data.nav_name + '</td>' +
                    '<td>顶级分类</td>' +
                    '<td>' + data.url + '</td>' +
                    '<td>'+ data.position +'</td>' +
                    '<td class="td-manage">{{--<a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> --}}<a title="编辑" href="javascript:;" onclick="admin_edit(\'导航编辑\',\'/admin/nav/edit\','+ data.id +',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'+ data.id +')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>' +
                    '</tr>';

                for(var i = 0; i < data.children.length; i++) {
                    if (data.children[i].position === 0) {
                        data.children[i].position = '头尾';
                    }else if(data.children[i].position === 1) {
                        data.children[i].position = '头部';
                    }else if(data.children[i].position == 2) {
                        data.children[i].position = '尾部';
                    }
                    str += '<tr class="text-c">' +
                        '<td><input type="checkbox" value="' + data.children[i].id + '" name="ids"></td>' +
                        '<td>' + data.children[i].id + '</td>' +
                        '<td>' + data.children[i].nav_name + '</td>' +
                        '<td>' + data.nav_name + '</td>' +
                        '<td>' + data.children[i].url + '</td>' +
                        '<td>'+ data.children[i].position +'</td>' +
                        '<td class="td-manage">{{--<a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> --}}<a title="编辑" href="javascript:;" onclick="admin_edit(\'导航编辑\',\'/admin/nav/edit\','+ data.children[i].id +',\'800\',\'500\')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'+ data.children[i].id +')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>' +
                    '</tr>';
                }
                $('#list-item') .append(str);
            },
            error:function(info) {
                console.log(info);
            },
        });
    }

    /*批量删除*/
    function datadel() {
        layer.confirm('确认要删除吗？',function(index) {
            var ids = [];
            $("input[name='ids']").each(function (index, value) {
                if (this.checked) {
                    ids.push(this.value);
                }
            });

            //console.log(a);
            $.ajax({
                type: 'POST',
                url: '/admin/nav/batchDel',
                data: {
                    ids: ids,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function (data) {
                    layer.msg('已删除!',{icon:1,time:1000});
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }
</script>
</body>
</html>