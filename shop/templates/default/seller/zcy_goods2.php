<?php defined('InShopNC') or exit('Access Invalid!'); ?>
<meta name="referrer" content="no-referrer">
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.ajaxContent.pack.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/i18n/zh-CN.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/common_select.js"></script>

<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/fileupload/jquery.iframe-transport.js"
        charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/fileupload/jquery.ui.widget.js"
        charset="utf-8"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/fileupload/jquery.fileupload.js"
        charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.poshytip.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL; ?>/js/jquery.charCount.js"></script>
<!--[if lt IE 8]>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/json2.js"></script>
<![endif]-->
<script src="<?php echo SHOP_RESOURCE_SITE_URL; ?>/js/store_goods_add.step2.js"></script>
<link rel="stylesheet" type="text/css"
      href="<?php echo RESOURCE_SITE_URL; ?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"/>
<style>
    .ncsc-form-goods {
        border: solid #E6E6E6;
        border-width: 1px 1px 0 1px;
    }

    .ncsc-form-goods h3 {
        font-size: 14px;
        font-weight: 600;
        line-height: 22px;
        color: #000;
        clear: both;
        background-color: #F5F5F5;
        padding: 5px 0 5px 12px;
        border-bottom: solid 1px #E7E7E7;
    }

    .ncsc-form-goods dl {
        font-size: 0;
        *word-spacing: -1px /*IE6、7*/;
        line-height: 20px;
        clear: both;
        padding: 0;
        margin: 0;
        border-bottom: solid 1px #E6E6E6;
        overflow: hidden;
    }

    .ncsc-form-goods dl dt {
        font-size: 12px;
        line-height: 30px;
        color: #333;
        vertical-align: top;
        letter-spacing: normal;
        word-spacing: normal;
        text-align: right;
        display: inline-block;
        width: 20%;
        padding: 8px 1% 8px 0;
        margin: 0;
    }

    .spec li {
        font-size: 12px;
        vertical-align: top;
        letter-spacing: normal;
        word-spacing: normal;
        display: inline-block;
        *display: inline;
        width: 40%;
        margin-bottom: 6px;
        zoom: 1;
    }

    .ncsc-form-goods dl dd {
        font-size: 12px;
        line-height: 30px;
        vertical-align: top;
        letter-spacing: normal;
        word-spacing: normal;
        display: inline-block;
        width: 65%;
        padding: 8px 0 8px 1%;
        border-left: solid 1px #E6E6E6;
    }

    .w60 {
        width: 70% !important;
        text-align: center;
    }
    .sck_brand{
        width: 100%;
        height: 250px;
        border: 1px solid red;
        overflow: auto;
    }
    .sck_brand span{
        cursor: pointer;
        padding: 0 10px;
        width: auto;
        line-height: 30px;
        display: block;
        font-size: 15px;
        border: 1px solid green;
    }
    .sck_brand span:active{
        font-weight: bold;
    }
</style>

<form method="post" action="<?php echo urlShop('zcy_goods', 'zcy_goods3');?>">
<div class="ncsc-form-goods" id="sku">
    <input type="hidden" name="goods_id" value="<?php echo $_POST['good_id'];?>">
    <input type="hidden" name="goodsurl" value="<?php echo urlShop('goods', 'index', array('goods_id' => $_POST['good_id']));?>">
    <input type="hidden" name="categoryId" value="<?php echo $_POST['three'];?>">
    <?php foreach($output['category']['data_reponse'] as $key=>$v){?>
    <dl nc_type="spec_group_dl_0" nctype="spec_group_dl" class="spec-bg">
        <dt>
            <?php if($v['attrMetas']['isRequired'] == true){?>
            <span style="color: red;">*</span>
            <?php }?>
            <input disabled name="" type="text" class="text w60 tip2 tr" value="<?php echo $v['attrName']; ?>" nctype="spec_name">
        </dt>

        <dd>
            <ul class="spec">
                <?php if($v['attrMetas']['isUserDefined']== true){?>
                <?php if(!empty($v['attrVals'])){?>
                        <?php foreach($v['attrVals'] as $val){ ?>
                            <li>
                                <span nctype="input_checkbox">
                                    <input type="<?php echo $v['attrMetas']['multi']?'checkbox':'radio'; ?>" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrVal".']':'otherAttributes'.'['.$key.']'.'['."attrVal".']'; ?>" value="<?php echo $val;?>"/>
                                    <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrKey".']':'otherAttributes'.'['.$key.']'.'['."attrKey".']' ?>" value="<?php echo $v['attrName'];?>"/>
                                    <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."propertyId".']':'otherAttributes'.'['.$key.']'.'['."propertyId".']'; ?>" value="<?php echo $v['propertyId'];?>"/>
                                </span>
                                <span nctype="pv_name"><?php echo $val;?></span>
                            </li>
                        <?php }?>
                    <?php }else{?>
                        <li>
                        <span nctype="input_checkbox">
                            <input type="text" <?php echo $v['attrMetas']['isRequired']?"required=required":"";?> name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrVal".']':'otherAttributes'.'['.$key.']'.'['."attrVal".']'; ?>" value="">
                            <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrKey".']':'otherAttributes'.'['.$key.']'.'['."attrKey".']' ?>" value="<?php echo $v['attrName'];?>"/>
                            <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."propertyId".']':'otherAttributes'.'['.$key.']'.'['."propertyId".']'; ?>" value="<?php echo $v['propertyId'];?>"/>
                        </span>
                            <span nctype="pv_name"><?php echo $v['group']?></span>
                        </li>
                <?php }?>
                <?php }else{?>
                    <?php if(!empty($v['attrVals'])){?>
                        <?php foreach($v['attrVals'] as $val){ ?>
                            <li>
                            <span nctype="input_checkbox">
                                <input type="<?php echo $v['attrMetas']['multi']?'checkbox':'radio'; ?>" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrVal".']':'otherAttributes'.'['.$key.']'.'['."attrVal".']'; ?>" value="<?php echo $val;?>"/>
                                <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrKey".']':'otherAttributes'.'['.$key.']'.'['."attrKey".']' ?>" value="<?php echo $v['attrName'];?>"/>
                                <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."propertyId".']':'otherAttributes'.'['.$key.']'.'['."propertyId".']'; ?>" value="<?php echo $v['propertyId'];?>"/>
                            </span>
                                <span nctype="pv_name"><?php echo $val;?></span>
                            </li>
                        <?php }?>
                    <?php }else{?>


                        <input type="text" readonly value="" class="sck_brand_class" placeholder="请点击下方品牌进行选择" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrVal".']':'otherAttributes'.'['.$key.']'.'['."attrVal".']'; ?>">
                        <input type="text" placeholder="输入关键词搜索" value="" name="" class="sck_search_brand_text" style="width: 50%">
                        <input type="button" placeholder="" value="搜索" style="height: 30px;padding:0 10px;text-align: center" class="sck_search_brand_btn">
                        <div class="sck_brand">
                            <?php foreach($output['brand'] as $vv){?>
                                <span><?php echo $vv['fullName']?></span>
                            <?php }?>
                        </div>
                        <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."attrKey".']':'otherAttributes'.'['.$key.']'.'['."attrKey".']' ?>" value="<?php echo $v['attrName'];?>"/>
                        <input type="hidden" name="<?php echo $v['attrMetas']['isSkuCandidate']?'skuAttributes'.'['.$key.']'.'['."propertyId".']':'otherAttributes'.'['.$key.']'.'['."propertyId".']'; ?>" value="<?php echo $v['propertyId'];?>"/>
                    <?php }?>
                <?php }?>
            </ul>
        </dd>
    </dl>
    <?php }?>
</div>
<div class="ncsc-form-goods">
    <dl>
        <dt><i class="required">*</i><?php echo $lang['store_goods_album_goods_pic'] . $lang['nc_colon']; ?>
        </dt>
        <dd>
            <div class="ncsc-goods-default-pic">
                <div class="goodspic-uplaod">
                    <div class="upload-thumb">
                        <img nctype="goods_image" src="<?php echo thumb($output['goods'], 240); ?>"/>
                    </div>
                    <input type="hidden" name="image_path" id="image_path" value=""/>
                    <span></span>
                    <p class="hint"><?php echo $lang['store_goods_step2_description_one']; ?><?php printf($lang['store_goods_step2_description_two'], intval(C('image_max_filesize')) / 1024); ?></p>
                    <div class="handle">
                        <div class="ncsc-upload-btn">
                            <a href="javascript:void(0);">
                                <span>
                                    <input type="file" hidefocus="true" size="1" class="input-file" name="goods_image" id="goods_image">
                                </span>
                            </a>
                        </div>
                        <a class="ncsc-btn mt5" nctype="show_image" href="<?php echo urlShop('store_album', 'zcy_pic_list', array('item' => 'goods')); ?>"><i class="icon-picture"></i>从图片空间选择</a>
                        <a href="javascript:void(0);" nctype="del_goods_demo" class="ncsc-btn mt5" style="display: none;"><i class="icon-circle-arrow-up"></i>关闭相册</a>
                    </div>
                </div>
            </div>
            <div id="demo"></div>
        </dd>
    </dl>

    <dl>
        <dt><i class="required">*</i>商品附图</dt>
        <dd>
            <?php if (!empty($output['imgdata'])) { ?>
                <style type="text/css">

                    .flex-container {
                        display: -webkit-flex;
                        display: flex;
                        width: 100%;
                        /*background-color: lightgrey;*/
                        flex-wrap: wrap;
                        margin: 0 auto;
                    }

                    .flex-item {
                        /*background-color: cornflowerblue;*/
                        width: 100px;
                        height: 100px;
                        margin: 10px;
                        /*border: 1px solid grey;*/
                    }

                    .click {
                        position: relative;
                    }

                    .shang {
                        position: absolute;
                        /*top: 100px;*/
                        /*left: 70px;*/
                        left: 0;
                        top: 0;
                        font-size: 20px;
                        font-weight: bold;
                        border: 1px solid black;
                        border-radius: 10px;
                        width: 100%;
                        height: 100%;
                        color: white;
                        text-align: center;
                        line-height: 180px;
                        background-color: rgba(0, 0, 0, 0.3);
                    }

                    @import url("<?php echo SHOP_TEMPLATES_URL; ?>/css/zcy.css");
                </style>

                <div id="content" style="height: 100%; overflow: auto">
                    <ul class="flex-container">
                        <?php foreach ($output['imgdata'] as $v) { ?>
                            <li class="flex-item click">
                                <input type="checkbox" class="input" name="images[]"
                                       value="https://zcy-gov-item.oss-cn-north-2-gov-1.aliyuncs.com/<?php echo $v['fileid']; ?>">
                                <img src="https://zcy-gov-item.oss-cn-north-2-gov-1.aliyuncs.com/<?php echo $v['fileid']; ?>"
                                     alt="" width="100%" height="100%">
                            </li>
                        <?php } ?>
                    </ul>

                    <tr>
                        <td colspan="20">
                            <div class="pagination"> <?php echo $output['show_page'] ?> </div>
                        </td>
                    </tr>

                </div>
                <script>
                    function count_radio() {
                        var len = $('.input:checked').length;
                        // console.log(len)
                        return len;
                    }

                    $(".click").click(function () {
                        if ($(this).find("input").attr("checked") == 'checked') {
                            $(this).find("input").removeAttr("checked");
                        } else {
                            $(this).find("input").attr("checked", "checked");
                        }
                        var len = count_radio();
                        console.log(len)
                        if (len > 4) {
                            alert('最多选择四张附图!')
                            $(this).find("input").removeAttr("checked");
                            return false;
                        }

                    })

                    // $('.all').click(function () {
                    //     if($(this).attr("checked") == 'checked'){
                    //         $('.input').attr("checked", "checked");
                    //     }else{
                    //         $('.input').removeAttr("checked");
                    //     }
                    // })

                    $('#open_uploaders').click(function () {
                        var test_list = [];
                        $('input:checkbox:checked').each(function () {
                            test_list.push($(this).val())
                        })
                        // var test_str = JSON.stringify(test_list );
                        if (test_list == null || test_list == [] || test_list == "") {
                            alert('请选择图片后上传')
                        } else {
                            $.ajax({
                                url: "/shop/index.php?act=zcy_image&op=upgoods",
                                type: "POST",
                                dataType: "JSON",
                                data: {path: test_list},
                                success: function (res) {
                                    if (res.code == 1) {
                                        location.reload();
                                    } else {
                                        alert(res.msg)
                                    }
                                },
                                error: function (e) {
                                    console.log(e);
                                }
                            })
                        }

                    })

                </script>
            <?php } ?>
            <div id="demo"></div>
        </dd>
    </dl>
    <dl>
        <dt><?php echo $lang['store_goods_index_goods_desc'] . $lang['nc_colon']; ?></dt>
        <dd id="ncProductDetails">
            <div class="tabs">
                <ul class="ui-tabs-nav" jquery1239647486215="2">
                    <li class="ui-tabs-selected"><a href="#panel-1" jquery1239647486215="8"><i
                                    class="icon-desktop"></i> 电脑端</a></li>
                    <li class="selected"><a href="#panel-2" jquery1239647486215="9"><i
                                    class="icon-mobile-phone"></i>手机端</a></li>
                </ul>
                <div id="panel-1" class="ui-tabs-panel" jquery1239647486215="4">
                    <?php showEditor('goods_body', $output['goods']['goods_body'], '100%', '480px', 'visibility:hidden;', "false", $output['editor_multimedia']); ?>
                    <div class="hr8">
                        <div class="ncsc-upload-btn"><a href="javascript:void(0);"><span>
                                            <input type="file" hidefocus="true" size="1" class="input-file"
                                                   id="add_album" multiple="multiple">
                                        </span>
                                <!--                                            <p><i class="icon-upload-alt" data_type="0" nctype="add_album_i"></i>图片上传</p>-->
                            </a></div>
                        <a class="ncsc-btn mt5" nctype="show_desc"
                           href="index.php?act=store_album&op=zcy_pic_list&item=des"><i
                                    class="icon-picture"></i><?php echo $lang['store_goods_album_insert_users_photo']; ?>
                        </a> <a href="javascript:void(0);" nctype="del_desc" class="ncsc-btn mt5"
                                style="display: none;"><i class=" icon-circle-arrow-up"></i>关闭相册</a></div>
                    <p id="des_demo"></p>
                </div>
                <div id="panel-2" class="ui-tabs-panel ui-tabs-hide" jquery1239647486215="5">
                    <div class="ncsc-mobile-editor">
                        <div class="pannel">
                            <div class="size-tip"><span nctype="img_count_tip">图片总数得超过<em>20</em>张</span><i>|</i><span
                                        nctype="txt_count_tip">文字不得超过<em>5000</em>字</span></div>
                            <div class="control-panel" nctype="mobile_pannel">
                                <?php if (!empty($output['goods']['mb_body'])) { ?>
                                    <?php foreach ($output['goods']['mb_body'] as $val) { ?>
                                        <?php if ($val['type'] == 'text') { ?>
                                            <div class="module m-text">
                                                <div class="tools"><a nctype="mp_up"
                                                                      href="javascript:void(0);">上移</a><a
                                                            nctype="mp_down"
                                                            href="javascript:void(0);">下移</a><a
                                                            nctype="mp_edit"
                                                            href="javascript:void(0);">编辑</a><a
                                                            nctype="mp_del"
                                                            href="javascript:void(0);">删除</a></div>
                                                <div class="content">
                                                    <div class="text-div"><?php echo $val['value']; ?></div>
                                                </div>
                                                <div class="cover"></div>
                                            </div>
                                        <?php } ?>
                                        <?php if ($val['type'] == 'image') { ?>
                                            <div class="module m-image">
                                                <div class="tools"><a nctype="mp_up"
                                                                      href="javascript:void(0);">上移</a><a
                                                            nctype="mp_down"
                                                            href="javascript:void(0);">下移</a><a
                                                            nctype="mp_rpl"
                                                            href="javascript:void(0);">替换</a><a
                                                            nctype="mp_del"
                                                            href="javascript:void(0);">删除</a></div>
                                                <div class="content">
                                                    <div class="image-div"><img
                                                                src="<?php echo $val['value']; ?>"></div>
                                                </div>
                                                <div class="cover"></div>
                                            </div>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            </div>
                            <div class="add-btn">
                                <ul class="btn-wrap">
                                    <li><a href="javascript:void(0);" nctype="mb_add_img"><i
                                                    class="icon-picture"></i>
                                            <p>图片</p>
                                        </a></li>
                                    <li><a href="javascript:void(0);" nctype="mb_add_txt"><i
                                                    class="icon-font"></i>
                                            <p>文字</p>
                                        </a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="explain">
                            <dl>
                                <dt>1、基本要求：</dt>
                                <dd>（1）手机详情总体大小：图片+文字，图片不超过20张，文字不超过5000字；</dd>
                                <dd>建议：所有图片都是本宝贝相关的图片。</dd>
                            </dl>
                            <dl>
                                <dt>2、图片大小要求：</dt>
                                <dd>（1）建议使用宽度480 ~ 620像素、高度小于等于960像素的图片；</dd>
                                <dd>（2）格式为：JPG\JEPG\GIF\PNG；</dd>
                                <dd>举例：可以上传一张宽度为480，高度为960像素，格式为JPG的图片。</dd>
                            </dl>
                            <dl>
                                <dt>3、文字要求：</dt>
                                <dd>（1）每次插入文字不能超过500个字，标点、特殊字符按照一个字计算；</dd>
                                <dd>（2）请手动输入文字，不要复制粘贴网页上的文字，防止出现乱码；</dd>
                                <dd>（3）以下特殊字符“<”、“>”、“"”、“'”、“\”会被替换为空。</dd>
                                <dd>建议：不要添加太多的文字，这样看起来更清晰。</dd>
                            </dl>
                        </div>
                    </div>
                    <div class="ncsc-mobile-edit-area" nctype="mobile_editor_area">
                        <div nctype="mea_img" class="ncsc-mea-img" style="display: none;"></div>
                        <div class="ncsc-mea-text" nctype="mea_txt" style="display: none;">
                            <p id="meat_content_count" class="text-tip"></p>
                            <textarea class="textarea valid" nctype="meat_content"></textarea>
                            <div class="button"><a class="ncsc-btn ncsc-btn-blue" nctype="meat_submit"
                                                   href="javascript:void(0);">确认</a><a class="ncsc-btn ml10"
                                                                                       nctype="meat_cancel"
                                                                                       href="javascript:void(0);">取消</a>
                            </div>
                            <a class="text-close" nctype="meat_cancel" href="javascript:void(0);">X</a>
                        </div>
                    </div>
                    <input autocomplete="off" type="hidden"
                           value='<?php echo $output['goods']['mobile_body']; ?>'>
                </div>
            </div>
        </dd>
    </dl>
    <dl>
        <dt>产地：</dt>
        <dd>
                        <span class="mr50">
                            <label>省</label>
                            <select name="provinceId" id="provinceId">
                                <option>请选择</option>
                            </select>
                        </span>

            <span class="mr50">
                            <label>市</label>
                            <select name="cityId" id="cityId">
                                <option>请选择</option>
                            </select>
                        </span>
            <span class="mr50">
                            <label>区</label>
                            <select name="regionId" id="regionId">
                                <option>请选择</option>
                            </select>
                        </span>
        </dd>
    </dl>
</div>
    <div class="bottom tc hr32">
        <label class="submit-border">
            <input type="submit" class="submit" value="下一步">
        </label>
    </div>
</form>
<script src="<?php echo RESOURCE_SITE_URL; ?>/js/address.js"></script>
<script>
    $(function () {
        //电脑端手机端tab切换
        $(".tabs").tabs();
        var html = "";
        $.each(pdata, function (idx, item) {
            // console.log(item);
            if (parseInt(item.level) == 0) {
                html += "<option value=" + item.code + ">" + item.names + "</option>"
            }
        });
        $("#provinceId").append(html);

        $("#provinceId").change(function () {
            if ($('#provinceId').val() == "") return;
            html = "";
            $("#cityId").html('<option>--请选择--</option>');
            $("#regionId").html('<option>--请选择--</option>');
            var code = $('#provinceId').val();
            code = code.substring(0, 2);
            $.each(pdata, function (idx, item) {
                if (parseInt(item.level) == 1 && code == item.code.substring(0, 2)) {
                    html += "<option value=" + item.code + ">" + item.names + "</option>";
                }
            });
            $("#cityId").append(html);
        });

        $("#cityId").change(function () {
            if ($('#cityId').val() == "") return;
            html = "";
            $("#regionId").html('<option>--请选择--</option>');
            var code = $('#cityId').val();
            code = code.substring(0, 4);
            $.each(pdata, function (idx, item) {
                if (parseInt(item.level) == 2 && code == item.code.substring(0, 4)) {
                    html += "<option value=" + item.code + ">" + item.names + "</option>";
                }
            });
            $("#regionId").append(html);
        });
    });
</script>

<script>
    $('.sck_search_brand_text').bind('input propertychange', function() {
        searchProductClassbyName();
    });
    $('.sck_search_brand_btn').click(function() {
        searchProductClassbyName();
    });
    function searchProductClassbyName() {
        var keywords = $('.sck_search_brand_text').val()
        var htmls ='';
        $.ajax({
            url:"/shop/index.res?act=zcy_config&op=get_brand_myself",
            data:{keywords:keywords},
            type:'post',
            dataType: "json",
            beforeSend: function () {
                $('#dataLoading').show();
            },
            complete: function () {
                $('#dataLoading').hide();
            },
            success:function(res) {
                if(res.code == 0){
                    htmls = '<p style="text-align: center;line-height: 40px;font-size: 20px;">暂无匹配数据</p>';
                }else{
                    $.each(res.data,function (k,v) {
                        htmls+='<span>'+v.fullName+'</span>';
                    })
                }

                $('.sck_brand').html(htmls)
            }
        })

    }
    $(document).on('click','.sck_brand span',function () {
        var str = $(this).text()
        $('.sck_brand_class').removeAttr('readonly')
        $('.sck_brand_class').attr('value',str)
        $('.sck_brand_class').attr('readonly','readonly')

    })
</script>