<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
// vendor/bin/phpunit tests/Feature/RoutingTest.php
class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/eskrim')
            ->assertStatus(200)
            ->assertSeeText('Es krimnya enak');
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/eskrim');
    }

    public function testFallback()
    {
        $this->get('/tidakada')
            ->assertSeeText('404 by eskrim');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product 1');

        $this->get('/products/2')
            ->assertSeeText('Product 2');

        $this->get('products/1/items/XXX')
            ->assertSeeText('Product 1, Item XXX');

        $this->get('products/2/items/YYY')
            ->assertSeeText('Product 2, Item YYY');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/100')
            ->assertSeeText('Category 100');

        $this->get('/categories/bambang')
            ->assertSeeText('404 by eskrim');
    }

    public function testRouteParameterOpsional()
    {
        $this->get('/users/bambang')
            ->assertSeeText('User bambang');

        $this->get('/users')
            ->assertSeeText('User 404');
    }

    public function testRouteConflict()
    {
        $this->get('/conflict/budi')
            ->assertSeeText('Conflict budi');

        $this->get('/conflict/bambang')
            ->assertSeeText('Conflict bambang nice');
    }

    public function testNamedRoute()
    {
        $this->get('/produk/12345')
            ->assertSeeText('Link http://localhost/products/12345');

        $this->get('/produk-redirect/12345')
            ->assertSeeText('/products/12345');
    }
}
