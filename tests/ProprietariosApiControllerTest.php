<?php

use App\Models\Proprietario;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProprietariosApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $params = [
        "nome"      => "Php Unit",
        "telefone"  => "0000-0000",
        "email"     => "phpunit@email.com",
        "endereco"  => "Nao Informado",
        "numero"    => "S/N",
        "cidade"    => "Brasília",
        "uf"        => "DF",
        "pais"      => "Brasil",
    ];


    public function testIndex()
    {
        $controller = new \App\Http\Controllers\ProprietariosApiController();
        $response = $controller->index();

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreNew()
    {
        $controller = new \App\Http\Controllers\ProprietariosApiController();
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
        $controller = new \App\Http\Controllers\ProprietariosApiController();
        $request = \Illuminate\Http\Request::create('', 'POST');
        $response = $controller->store($request);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }

    public function testStoreUpdate()
    {
        $raca = Proprietario::create($this->params);
        $controller = new \App\Http\Controllers\ProprietariosApiController();
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
        $raca = Proprietario::create($this->params);
        $controller = new \App\Http\Controllers\ProprietariosApiController();
        $param = $this->params;
        $param['email'] = 'email@email';
        $request = \Illuminate\Http\Request::create('', 'PUT', $param);
        $response = $controller->store($request, $raca->id);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }

    public function testDestroy()
    {
        $raca = Proprietario::create($this->params);
        $controller = new \App\Http\Controllers\ProprietariosApiController();
        $response = $controller->destroy($raca->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testDestroyError()
    {
        $controller = new \App\Http\Controllers\ProprietariosApiController();
        $response = $controller->destroy(99999999);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }
}
