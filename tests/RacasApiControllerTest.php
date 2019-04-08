<?php

use App\Models\Raca;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RacasApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $params = [
        "nome" => "Php Unit",
    ];


    public function testIndex()
    {
        $controller = new \App\Http\Controllers\RacasApiController();
        $response = $controller->index();

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreNew()
    {
        $controller = new \App\Http\Controllers\RacasApiController();
        $request = \Illuminate\Http\Request::create('', 'POST', $this->params);
        $response = $controller->store($request);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testStoreNewError()
    {
        $controller = new \App\Http\Controllers\RacasApiController();
        $request = \Illuminate\Http\Request::create('', 'POST');
        $response = $controller->store($request);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }

    public function testStoreUpdate()
    {
        $raca = Raca::create($this->params);
        $controller = new \App\Http\Controllers\RacasApiController();
        $request = \Illuminate\Http\Request::create('', 'PUT', $this->params);
        $response = $controller->store($request, $raca->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testStoreUpdateError()
    {
        $raca = Raca::create($this->params);
        $controller = new \App\Http\Controllers\RacasApiController();
        $request = \Illuminate\Http\Request::create('', 'PUT', []);
        $response = $controller->store($request, $raca->id);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }

    public function testDestroy()
    {
        $raca = Raca::create($this->params);
        $controller = new \App\Http\Controllers\RacasApiController();
        $response = $controller->destroy($raca->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testDestroyError()
    {
        $controller = new \App\Http\Controllers\RacasApiController();
        $response = $controller->destroy(99999999);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }
}
