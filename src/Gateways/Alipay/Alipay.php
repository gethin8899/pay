<?php 

namespace Yansongda\Pay\Gateways;

use Yansongda\Pay\Support\Config;
use Yansongda\Pay\Contracts\GatewayInterface;
use Yansongda\Pay\Exceptions\InvalidArgumentException;

/**
*   
*/
abstract class Alipay implements GatewayInterface
{
    const WAP_METHOD = 'alipay.trade.wap.pay';
    const WAP_PRODUCT_CODE = 'QUICK_WAP_WAY';

    protected $config;

    /**
     * [$config description]
     * @var [type]
     */
    protected $public_config = [
        'app_id' => '',
        'method' => '',
        'format' => 'JSON',
        'charset' => 'utf-8',
        'sign_type' => 'RSA2',
        'version' => '1.0',
        'timestamp' => '',
        'sign' => '',
        'notify' => '',
        'return' => '',
        'bizContent' => '',
    ];

    /**
     * 业务参数
     * @var [type]
     */
    protected $biz_config = [
        'out_trade_no' => '',
        'product_code' => '',
        'total_amount' => '',
        'subject' => '',
        'disable_pay_channels' => '',
        'timeout_express' => '15m',
    ];

    /**
     * [__construct description]
     * @author yansongda <me@yansongda.cn>
     * @version 2017-08-05
     * @param   [type]     $config [description]
     */
    public function __construct($config)
    {
        $this->config = new Config($config);

        foreach ($this->config->get() as $key => $value) {
            if (array_key_exists($key, $this->public_config)) {
                $this->public_config[$key] = $value;
            }
        }
        $this->public_config['timestamp'] = date('Y-m-d H:i:s');
    }

    /**
     * 对外接口-支付
     * @author JasonYan <me@yansongda.cn>
     * @version 2017-07-30
     * @param   [type]     $biz_config [description]
     * @param   [type]     $type       [description]
     * @return  [type]                 [description]
     */
    abstract public function pay($biz_config);

    /**
     * 对外接口-退款
     * @author JasonYan <me@yansongda.cn>
     * @version 2017-07-29
     * @return  [type]     [description]
     */
    abstract public function refund();

    /**
     * 对外接口-关闭
     * @author JasonYan <me@yansongda.cn>
     * @version 2017-07-29
     * @return  [type]     [description]
     */
    public function close();

    /**
     * 获取业务参数
     * @author JasonYan <me@yansongda.cn>
     * @version 2017-07-29
     * @return  [type]     [description]
     */
    protected function getBizContent()
    {
        return json_encode($this->biz_config);
    }

    protected function getSign()
    {
        # code...
    }
}