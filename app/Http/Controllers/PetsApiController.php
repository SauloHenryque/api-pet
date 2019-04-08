<?php

namespace App\Http\Controllers;

use App\Exceptions\HttpResponseJsonException;
use App\Models\Animal;
use Illuminate\Http\Request;

/**
 * Class PetsApiController
 *
 * Classe responsável pelo CRUD do recurso.
 *
 * @package App\Http\Controllers
 */
class PetsApiController extends Controller
{

    /**
     * Método index, retorna uma lista ou um unico registro (busca) do recurso.
     *
     *
     * @param Animal $animal
     * @param null $id
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function index($id = null)
    {
        $animal = Animal::findOrNew($id);

        return response($animal->get());
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
            'nome' => 'required',
            'porte' => 'required|in:pequeno,medio,grande',
            'raca_id' => 'required',
            'proprietario_id' => 'required',
        ];

        $animal = Animal::findOrNew($id);
        if ($animal->exists) {
            $rules = [
                'porte' => 'in:pequeno,medio,grande',
            ];
        }

        $this->validate($request, $rules, ['porte.in' => 'O valor informado para o campo é inválido, valores aceitos: pequeno, medio, grande.']);

        if ($animal->exists) {
            $animal->update($request->all());
        }
        if (!$animal->exists && !$id) {
            $animal->fill($request->all())->save();
        }
        if (!$animal->exists) {
            throw new HttpResponseJsonException([
                'Falha ao atualizar, recurso não encontrado.'
            ]);
        }

        $animal->proprietario;
        $animal->raca;

        return response($animal, 201);
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
        $animal = Animal::findOrNew($id);

        if (!$animal->exists || $animal->delete() !== true) {
            throw new HttpResponseJsonException([
                'Falha ao excluir, recurso não encontrado.'
            ]);
        }

        return response(['Recurso excluído']);
    }
}
