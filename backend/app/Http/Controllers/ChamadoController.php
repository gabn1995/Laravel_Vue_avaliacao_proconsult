<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;

/*
* Carregando os models
*/ 
use App\Models\Chamado;

/*
* Esta classe possui as funções responsável pela manipulação dos chamados
*/
class ChamadoController extends Controller
{
    private $loggedUser;

    /*
    * construtor
    */
    public function __construct()
    {
        $this->middleware('auth:api');
        $this->loggedUser = auth()->user();
    }

    /*
    * função para listar os chamados
    */
    public function chamados()
    {
        $array = ['error' => ''];

        $chamados = Chamado::all();

        $array['chamados'] = $chamados;

        return response()->json($array, 200);
    }

    /*
    * função para adicionar um novo chamado
    */
    public function adicionar_chamado(Request $request){
        $array = ['error' => ''];

        //regras de validação
        $rules = [
            'titulo' => 'required',
            'descricao' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $array['error'] = $validator->messages();
            return response()->json($array, 400);
        }

        //Pegando os dados enviados
        $titulo = $request->input('titulo');
        $descricao = $request->input('descricao');

        //Criando novo chamado
        $chamado = new Chamado();
        $chamado->id_usuario = $this->loggedUser['id'];
        $chamado->titulo = $titulo;
        $chamado->descricao = $descricao;
        $chamado->save();

        return response()->json($array, 201);
    }

    /*
    * função para responder um chamado
    */
    public function responder_chamado(Request $request){
        $array = ['error' => ''];

        //Pegar os dados enviados
        $id = $request->input('id');

        //Procurar o chamado pelo id e alterar status para "Em Andamento"
        if($id){
            $chamado = Chamado::find($id);
            $chamado->status = "Em Andamento";
            $chamado->save();

            return response()->json($array, 200);
        }else{
            $array['error'] = "id inválido";
            return response()->json($array, 400);
        }
        
    }
    
    /*
    * função para finalizar um chamado
    */
    public function finalizar_chamado(Request $request){
        $array = ['error' => ''];

        //Pegar os dados enviados
        $id = $request->input('id');

        //Procurar o chamado pelo id e alterar status para "Finalizado"
        if($id){
            $chamado = Chamado::find($id);
            $chamado->status = "Finalizado";
            $chamado->save();

            return response()->json($array, 200);
        }else{
            $array['error'] = "id inválido";
            return response()->json($array, 400);
        }
        
    }
}
