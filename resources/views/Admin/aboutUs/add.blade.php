<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <style>
        span.error {
            color:red;
        }
    </style>
    <!--[if lt IE 9]>
    <script type="text/javascript" src="/admin/lib/html5shiv.js"></script>
    <script type="text/javascript" src="/admin/lib/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui/css/H-ui.min.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/H-ui.admin.css" />
    <link rel="stylesheet" type="text/css" href="/admin/lib/Hui-iconfont/1.0.8/iconfont.css" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/skin/default/skin.css" id="skin" />
    <link rel="stylesheet" type="text/css" href="/admin/static/h-ui.admin/css/style.css" />
    <!--[if IE 6]>
    <script type="text/javascript" src="/admin/lib/DD_belatedPNG_0.0.8a-min.js" ></script>
    <script>DD_belatedPNG.fix('*');</script>
    <![endif]-->
    <title></title>
    <meta name="keywords" content="">
    <meta name="description" content="">
</head>
<body>
<article class="page-container">
    <form class="form form-horizontal" id="form-admin-add">
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>关于我们名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="nav_name" name="nav_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>位置：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="position" size="1">
				<option value="0">--头尾--</option>
				<option value="1">--头部--</option>
				<option value="2">--尾部--</option>
			</select>
			</span> </div>
        </div>
{{--        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>url优化：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="url" name="url">
            </div>
        </div>--}}
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>seo标题：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="title" name="title">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>seo关键字：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="keyword" name="keyword">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">seo描述：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="description" cols="" rows="" class="textarea" dragonfly="true"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>关于我们内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="nav_content" cols="" rows="" class="textarea" dragonfly="true"></textarea>
                <p class="textarea-numberbar"><em class="textarea-length">0</em>/100</p>
            </div>
        </div>
        <div class="row cl">
            <div class="col-xs-8 col-sm-9 col-xs-offset-4 col-sm-offset-3">
                <input class="btn btn-primary radius" type="submit" value="&nbsp;&nbsp;提交&nbsp;&nbsp;">
            </div>
        </div>
    </form>
</article>

<!--_footer 作为公共模版分离出去-->
<script type="text/javascript" src="/admin/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="/admin/lib/layer/2.4/layer.js"></script>
<script type="text/javascript" src="/admin/static/h-ui/js/H-ui.min.js"></script>
<script type="text/javascript" src="/admin/static/h-ui.admin/js/H-ui.admin.js"></script> <!--/_footer 作为公共模版分离出去-->

<!--请在下方写此页面业务相关的脚本-->
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/jquery.validate.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.validation/1.14.0/messages_zh.js"></script>
<script type="text/javascript" src="/admin/lib/jquery.form.js"></script>

<script type="text/javascript">
    $(function(){
        $('.skin-minimal input').iCheck({
            checkboxClass: 'icheckbox-blue',
            radioClass: 'iradio-blue',
            increaseArea: '20%'
        });
            $("#form-admin-add").validate({
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.appendTo(element.parent());
            },
            rules:{
                nav_name:{
                    required:true,
                    minlength:1,
                    maxlength:16
                },
                nav_image:{
                    required:true,
                },
                nav_content: {
                    required:true,
                },
            },
            messages:{
                nav_name:{
                    required: '请输入关于我们名称',
                    minlength: '关于我们名称不能少于1位',
                    maxlength: '关于我们名称不能超过16位',
                },
                nav_image:{
                    required: '必须上传图片',
                },
                nav_content: {
                    required: '内容不能为空',
                }
            },
            focusCleanup:false,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "/admin/aboutUs/add" ,
                    data: { _token:"{{ csrf_token() }}" },
                    success: function(data){
                        if (data.error !== undefined) {
                            layer.msg(data.error, {icon:1,time:1000});
                        }else{
                            layer.msg('添加成功!',{icon:1,time:1000});
                            function closeModul() {
                                parent.location.reload();
                                var index = parent.layer.getFrameIndex(window.name);
                                parent.$('.btn-refresh').click();
                                parent.layer.close(index);
                            }
                        }
                        setTimeout(closeModul,1000)
                    },
                    error: function(XmlHttpRequest, textStatus, errorThrown){
                        layer.msg('error!',{icon:1,time:1000});
                    }
                });

                /*var index = parent.layer.getFrameIndex(window.name);
                parent.$('.btn-refresh').click();
                parent.layer.close(index);*/
            }
        });
    });
</script>
<!--/请在上方写此页面业务相关的脚本-->
</body>
</html>