<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput(){
        $this->get('/input/hello?name=bambang')
            ->assertSeeText('Hello bambang');
        
        $this->post('/input/hello', [
            'name' => 'bambang'
        ])->assertSeeText('Hello bambang');
    }

    public function testInputNested(){
        $this->post('/input/hello/first', [
            'name' => [
                'first' => 'bambang',
                'last' => 'nice'
            ]
        ])->assertSeeText('Hello bambang');
    }

    public function testInputAll(){
        $this->post('/input/hello/input', [
            'name' => [
                'first' => 'bambang',
                'last' => 'nice'
            ]
        ])->assertSeeText('name')->assertSeeText('first')
            ->assertSeeText('last')->assertSeeText('bambang')
            ->assertSeeText('nice');
    }

    public function testInputArray(){
        $this->post('/input/hello/array', [
            'products' => [
                [
                    "name" => "Apple Mac Book Pro",
                    "price" => 10000
                ],
                [
                    "name" => "Samsung Galaxy S10",
                    "price" => 20000
                ]
            ]
        ])->assertSeeText('Apple Mac Book Pro')
            ->assertSeeText('Samsung Galaxy S10');
    }

    public function testInputType(){
        $this->post('/input/type', [
            'name' => 'Budi',
            'married' => 'true',
            'birth_date' => '1990-10-10'
        ])->assertSeeText('Budi')->assertSeeText('true')->assertSeeText('1990-10-10');
    }

    public function testFilterOnly(){
        $this->post('/input/filter/only', [
            "name" => [
                "first" => "bambang",
                "middle" => "ok",
                "last" => "nice"
            ]
        ])->assertSeeText("bambang")->assertSeeText("nice")->assertDontSeeText("ok");
    }

    public function testFilterExcept(){
        $this->post('/input/filter/except', [
            'username' => 'bambang',
            'password' => 'rahasia',
            'admin' => 'true'
        ])->assertSeeText("bambang")->assertSeeText("rahasia")->assertDontSeeText("admin");
    }

    public function testFilterMerge(){
        $this->post('/input/filter/merge', [
            'username' => 'bambang',
            'password' => 'rahasia',
            'admin' => 'true'
        ])->assertSeeText("bambang")->assertSeeText("rahasia")
            ->assertSeeText("admin")->assertSeeText('false');
    }
}
