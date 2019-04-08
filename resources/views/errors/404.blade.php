@extends('html')

@section('title')
    <title>Página não encontrada - Desafio Conductor de Seleção</title>
@stop

@section('conteudo')
    <div class="col-md-8 col-md-offset-2">
        <h1 class="dark-text">Página não encontrada</h1>
        <section>
            <h2>
                A página solicitada não foi encontrada, verifique o endereço digitado e tente novamente.
            </h2>
            <h2>
                Ou você pode visualizar nossa documentação do <a href="{{ url('docs/comecando.md') }}">inicio</a>
            </h2>
        </section>
    </div>
@stop
