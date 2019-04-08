<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Exceptions\HttpResponseJsonException;

/**
 * Class AuthJwtController
 *
 * Controller responsável por gerar o token (JWT) para aceso à aplicação.
 *
 * @package App\Http\Controllers
 */
class AuthJwtController extends Controller
{
    /**
     * Regras de Validação do método autenticacao
     *
     * @var array
     */
    protected $rules = [
        'email'     => 'required|email',
        'password'  => 'required|min:3|max:50',
    ];


    /**
     * Método responsável por gerar o token para acesso à aplicação.
     *
     * Retorna uma response json.
     *
     * Caso ocorra algum problema na validação dos dados, será lançado uma exceção
     * que retornará uma response json com o campo "fails" contendo os problemas encontrados.
     *
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function autenticacao(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $user = User::where('email', '=', $request->get('email'))->first();

        $this->validacoes($request, $user, $credentials);

        $custom = ['id_user' => $user->id, 'name' => $user->name];
        $token = JWTAuth::fromUser($user, $custom);

        $objectToken = JWTAuth::setToken($token);
        $expiration = JWTAuth::decode($objectToken->getToken())->get('exp');

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $expiration
        ]);
    }


    /**
     * Método responsável por retornar as informações do usuário logado.
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function detalhes()
    {
        $token = JWTAuth::parseToken();
        $userId = $token->getPayload()->get('id_user');

        $user = User::findOrNew($userId);

        if (!$user->exists) {
            throw new HttpResponseJsonException([
                'Não foi possível retornar as informações do titular'
            ]);
        }

        return response($user);
    }


    /**
     * Método usado internamente para realizar as validações da autenticação, ou seja,
     * do retorno do token.
     *
     * @param Request $request
     * @param User  $user
     * @param array   $credentials
     */
    protected function validacoes($request, $user, $credentials)
    {
        $validator = Validator::make($request->all(), $this->rules);

        if ($validator->fails()) {
            throw new HttpResponseJsonException(
                $validator->errors()->getMessages()
            );
        }

        if (!$user) {
            throw new HttpResponseJsonException([
                'email' => 'O email informado não existe.'
            ]);
        }

        if (!Hash::check($credentials['password'], $user->password)) {
            throw new HttpResponseJsonException([
                'password' => 'A senha informada não foi encontrada.'
            ]);
        }
    }
}
