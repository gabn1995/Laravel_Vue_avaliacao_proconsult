<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

/*
* Carregando os models
*/ 
use App\Models\User;

/*
* Esta classe possui as funções responsável pela autenticação
*/
class AuthController extends Controller
{
    private $loggedUser;

    /*
    * construtor
    */
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => [
                'create',
                'login',
                'unauthorized'
            ]
        ]);
        $this->loggedUser = auth()->user();
    }

    /*
    * função responsável pelo cadastro do usuário no banco de dados
    */
    public function create(Request $request)
    {
        $array = ['error' => ''];

        //regras de validação
        $rules = [
            'nome_completo' => 'required',
            'tipo_usuario' => 'required',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|unique:users,cpf',
            'password' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->messages();
            return response()->json($array, 400);
        }

        //Pegando os dados enviados
        $nome_completo = $request->input('nome_completo');
        $tipo_usuario = $request->input('tipo_usuario');
        $cpf = $request->input('cpf');
        $email = $request->input('email');
        $password = $request->input('password');

        /*
        * Validando tipo de usuário suportado
        * tipos suportados [cliente, colaborador]
        */
        if (($tipo_usuario != 'cliente') && ($tipo_usuario != 'colaborador')) {
            $array['error'] = 'Tipo de usuário não suportado';
            return response()->json($array, 400);
        }

        //Criando novo usuário
        $newUser = new User();
        $newUser->nome_completo = $nome_completo;
        $newUser->tipo_usuario = $tipo_usuario;
        $newUser->cpf = $cpf;
        $newUser->email = $email;
        $newUser->password = password_hash($password, PASSWORD_DEFAULT);
        $newUser->save();

        //Logar usuário criado
        $token = Auth::attempt([
            'email' => $email,
            'password' => $password
        ]);

        //Salvar token
        if ($token) {
            $array['token'] = $token;
            $array['usuario'] = auth()->user();
        }

        return response()->json($array, 201);
    }

    /*
    * função responsável por logar usuário
    */
    public function login(Request $request)
    {
        $array = ['error' => ''];

        $creds = $request->only('email', 'password');

        $token = Auth::attempt($creds);

        //montando o retorno
        if ($token) {
            $array['token'] = $token;
            $array['usuario'] = auth()->user();
        } else {
            $array['error'] = 'E-mail e/ou senha incorretos';
        }

        return response()->json($array, 200);
    }

    /*
    * função responsável por fazer logout
    */
    public function logout()
    {
        $array = ['error' => ''];

        Auth::logout();

        return response()->json($array,200);
    }

    /*
    * função responsável por mandar mensagem de usuário não autorizado
    */
    public function unauthorized()
    {
        return response()->json(['error' => 'Não autorizado'], 401);
    }
}
