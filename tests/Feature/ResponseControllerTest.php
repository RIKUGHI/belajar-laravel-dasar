<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse(){
        $this->get('/response/hello')
            ->assertStatus(200)
            ->assertSeeText('hello response');
    }

    public function testHeader(){
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('bambang')->assertSeeText('nice')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Bambang Nice')
            ->assertHeader('App', 'Belajar Laravel');
    }

    public function testView(){
        $this->get('/response/type/view')
            ->assertSeeText('hello bambang');
    }

    public function testJson(){
        $this->get('/response/type/json')
            ->assertJson([
                'firstName' => 'bambang',
                'lastName' => 'nice'
            ]);
    }

    public function testFile(){
        $this->get('/response/type/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testDownload(){
        $this->get('/response/type/download')
            ->assertDownload('bambang.png');
    }
}
