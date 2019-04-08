<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpResponseJsonException;
use App\Models\Proprietario;
use Illuminate\Http\Request;

/**
 * Class ProprietariosApiController
 *
 * Classe responsável pelo CRUD do recurso.
 *
 * @package App\Http\Controllers
 */
class ProprietariosApiController extends Controller
{

    /**
     * Método index, retorna uma lista ou um unico registro (busca) do recurso.
     *
     *
     * @param Proprietario $proprietario
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index($id = null)
    {
        $proprietario = Proprietario::findOrNew($id);

        return response($proprietario->get());
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
        $rules = [
            'nome'      => 'required',
            'telefone'  => 'min:8|required',
            'email'     => 'required|email',
        ];

        $proprietario = Proprietario::findOrNew($id);
        if ($proprietario->exists) {
            $rules = [
                'telefone'  => 'min:8',
                'email'     => 'email',
            ];
        }

        $this->validate($request, $rules);

        if ($proprietario->exists) {
            $proprietario->update($request->all());
        }
        if (!$proprietario->exists && !$id) {
            $proprietario->fill($request->all())->save();
        }
        if (!$proprietario->exists) {
            throw new HttpResponseJsonException([
                'Falha ao atualizar, recurso não encontrado.'
            ]);
        }

        return response($proprietario, 201);
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
        $proprietario = Proprietario::findOrNew($id);

        if (!$proprietario->exists || $proprietario->delete() !== true) {
            throw new HttpResponseJsonException([
                'Falha ao excluir, recurso não encontrado.'
            ]);
        }

        return response(['Recurso excluído']);
    }
}
