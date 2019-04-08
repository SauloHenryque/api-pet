<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpResponseJsonException;
use App\Models\Raca;
use Illuminate\Http\Request;

/**
 * Class RacasApiController
 *
 * Classe responsável pelo CRUD do recurso.
 *
 * @package App\Http\Controllers
 */
class RacasApiController extends Controller
{

    /**
     * Método index, retorna uma lista ou um unico registro (busca) do recurso.
     *
     *
     * @param Raca $raca
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index($id = null)
    {
        $raca = Raca::findOrNew($id);

        return response($raca->get());
    }


    /**
     * Método responsável por criar ou atualizar um recurso.
     *
     * Pode retornar uma exceção caso os dados de entrada não estejam de acordo com as regras
     * de validação.
     *
     * @param Request $request
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function store(Request $request, $id = null)
    {
        $request->merge(['id' => $id]);
        $raca = Raca::findOrNew($id);
        $this->validate($request, ['nome' => 'required']);

        if ($raca->exists) {
            $raca->update($request->all());
        }
        if (!$raca->exists && !$id) {
            $raca->fill($request->all())->save();
        }
        if (!$raca->exists) {
            throw new HttpResponseJsonException([
                'Falha ao atualizar, recurso não encontrado.'
            ]);
        }

        return response($raca, 201);
    }


    /**
     * Método responsáve por deletar um recurso.
     *
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function destroy($id = null)
    {
        $raca = Raca::findOrNew($id);

        if (!$raca->exists || $raca->delete() !== true) {
            throw new HttpResponseJsonException([
                'Falha ao excluir, recurso não encontrado.'
            ]);
        }

        return response(['Recurso excluído']);
    }
}
