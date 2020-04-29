<div class="alert alert-block hr32">

    <?php if($output['code'] == 1){?>
    <h1>添加商品成功</h1>
    <div class="hr16">
        <a href="<?php echo urlShop('seller_center', 'index');?>">返回首页</a>
        <a href="<?php echo urlShop('zcy_goods', 'index',array('type'=>'zcy_addgoods'));?>">继续添加商品</a>
    </div>
    <?php }else{?>
        <h1>添加商品失败</h1>
        <span><?php echo $output['msg']?></span>
        <div class="hr16">
            <a href="<?php echo urlShop('seller_center', 'index');?>">返回首页</a>
            <a href="<?php echo urlShop('zcy_goods', 'index',array('type'=>'zcy_addgoods'));?>">重新添加商品</a>
        </div>
    <?php }?>
</div>