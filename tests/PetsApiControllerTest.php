<?php

use App\Models\Animal;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PetsApiControllerTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @var array
     */
    protected $params = [
        "nome"              => "Php Unit",
        "porte"             => "pequeno",
        "raca_id"           => "",
        "proprietario_id"   => '',
    ];


    public function testIndex()
    {
        $controller = new \App\Http\Controllers\PetsApiController();
        $response = $controller->index();

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
    }

    public function testStoreNew()
    {
        $raca = \App\Models\Raca::create(['nome' => 'Php Unit Raça']);
        $proprietario = \App\Models\Proprietario::create([
            'nome' => 'Php Unit Proprietario',
            'email' => 'phpunit@email.com',
            'telefone' => '0000-0000',
        ]);
        $this->params['raca_id'] = $raca->id;
        $this->params['proprietario_id'] = $proprietario->id;

        $controller = new \App\Http\Controllers\PetsApiController();
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
        $raca = \App\Models\Raca::create(['nome' => 'Php Unit Raça']);
        $proprietario = \App\Models\Proprietario::create([
            'nome' => 'Php Unit Proprietario',
            'email' => 'phpunit@email.com',
            'telefone' => '0000-0000',
        ]);
        $this->params['raca_id'] = $raca->id;
        $this->params['proprietario_id'] = $proprietario->id;
        $this->params['porte'] = 'nao cadastrado';

        $controller = new \App\Http\Controllers\PetsApiController();
        $request = \Illuminate\Http\Request::create('', 'POST');
        $response = $controller->store($request);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }

    public function testStoreUpdate()
    {
        $raca = \App\Models\Raca::create(['nome' => 'Php Unit Raça']);
        $proprietario = \App\Models\Proprietario::create([
            'nome' => 'Php Unit Proprietario',
            'email' => 'phpunit@email.com',
            'telefone' => '0000-0000',
        ]);
        $this->params['raca_id'] = $raca->id;
        $this->params['proprietario_id'] = $proprietario->id;

        $animal = Animal::create($this->params);

        $controller = new \App\Http\Controllers\PetsApiController();
        $request = \Illuminate\Http\Request::create('', 'PUT', $this->params);
        $response = $controller->store($request, $animal->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testStoreUpdateError()
    {
        $raca = \App\Models\Raca::create(['nome' => 'Php Unit Raça']);
        $proprietario = \App\Models\Proprietario::create([
            'nome' => 'Php Unit Proprietario',
            'email' => 'phpunit@email.com',
            'telefone' => '0000-0000',
        ]);
        $this->params['raca_id'] = $raca->id;
        $this->params['proprietario_id'] = $proprietario->id;

        $animal = Animal::create($this->params);
        $this->params['porte'] = 'nao cadastrado';

        $controller = new \App\Http\Controllers\PetsApiController();
        $request = \Illuminate\Http\Request::create('', 'PUT', $this->params);
        $response = $controller->store($request, $animal->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
        $this->assertEquals(201, $response->getStatusCode());
    }

    public function testDestroy()
    {
        $raca = \App\Models\Raca::create(['nome' => 'Php Unit Raça']);
        $proprietario = \App\Models\Proprietario::create([
            'nome' => 'Php Unit Proprietario',
            'email' => 'phpunit@email.com',
            'telefone' => '0000-0000',
        ]);
        $this->params['raca_id'] = $raca->id;
        $this->params['proprietario_id'] = $proprietario->id;

        $animal = Animal::create($this->params);
        $controller = new \App\Http\Controllers\PetsApiController();
        $response = $controller->destroy($animal->id);

        $this->assertInstanceOf(\Symfony\Component\HttpFoundation\Response::class, $response);
    }

    /**
     * @expectedException \App\Exceptions\HttpResponseJsonException
     */
    public function testDestroyError()
    {
        $controller = new \App\Http\Controllers\PetsApiController();
        $response = $controller->destroy(99999999);

        $this->assertInstanceOf(\App\Exceptions\HttpResponseJsonException::class, $response);
    }
}
