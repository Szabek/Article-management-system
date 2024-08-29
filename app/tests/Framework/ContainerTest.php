<?php

namespace tests\Framework;

use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use Szabek\Framework\Container;

class ContainerTest extends TestCase
{
    public function testSetAndGetService()
    {
        $container = new Container();

        $container->set('example_service', function($container) {
            return new stdClass();
        });

        $service = $container->get('example_service');
        $this->assertInstanceOf(stdClass::class, $service);
    }

    public function testGetNonExistentService()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Service not found: non_existent_service');

        $container = new Container();
        $container->get('non_existent_service');
    }
}