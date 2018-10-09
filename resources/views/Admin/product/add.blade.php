<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
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
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>产品名称：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_name" name="product_name">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red">*</span>所属分类：</label>
            <div class="formControls col-xs-8 col-sm-9"> <span class="select-box" style="width:150px;">
			<select class="select" name="menu_id" size="1">
				<option value="0">--请选择--</option>
                @foreach($menu as $v)
                    <option value="{{ $v['id'] }}">{{ $v['nav_name'] }}</option>
                @endforeach
			</select>
			</span> </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">上传图片：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="btn-upload form-group">
                    <input class="input-text upload-url radius" type="text" name="uploadfile-1" id="uploadfile-1" readonly>
                    <a href="javascript:void();" class="btn btn-primary radius">
                        <i class="icon Hui-iconfont">&#xe641;</i>浏览文件
                    </a>
                    <input type="file" multiple name="product_image" class="input-file">
                </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">上传PDF：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <span class="btn-upload form-group">
                    <input class="input-text upload-url radius" type="text" name="uploadfile-2" id="uploadfile-2" readonly >
                    <a href="javascript:void()" class="btn btn-primary radius">
                        <i class="icon Hui-iconfont">&#xe641;</i>浏览文件
                    </a>
                    <input type="file" multiple name="product_file" class="input-file">
                </span>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3">是否显示：</label>
            <div class="formControls col-xs-8 col-sm-9 skin-minimal">
                <div class="radio-box">
                    <input name="is_show" value="1" type="radio" id="is_show-1" checked>
                    <label for="sex-1">显示</label>
                </div>
                <div class="radio-box">
                    <input name="is_show" value="0" type="radio" id="is_show-1">
                    <label for="sex-2">不显示</label>
                </div>
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性1：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute1" name="product_attribute1">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性2：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute2" name="product_attribute2">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性3：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute3" name="product_attribute3">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性4：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute4" name="product_attribute4">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性5：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute5" name="product_attribute5">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性6：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute6" name="product_attribute6">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性7：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute7" name="product_attribute7">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性8：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute8" name="product_attribute8">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性9：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute9" name="product_attribute9">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>属性10：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="product_attribute10" name="product_attribute10">
            </div>
        </div>
        <div class="row cl">
            <label class="form-label col-xs-4 col-sm-3"><span class="c-red"></span>url优化：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <input type="text" class="input-text" id="url" name="url">
            </div>
        </div>
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
            <label class="form-label col-xs-4 col-sm-3">产品内容：</label>
            <div class="formControls col-xs-8 col-sm-9">
                <textarea name="product_content" cols="" rows="" class="textarea" dragonfly="true"></textarea>
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
            rules:{
                product_name:{
                    required:true,
                    minlength:1,
                    maxlength:16
                },
                menu_id:{
                    required:true,
                    min: 1,
                },
            },
            messages:{
                menu_id:{
                    min:"所属分类必填"
                }
            },
            focusCleanup:false,
            success:"valid",
            submitHandler:function(form){
                $(form).ajaxSubmit({
                    type: 'post',
                    url: "/admin/product/add" ,
                    data: { _token:"{{ csrf_token() }}" },
                    success: function(data){
                        layer.msg('添加成功!',{icon:1,time:1000});
                        function closeModul() {
                            parent.location.reload();
                            var index = parent.layer.getFrameIndex(window.name);
                            parent.$('.btn-refresh').click();
                            parent.layer.close(index);
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