<?php

namespace Gethin8899\Pay\Gateways\Wechat;

use Gethin8899\Pay\Events;
use Gethin8899\Pay\Exceptions\GatewayException;
use Gethin8899\Pay\Exceptions\InvalidArgumentException;
use Gethin8899\Pay\Exceptions\InvalidSignException;
use Yansongda\Supports\Collection;

class PosGateway extends Gateway
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     */
    public function pay($endpoint, array $payload): Collection
    {
        unset($payload['trade_type'], $payload['notify_url']);

        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(new Events\PayStarted('Wechat', 'Pos', $endpoint, $payload));

        return Support::requestApi('pay/micropay', $payload);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     */
    protected function getTradeType(): string
    {
        return 'MICROPAY';
    }
}
