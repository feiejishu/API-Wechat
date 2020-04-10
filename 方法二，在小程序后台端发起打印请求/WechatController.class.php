<?php
    namespace Admin\Controller;

    use Think\Controller;

    class WechatController extends Controller
    {
    	public function _initialize()
		{
			header("Content-type: text/html; charset=utf-8");
		}

    	public function api()
    	{
    		$cidx = I('post.cid');//小程序发过来的相关信息
    		
    		if(empty($cidx)){
    			echo json_encode('error');
    			exit;
    		}
			define('USER', 'XXXXXXXXXXXXXXXXXX');      //*必填*：飞鹅云后台注册账号
			define('UKEY', 'XXXXXXXXXXXXXXXXXX'); //*必填*: 飞鹅云注册账号后生成的UKEY

			//以下参数不需要修改
			define('IP','api.feieyun.cn');			//接口IP或域名
			define('PORT',80);						//接口IP端口
			define('PATH','/Api/Open/');		//接口路径
			define('STIME', time());			    //公共参数，请求时间
			define('SIG', sha1(USER.UKEY.STIME));   //公共参数，请求公钥

    		$orderInfo = '<CB>小程序后台打印</CB><BR>';
			$orderInfo .= '名称　　　　　 单价  数量 金额<BR>';
			$orderInfo .= '--------------------------------<BR>';
			$orderInfo .= '饭　　　　　 　10.0   10  100.0<BR>';
			$orderInfo .= '炒饭　　　　　 10.0   10  100.0<BR>';
			$orderInfo .= '蛋炒饭　　　　 10.0   10  100.0<BR>';
			$orderInfo .= '鸡蛋炒饭　　　 10.0   10  100.0<BR>';
			$orderInfo .= '西红柿炒饭　　 10.0   10  100.0<BR>';
			$orderInfo .= '西红柿蛋炒饭　 10.0   10  100.0<BR>';
			$orderInfo .= '西红柿鸡蛋炒饭 10.0   10  100.0<BR>';
			$orderInfo .= '--------------------------------<BR>';
			$orderInfo .= '备注：加辣<BR>';
			$orderInfo .= '合计：xx.0元<BR>';
			$orderInfo .= '送货地点：广州市南沙区xx路xx号<BR>';
			$orderInfo .= '联系电话：13888888888888<BR>';
			$orderInfo .= '订餐时间：2014-08-08 08:08:08<BR>';
			$orderInfo .= '<QR>http://www.feieyun.com</QR>';
			$result = $this->wp_print(SN,$orderInfo,1);
			$result = json_encode($result,true);
			// var_dump($result);
			if($result['msg'] == 'ok' && $result['ret'] == '0'){//发送订单成功
				echo json_encode('ok');
			}else{
				$res = explode('，',$result['msg']);
				echo json_encode($res['0']);//输出失败信息
			}
    	}

    	function wp_print($printer_sn,$orderInfo,$times){
			$content = array(			
				'user'=>USER,
				'stime'=>STIME,
				'sig'=>SIG,
				'apiname'=>'Open_printMsg',
				'sn'=>$printer_sn,
				'content'=>$orderInfo,
			    'times'=>$times//打印次数
			);
			$client = new \Org\Util\HttpClient(IP,PORT);
			if(!$client->post(PATH,$content)){
				echo 'error';
			}else{
				//服务器返回的JSON字符串，建议要当做日志记录起来
				return $client->getContent();
			}
		}
    }
