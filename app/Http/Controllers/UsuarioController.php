<?php

namespace App\Http\Controllers;

use App\Usuario; // Uso o model que conecta no banco que criei Usuario.php (Link o model nesse arquivo)
use Illuminate\Http\Request; // Instancia pra poder pegar e usar o conteudo que é passado no corpo da requisição 
use Tymon\JWTAuth\JWTAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash; // Biblioteca que cria hash


class UsuarioController extends Controller
{

    protected $jwt; // varialvel para ser usada em todo o projeto

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(JWTAuth $jwt)
    {
        $this->jwt = $jwt;

        // todos os metodos passaram pelo middleware e validará o token
        $this->middleware('auth:api', [
            'except' => ['usuarioLogin', 'cadastrarUsuario'] // except adiciona os metodos q vão funcionar sem validar o token
        ]); 
    }

    // Função que fará o loggin da aplicação
    public function usuarioLogin(Request $request)
    {
        // valida os campos
        $this->validate($request, [
            'email' => 'required|email|max:255',
            'password' => 'required'
        ]);

        // ve se tem usuario com o email e senha enviado na requisição (attempt) -> essa função valida
        // a função attempt tem que ter obrigatoriamente 2 parametros e 1 deles tem q ter o nome password
        // claims coloco os dados que quero a mais no token
        if (! $token = $this->jwt->claims(['email' => $request->email])->attempt($request->only('email', 'password'))) 
        {
            return response()->json(['Usuario não encontrado'], 404);
        }

        return response()->json(compact('token'));

    }

    public function mostrarUsuarioAutenticado()
    {
        $usuario = Auth::user(); // Pega o usuario vinculado ao token

        return response()->json($usuario); // Retorna o usuario vinculado ao token, para usar na aplicação
    }

    public function mostrarTodosUsuarios()
    {
        return response()->json(Usuario::all()); // return all user of bank
    }

    public function cadastrarUsuario(Request $request)
    {
        //validação padrão do lumen
        // passa os campos, depois regra deles
        $this->validate($request,   [
            'usuario' => 'required|min:5|max:40',
            'email' => 'required|email|unique:usuarios,email', //Valida se é um email, unique vê na tabela usuarios na coluna email se já n está cadastrado
            'password' => 'required'
        ]);

        //inserindo user
        $usuario = new Usuario;

        $usuario->usuario    = $request->usuario;
        $usuario->email      = $request->email;
        $usuario->password   = Hash::make($request->password); // cria a senha com hash para validar no attempt (maior segurança)
        $usuario->verificado = $request->verificado;

        //Salvar no banco
        $usuario->save();
        //Mostra o usuario salvo
        return response()->json($usuario);        

        //return response()->json($request->all()); //pega todo o corpo da requisição.
    }

    public function mostrarUmUsuario($id)
    {
        return response()->json(Usuario::find($id)); // Busca o usuario com o ID
    }

    public function atualizarUsuario($id, Request $request)
    {
        $usuario = Usuario::find($id); // pega o usuario

        $usuario->usuario    = $request->usuario;
        $usuario->email      = $request->email;
        $usuario->password   = $request->password;
        $usuario->verificado = $request->verificado;

        // Pode fazer validação dos campos aqui...

        // salvar
        $usuario->save();

        return response()->json($usuario);
    }

    public function deletarUsuario($id)
    {
        // buscar usuario pelo id
        $usuario = Usuario::find($id);

        //deletar
        $usuario->delete();

        return response()->json('Deletado com Sucesso', 200); // Msg e status code
    }

    public function usuarioLogout()
    {
        Auth::logout(); // pega o token da requisição e invalida

        // Tudo que for usar token, usa a classe Auth::

        return response()->json("Usuario deslogou com sucesso!");
    }
    
}
