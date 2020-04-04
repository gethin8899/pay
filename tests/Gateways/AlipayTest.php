<?php

namespace Gethin8899\Pay\Tests\Gateways;

use Symfony\Component\HttpFoundation\Response;
use Gethin8899\Pay\Pay;
use Gethin8899\Pay\Tests\TestCase;

class AlipayTest extends TestCase
{
    public function testSuccess()
    {
        $success = Pay::alipay([])->success();

        $this->assertInstanceOf(Response::class, $success);
        $this->assertEquals('success', $success->getContent());
    }
}
