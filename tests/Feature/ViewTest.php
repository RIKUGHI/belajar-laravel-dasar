<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('/hello')
            ->assertSeeText('hello Bambang');

        $this->get('/hello-again')
            ->assertSeeText('hello Bambang-again');
    }

    public function testNested()
    {
        $this->get('/hello-world')
            ->assertSeeText('world Bambang');
    }

    public function testTemplate()
    {
        $this->view('hello', ['name' => 'Bambang'])
            ->assertSeeText('hello Bambang');

        $this->view('hello.world', ['name' => 'Bambang'])
            ->assertSeeText('world Bambang');
    }
}
