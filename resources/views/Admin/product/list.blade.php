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
    <link rel="stylesheet" type="text/css" href="/css/patch.css">
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title>产品列表</title>
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 产品管理 <span class="c-gray en">&gt;</span> 产品列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
    <form action="/admin/product/list" method="get">
        <div class="text-c"> 所属分类：
            <select class="select-news" name="menu_id" id="menu_id">
                <option value="0">--请选择--</option>
                @foreach($menu as $v)
                <option value="{{ $v['id'] }}" @if(isset($menu_id) && $v['id'] == $menu_id) selected @endif>{{ $v['nav_name'] }}</option>
                @endforeach
            </select>
            <input type="text" class="input-text" style="width:250px" id="keyword" name="keyword" @if(isset($keyword)) value="{{ $keyword }}" @endif>
            <button type="submit" class="btn btn-success" id="" name=""><i class="Hui-iconfont">&#xe665;</i> 搜索</button>
        </div>
    </form>
    <div class="cl pd-5 bg-1 bk-gray mt-20">
        <span class="l">
            <a href="javascript:;" onclick="admin_add('添加产品','/admin/product/add','800','500')" class="btn btn-primary radius"><i class="Hui-iconfont">&#xe600;</i> 添加产品</a>
            <a href="javascript:;" onclick="batchUpdate()" class="btn btn-success radius"><i class="Hui-iconfont">&#xe642;</i> 批量更新</a>
            <a href="javascript:;" onclick="batchDel()" class="btn btn-danger radius"><i class="Hui-iconfont">&#xe6e2;</i> 批量删除</a>
        </span>
        <span class="r">共有数据：<strong id="statistics">{{ $total }}</strong> 条</span> </div>
    <form action="amdin/product/list" method="post">
        <table class="table table-border table-bordered table-bg" id="list">
            <thead>
            <tr>
                <th scope="col" colspan="9">产品列表</th>
            </tr>
            <tr class="text-c">
                <th width="25"><input type="checkbox" name="" value=""></th>
                <th width="30">排序</th>
                <th width="150">产品名称</th>
                <th width="80">所属分类</th>
                <th width="100">产品图片</th>
                <th width="100">产品PDF</th>
                <th width="60">是否显示</th>
                <th width="60">操作</th>
            </tr>
            </thead>
            <tbody id="list-item">
            @foreach($data as $v)
            <tr class="text-c">
                <td><input type="checkbox" value="{{ $v->id }}" name="ids"></td>
                <td><input style="width: 40px;text-align: center;border: 1px solid darkgray;" type="text" value="{{ $v->order_id }}" name="order_id{{ $v->id }}" id="order_id{{ $v->id }}"/> </td>
                <td>{{ $v->product_name }}</td>
                <td>{{ $v->parent->nav_name }}</td>
                <td>@if(isset($v->product_image))<img src="{{ $v->product_image }}" alt="没有图片" width="100px">@endif</td>
                <td>@if(isset($v->product_file))<a href="{{ env('APP_URL') . $v->product_file }}" target="_blank">{{ str_replace('/storage/','',$v->product_file) }}</a>@endif</td>
                <td>@if($v->is_show == 1) 显示 @else 不显示 @endif</td>
                <td class="td-manage">{{--<a style="text-decoration:none" onClick="admin_stop(this,'10001')" href="javascript:;" title="停用"><i class="Hui-iconfont">&#xe631;</i></a> --}}<a title="编辑" href="javascript:;" onclick="admin_edit('产品编辑','/admin/product/edit','{{ $v->id }}','800','500')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6df;</i></a> <a title="删除" href="javascript:;" onclick="admin_del(this,'{{ $v->id }}')" class="ml-5" style="text-decoration:none"><i class="Hui-iconfont">&#xe6e2;</i></a></td>
            </tr>
            @endforeach
            </tbody>
        </table>
    </form>
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
    /*产品-增加*/
    function admin_add(title,url,w,h){
        layer_show(title,url,w,h);
    }
    /*产品-删除*/
    function admin_del(obj,id){
        layer.confirm('确认要删除吗？',function(index){
            $.ajax({
                type: 'POST',
                url: '/admin/product/del',
                data: {
                    id: id,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function(data){
                    if (data.error !== undefined){
                        layer.msg(data.error,{icon:1,time:1000});
                    }else{
                        layer.msg('已删除!',{icon:1,time:1000});

                        function flushPage() {
                            window.location.reload();
                        }
                        setTimeout(flushPage,1000)
                    }
                },
                error:function(data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*产品-编辑*/
    function admin_edit(title,url,id,w,h){
        layer_show(title,url + '/' + id,w,h);
    }

    /*批量更新*/
    function batchUpdate() {
        layer.confirm('确认要更新吗？',function(index) {
            var ids = [];
            $("input[name='ids']").each(function (index, value) {
                if (this.checked) {
                    ids.push(this.value);
                }
            });

            //console.log(a);
            $.ajax({
                type: 'POST',
                url: '/admin/product/batchUpdate',
                data: {
                    ids: ids,
                    @foreach($data as $v)
                        order_id{{$v->id}} : $('#order_id{{ $v->id }}') . val() ,
                    @endforeach
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function (data) {
                    layer.msg('已更新!',{icon:1,time:1000});

                    function flushPage(){
                        window.location.reload();
                    }
                    setTimeout(flushPage,1000)
                },
                error: function (data) {
                    console.log(data.msg);
                },
            });
        });
    }

    /*批量删除*/
    function batchDel() {
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
                url: '/admin/product/batchDel',
                data: {
                    ids: ids,
                    _token: "{{ csrf_token() }}"
                },
                dataType: 'json',
                success: function (data) {
                    if (data.error !== undefined)  {
                        layer.msg(data.error,{icon:1,time:1000});
                    }else{
                        layer.msg('已删除!',{icon:1,time:1000});

                        function flushPage(){
                            window.location.reload();
                        }
                        setTimeout(flushPage,1000)
                    }
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