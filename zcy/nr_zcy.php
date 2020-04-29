<?php
/*
 *	政采云对接
 *
 *
 */
class nr_zcy {
	private $appKey = null;
	private $appSecret = null;
//	private $gate_way = "http://api.zcygov.cn/";//http://121.196.217.18:9002/测试   http://api.zcygov.cn/
	private $gate_way = "http://sandbox.zcygov.cn/";//http://121.196.217.18:9002/测试   http://api.zcygov.cn/
    public function __construct()
    {
        $session = $_SESSION['zcy_user_config'];
//        $this->appKey = $session['appkey'];
//        $this->appSecret = $session['appsecret'];
        $this->appKey = '721278';
        $this->appSecret = '1iTzAYkS0q4k';
    }

    /*
     *查询后台类目
     *参数名 		说明 	必填 	类型 		长度 	备注
     *root 		类目ID 		必选 	number 				【0-2^32-1】虚拟根节点ID=0；返回以root指定的类目节点为根的类目树
     *depth 	类目树深度 	必须 	number 				【1-4】
     */
	public function get_category($root,$depth){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.mall.category.get";//必须以/开头
		$strs=array();
		$strs['_data_']["root"]=$root;
		$strs['_data_']["depth"]=$depth;
		$strs['_data_']=json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
//		return json_decode($str,true);
        return $str;
	}

/*
 *查询类目属性
 *参数名 			说明 		必填 	类型 		长度 	备注
 *categoryId 	类目ID 		必填 	number 		【1 - 2^64-1】
 */
	public function get_category_attrs($categoryId){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.mall.category.attrs.get";//必须以/开头
		$strs=array();
		$strs['_data_']["categoryId"]=$categoryId;
		$strs['_data_']=json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);
	}

/*
 *查询SPU
 *参数名 			说明 		必填 	类型 		长度 		备注
 *categoryId 	类目ID 		是 		number 		64位 	
 *keyAttrs 		关键属性名称 	是 		String 		<=32个字符 	必须按照“品牌:xx;型号:xx”格式搜索
 *pageNum 		当前页 		否 		number 		32位 		默认为1 	
 *pageSize 		每页大小 		否 		number 		32位 		默认为20
 */
	public function get_SPU($categoryId,$keyAttrs,$pageNum,$pageSize){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.mall.item.spu.page";//必须以/开头
		$strs=array();
		$strs['_data_']["categoryId"]=$categoryId;
		$strs['_data_']["keyAttrs"]=$keyAttrs;
		$strs['_data_']["pageNum"]=$pageNum;
		$strs['_data_']["pageSize"]=$pageSize;
		$strs['_data_']=json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);
	}

/**
 *获取已审核品牌列表
 *参数名 				说明 					必填 	类型 	长度 	备注
 *beginModifiedDate 品牌更新时间，查询起始时间 	否 		数字 	- 		参数说明，时间戳，例如：1530795920000
 *endModifiedDate 	品牌更新时间，查询结束时间 	否 		数字 	- 		参数说明，时间戳，例如：1539799920000
 *categoryId 		品牌所适用的类目ID 			否 		数字 	- 		参数说明，例如： 1234
 *pageNo 			起始页 					否 		数字 	- 		默认 1
 *pageSize 			页面大小 					否 		数字 	- 		默认 20， 最大 100
 */
	public function query_brand($categoryId,$pageSize,$pageNo,$beginModifiedDate,$endModifiedDate){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/supplier/zcy.item.brand.query";//必须以/开头
		$strs=array();
		if($categoryId != ''){
			$strs['_data_']["categoryId"] = $categoryId;
		}
		if($pageSize != ''){
			$strs['_data_']["pageSize"] = $pageSize;
		}
		if($pageNo != ''){
			$strs['_data_']["pageNo"] = $pageNo;
		}
		if($beginModifiedDate != ''){
			$strs['_data_']["beginModifiedDate"] = $beginModifiedDate;
		}
		if($endModifiedDate != ''){
			$strs['_data_']["endModifiedDate"] = $endModifiedDate;
		}
		$strs['_data_'] = json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);
	}


/**
 *创建商品
 *参数名 							说明 			必填 	类型 		长度 			备注
 *otherAttributes 				其他属性信息 		必填 	array 						包括关键属性、绑定属性、商品属性
 * └otherAttributes.attrVal 	属性值 			必填 	string 		<=64个字符 	
 * └otherAttributes.attrKey 	属性名 			可选 	string 		<=20个字符 		【propertyId和attrKey两者选其一，propertyId优先】，如果属性名为品牌或者型号这个为必填
 * └otherAttributes.propertyId 	属性ID 			可选 	number 		1 ~ 2^64-1 		【propertyId和attrKey两者选其一，propertyId优先】
 *layer 						商品来源			否 		整形 		32 				默认值为11，11代表普通网超，21代表企采网超（企业购）
 *skus 							sku信息 			必填 	array 		
 * └skus.price 					商品单价 			必填 	number 		0 ~ 2^32-1 		单位：分
 * └skus.attrs 					属性 			必选 	object 		<=512个字符 即使该结构里面键值对为空，仍然需要该结构json对象，键：销售属性名称；值：销售属性值；
 * └skus.platformPrice 			平台价 			必填 	number 		1 ~ 2^32-1 		单位：分
 * └skus.quantity 				数量 			必选 	number 		0 ~ 2^32-1 		库存数量
 * └skus.skuCode 				外部SKU编号 		必填 	string 		<=80个字符 		这个作为主键，做政采云sku与供应商sku做关联
 *skuAttributes 				销售属性信息 		可选 	array 		
 * └skuAttributes.attrVal 		属性值 			必填 	string 		<=64个字符 	
 * └skuAttributes.attrKey 		属性名 			必填 	string 		<=20个字符 	
 *item 							商品信息 			必填 	object 		
 * └item.limit 					境内或境外 		必填 	number 		2个字符 			0：境内；1：境外
 * └item.selfPlatformLink 		自营平台链接 		必填 	string 		<=1024个字符 	
 * └item.itemCode 				外部商品编号 		必填 	string 		<=80个字符 		这个作为主键，做政采云商品与供应商商品做关联
 * └item.mainImage 				主图 			必填 	string 		<=128个字符 		1.只能传入的一张图片，如果要传入多个轮播图请放入itemDetail.images字段中;2.商品图片只能使用政采云的商品图片链接，必须要先调用图片上传接口把商品上传至oss，生成“https://zcy-gov-item.oss-cn-north-2-gov-1.aliyuncs.com/“域名开头的图片链接才可以上传成功，否则会报item.mainimage.not.valid错误
 * └item.origin 				产地 			必填 	string 		<=80个字符 		格式：XX省XX市XX区；XX省XX市XX市；XX省XX市XX县；XX市 XX区；XX市XX县；origin和（产地国家ID，产地省ID，产地城市ID，产地区ID）两种方式二选一即可
 * └item.countryId 				产地国家ID 		是 		字符串 		10 				可以通过文档地址编码 获取
 * └item.provinceId 			产地省ID 		是 		字符串 		10 				可以通过文档地址编码 获取
 * └item.cityId 				产地城市ID 		是 		字符串 		10 				可以通过文档地址编码获取
 * └item.regionId 				产地区ID 		是 		字符串 		10 				可以通过文档地址编码 获取
 * └item.name 					商品名称 		必填 		string 		<=200个字符 	
 * └item.categoryId 			后台类目ID 		必填 		number 		1 ~ 2^64-1 	
 *itemDetail 					商品详细信息 		必填	 object 		
 * └itemDetail.detail 			富文本 		必填 		string 		<=2048个字符 	
 * └itemDetail.images 			轮播图 		必填 		array 		每张图<=1000个字符1.该图片为商品主图轮播图，至少要传入一张，最多传入四张，两张图片链接之间用逗号隔开；2.商品图片只能使用政采云的商品图片链接，必须要先调用图片上传接口把商品上传至oss，生成“https://zcy-gov-item.oss-cn-north-2-gov-1.aliyuncs.com/“域名开头的图片链接才可以上传成功，否则会报item.mainimage.not.valid错误
 */
	public function create_goods($goods_info){	//$goods_info需包含以上参数
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.mall.item.create";//必须以/开头
		$strs=array();
		$strs['_data_'] = $goods_info;
		$strs['_data_'] = json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);	
	}

/**
 *查询商品列表
 *参数名 		说明 		必填 类型 	长度 	备注
 *status 	商品状态 		是 	int 	int(1) 	1:上架,-1:下架,-2:冻结,2:待审核,-4:审核不通过 	
 *pageNo 	起始页码	 	否 	整形 	32 		从1开始, 默认为1
 *pageSize 	每页返回条数 	否 	整形 	32 		默认为20, 最大为20
 *layer 	商品来源	 	否 	整形 	32 		默认值为11，11代表普通网超，21代表企采网超（企业购）
 */
	public function goods_list($status,$pageNo,$pageSize,$layer){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.item.list.bystatus";//必须以/开头
		$strs=array();
		$strs['_data_']["status"] = $status;
		$strs['_data_']["pageSize"] = $pageSize;
		$strs['_data_']["pageNo"] = $pageNo;
		$strs['_data_']["layer"] = $layer;
		$strs['_data_'] = json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);
	}

/**
 *查询商品库存
 *参数名	 	说明 		必填 	类型 	长度 		备注
 *itemCode 	商品外部编号 	是 		number 	1 ~ 2^64-1 	
 *skuCode 	sku外部编号 	否 		number 	1 ~ 2^64-1 	如果该字段不填写默认该Item下面所有的sku库存业购）
 */
	public function get_goods_stock($itemId,$skuCode){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.item.stock.get";//必须以/开头
		$strs=array();
		$strs['_data_']["itemId"] = $itemId;
		$strs['_data_']["skuCode"] = $skuCode;
		$strs['_data_'] = json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);	
	}

/**
 *查询商品详情
 *参数名	 	说明 		必填 	类型 	长度 		备注
 *temCode 	外部商品编码 	是 		String 	32 			商品外部编码
 */
	public function get_goods_detail($itemCode,$itemId){
		require_once('ZcyOpenClient.php');
		error_reporting(E_ERROR | E_WARNING | E_PARSE);
		$uri = "/open/zcy.item.detail.get";//必须以/开头
		$strs=array();
		$strs['_data_']["itemCode"] = $itemCode;
		$strs['_data_']["itemId"] = $itemId;
		$strs['_data_'] = json_encode($strs['_data_']);
		$p= new ZcyOpenClient();
		$str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
		return json_decode($str,true);	
	}

    /**
     * 参数名	说明	必填	类型	长度	备注
    *fields	字段列表	可选	array		【默认为order】需要返回的字段列表，多个字段用半角逗号分隔；可选值：delivery:收货信息；invoice:发票信息；order:订单基本信息；returnOrder:退换货信息；orderItems:订单商品信息
    *orderCodes	订单外部编码列表	可选	array	<=80个字符	【orderIds优先】
    *statuses	订单状态列表	可选	array		0：待接单；1：已接单待发货；2：已部分发货待确认；3：全部发货,待确认收货；4：已确认收货,待验收；5：已验收待结算；6：启动结算；7：交易完成；-4：采购人申请取消订单；10：退换货中； -2：供应商拒绝接单；-5： 供应商同意取消订单；-6：全部退货、订单关闭
    *orderIds	订单ID列表	可选	array	1 ~ 2^64-1
    *pageSize	每页大小	可选	number	1 ~ 10	默认为5
    *pageNo	当前页	可选	number	1 ~ 2^32-1	默认为1
     * @param $itemCode
     * @param $itemId
     * @return mixed
     */
    public function order_list($status,$orderId,$pageNo,$pageSize){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.trade.orders.find";//必须以/开头
        $strs=array();
        $strs['_data_']["fields"] = ['orderItems','order','delivery','invoice','returnOrder'];
        $strs['_data_']["statuses"][] = $status;
        $strs['_data_']["orderIds"] = $orderId?$orderId:null;
        $strs['_data_']["pageSize"] = $pageSize;
        $strs['_data_']["pageNo"] = $pageNo;
        $strs['_data_'] = json_encode($strs['_data_']);
//        echo '<pre>';
//        var_dump($strs);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true,512,JSON_BIGINT_AS_STRING);
//        echo '<pre>';
//        var_dump($str);
        if(!empty($str["data_response"]["data"])){
            foreach ($str["data_response"]["data"] as $k=>$v){
                $str["data_response"]["data"][$k]['order']['createdAt'] = number_format($str["data_response"]["data"][$k]['order']['createdAt'].'',0,'','');
//                $str["data_response"]["data"][$k]['order']['id'] = number_format($str["data_response"]["data"][$k]['order']['id'].'',0,'','');
                $Y = substr($str["data_response"]["data"][$k]['order']['createdAt'],0,4);
                $m = substr($str["data_response"]["data"][$k]['order']['createdAt'],4,2);
                $d = substr($str["data_response"]["data"][$k]['order']['createdAt'],6,2);
                $H = substr($str["data_response"]["data"][$k]['order']['createdAt'],8,2);
                $i = substr($str["data_response"]["data"][$k]['order']['createdAt'],10,2);
                $str["data_response"]["data"][$k]['order']['create_time'] = $Y.'-'.$m.'-'.$d.' '.$H.':'.$i;
                $str["data_response"]["data"][$k]['order']['fee'] = round(floor($str["data_response"]["data"][$k]['order']['fee'])/100,2);
            }
        }

        return $str;
    }

    /**
     * 接受订单
     * 参数名	说明	必填	类型	长度	备注
    *orderId	订单ID	可选	number	1 ~ 2^64-1	【orderId和orderCode两者选其一，orderId优先】
    *orderCode	外部订单编号	可选	string	<=80个字符	【orderId和orderCode两者选其一，orderId优先】
     * @param $orderId
     * @return bool|mixed|string|null
     */
    public function take_order($orderId){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.order.receive";//必须以/开头
        $strs=array();
        $strs['_data_']["orderId"] = $orderId;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 拒绝订单
     * 参数名	说明	必填	类型	长度	备注
    *orderId	订单ID	可选	number	1 ~ 2^64-1	【orderId和orderCode两者选其一，orderId优先】
    *comment	拒单理由	必填	string	<=120个字符
    *orderCode	外部订单编号	可选	string	<=80个字符	【orderId和orderCode两者选其一，orderId优先】
     */
    public function refuse_order($orderId,$comment){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.order.reject";//必须以/开头
        $strs=array();
        $strs['_data_']["orderId"] = $orderId;
        $strs['_data_']["comment"] = $comment;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }

    /**
     * 订单发货
     * 参数名	说明	必填	类型	长度	备注
    *skus	发货sku商品	必填	array
    *└quantity	发货数量	必填	number	1 ~ 2^32-1
    *└skuId	  skuID	可选	number	1 ~ 2^64-1	【skuId和skuCode两者选填一个，优先skuId】
    *└skuCode	外部SKU编码	可选	string	<=80个字符	【skuId和skuCode两者选填一个，优先skuId】
    *shipmentType	发货方式	必填	number		1：物流发货；2：送货上门
    *shipmentNo	物流单号	必填	number	<=32个字符
    *expressCode	发货物流公司代码	可选	string	<=32个字符	【发货方式为物流发货时，必填】
    *orderId	订单ID	可选	number	1 ~ 2^64-1	【orderId和orderCode两者选其一，orderId优先】
    *shipmentCode	外部发货单号	可选	string	<=64个字符
    *orderCode	外部订单编号	可选	string	<=80个字符	【orderId和orderCode两者选其一，orderId优先】
     */
    public function send_order($skus,$shipmentType,$shipmentNo,$expressCode,$orderId){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.order.shipment.create";//必须以/开头
        $strs=array();
        $strs['_data_']["skus"][] = $skus;
//        $strs['_data_']["skus"]['quantity'] = $quantity;
//        $strs['_data_']["skus"]['skuId'] = $skuId;
        $strs['_data_']["shipmentType"] = $shipmentType;
        $strs['_data_']["shipmentNo"] = $shipmentNo;
        $strs['_data_']["expressCode"] = $expressCode;
        $strs['_data_']["orderId"] = $orderId;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 同意退换货
     * 参数名	说明	必填	类型	长度	备注
    *checkComment	审核备注	否	String	<=200个字符	备注信息
    *pickupBeginTime	预计取件开始时间	否	String	<=21个字符	精确到天，上门取件必填，格式为：2017-10-01
    *pickupEndTime	预计取件结束时间	否	String	<=21个字符	精确到天，上门取件必填，格式为：2017-10-01
    *returnOrderId	退换货单ID	是	Long	1 ~ 2^64-1	政采云平台的退换货单ID
    *addressId	地址ID	否	Long	1 ~ 2^64-1	供应商在政采云平台录入地址ID，如果获取不到可在address中直接填详细地址，如果是物流发货需要和address二选一
    *address	寄送地址	否	String	<=128个字符	详细地址信息，如果是物流发货需要和addressId二选一
    *mobile	联系方式	否	String	<=20个字符	供应商联系方式，物流发货必填
    *receiverName	联系人名称	否	String	<=50个字符	收件人姓名，物流发货必填
     */
    public function agree_return($checkComment='',$pickupBeginTime='',$pickupEndTime='',$returnOrderId,$addressId='',$address='',$mobile='',$receiverName=''){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.returnOrder.agree";//必须以/开头
        $strs=array();
        $strs['_data_']["checkComment"] = $checkComment;
        $strs['_data_']["pickupBeginTime"] = $pickupBeginTime;
        $strs['_data_']["pickupEndTime"] = $pickupEndTime;
        $strs['_data_']["returnOrderId"] = $returnOrderId;
        $strs['_data_']["addressId"] = $addressId;
        $strs['_data_']["address"] = $address;
        $strs['_data_']["mobile"] = $mobile;
        $strs['_data_']["receiverName"] = $receiverName;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 发送退换货商品
     * 参数名	说明	必填	类型	长度	备注
    *skus	发货sku商品	必填	array
    *└skuCode	外部SKU编码	可选	string	<=80个字符	【skuId和skuCode两者选填一个，优先skuId】
    *└quantity	发货数量	必填	number	1 ~ 2^32-1
    *└skuId	 skuID	可选	number	1 ~ 2^64-1	【skuId和skuCode两者选填一个，优先skuId】
    *returnOrderId	退换货单ID	必填	number	1 ~ 2^64-1
    *expressCode	发货物流公司代码	必填	string	<=32个字符
    *shipmentNo	物流单号	必填	number	<=32个字符
     */
    public function send_good($skus,$skuCode='',$quantity,$skuId='',$returnOrderId,$expressCode,$shipmentNo){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.returnOrder.shipment.create";//必须以/开头
        $strs=array();
        $strs['_data_']["skus"] = $skus;
        $strs['_data_']["skus"]['skuCode'] = $skuCode;
        $strs['_data_']["skus"]['quantity'] = $quantity;
        $strs['_data_']["skus"]['skuId'] = $skuId;
        $strs['_data_']["returnOrderId"] = $returnOrderId;
        $strs['_data_']["expressCode"] = $expressCode;
        $strs['_data_']["shipmentNo"] = $shipmentNo;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 确认收到退换货商品
     * 参数名	说明	必填	类型	长度	备注
    *confirmComment	备注信息	可选	string	<=200个字符
    *returnOrderId	退换货单ID	必填	number	1 ~ 2^64-1
     */
    public function is_getgood($confirmComment = '',$returnOrderId){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.returnOrder.receive";//必须以/开头
        $strs=array();
        $strs['_data_']["confirmComment"] = $confirmComment;
        $strs['_data_']['returnOrderId'] = $returnOrderId;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 不同意退换货
     * 参数名	说明	必填	类型	长度	备注
    *checkComment	审核备注	可选	string	<=200个字符	备注
    *returnOrderId	退换货单ID	必填	number	1 ~ 2^64-1
     */
    public function disagree_return($confirmComment = '',$returnOrderId){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.returnOrder.disAgree";//必须以/开头
        $strs=array();
        $strs['_data_']["confirmComment"] = $confirmComment;
        $strs['_data_']['returnOrderId'] = $returnOrderId;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     * 获取物流公司列表
     */
    public function logistics_list(){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.logistics.companies.get";//必须以/开头
        $strs=array();
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }



    /**
     * 同意或拒绝取消订单
     * 参数名	说明	必填	类型	备注
    *orderId	订单id	和orderCode至少一个不为空	number	1 ~ 2^64-1
    *isAgree	是否同意取消订单	是	boolean	true同意取消，false不同意
    *orderCode	外部订单号	和orderId至少一个不为空	String	-
    *comment	理由	拒绝取消订单时，必须不为空, max=120	String	-
     */
    public function is_agree_order($orderId,$isAgree,$comment){
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/supplier/zcy.mall.order.cancel.isAgree";//必须以/开头
        $strs=array();
        $strs['_data_']["orderId"] = $orderId;
        $strs['_data_']["isAgree"] = $isAgree;
        $strs['_data_']["comment"] = $comment;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
        return $str;
    }


    /**
     *订单附加信息查询
     * 参数名	说明	必填	类型	长度	备注
    *orderIds	订单id列表	是	array	最大5
     */
    public function order_other_info($orderId)
    {
        require_once('ZcyOpenClient.php');
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $uri = "/zcy.mall.trade.orders.extra.get";//必须以/开头
        $strs=array();
        $strs['_data_']["orderIds"] = $orderId;
        $strs['_data_'] = json_encode($strs['_data_']);
        $p= new ZcyOpenClient();
        $str= $p->sendPost($this->gate_way,$uri,"POST",$this->appKey,$this->appSecret,$strs);
        $str = json_decode($str,true);
//        var_dump($str);die;
        return $str;
    }

    //图片上传
    public function zcyimage($filePath,$fileName,$description='商品描述',$fileContentType='img/png',$size='23009'){
        require_once('ZcyItemUtil.php');//商品图片上传OSS组件
        error_reporting(E_ERROR | E_WARNING | E_PARSE);
        $itemImgUtil = new ZcyItemUtil();
        $result = $itemImgUtil->uploadZcyItemImg($this->gate_way,$this->appKey,$this->appSecret,$filePath,$fileName,$size,$fileContentType,$description);
        return $result;
    }

}

?>