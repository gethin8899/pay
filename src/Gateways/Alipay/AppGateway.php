<?php

namespace Gethin8899\Pay\Gateways\Alipay;

use Symfony\Component\HttpFoundation\Response;
use Gethin8899\Pay\Events;
use Gethin8899\Pay\Exceptions\InvalidArgumentException;
use Gethin8899\Pay\Exceptions\InvalidConfigException;
use Gethin8899\Pay\Gateways\Alipay;

class AppGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @throws InvalidConfigException
     * @throws InvalidArgumentException
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['method'] = 'alipay.trade.app.pay';

        $biz_array = json_decode($payload['biz_content'], true);
        if ((Alipay::MODE_SERVICE === $this->mode) && (!empty(Support::getInstance()->pid))) {
            //������ģʽ�ҷ�����pid������Ϊ��
            $biz_array['extend_params'] = is_array($biz_array['extend_params']) ? array_merge(['sys_service_provider_id' => Support::getInstance()->pid], $biz_array['extend_params']) : ['sys_service_provider_id' => Support::getInstance()->pid];
        }
        $payload['biz_content'] = json_encode(array_merge($biz_array, ['product_code' => 'QUICK_MSECURITY_PAY']));
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Alipay', 'App', $endpoint, $payload));

        return Response::create(http_build_query($payload));
    }
}
