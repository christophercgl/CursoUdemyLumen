<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Quando a chamada vai exectar uma ação, tem que passar o nome da controller e o @ nome do metudo que vai querer chamar
$router->get('/usuarios', 'UsuarioController@mostrarTodosUsuarios');

// Diz que todas as rotas vão ter o /usuario no começo da url
$router->group(['prefix' => 'usuario'], function () use($router) {
	$router->post('/cadastrar', 'UsuarioController@cadastrarUsuario'); // passa parametro no body

	$router->get('/{id}', 'UsuarioController@mostrarUmUsuario'); // rota passando parametro na url

	$router->put('/{id}/atualizar', 'UsuarioController@atualizarUsuario'); // Pega id na URL e dados no body

	$router->delete('/{id}/deletar', 'UsuarioController@deletarUsuario');	
});

$router->post('/login', 'UsuarioController@usuarioLogin'); // rota para fazer login

$router->post('/info', 'UsuarioController@mostrarUsuarioAutenticado'); // pode passar o token na url ou body EX: (http://localhost:8000/info?token=eeasd45a46s5d4a6s54das5d4as54d)

$router->post('/logout', 'UsuarioController@usuarioLogout'); // Feito logout invalida o token e usuario tem q gerar novo token





// comentado pois está no group
//$router->post('/usuario/cadastrar', 'UsuarioController@cadastrarUsuario'); // passa parametro no body

//$router->get('/usuario/{id}', 'UsuarioController@mostrarUmUsuario'); // rota passando parametro na url

//$router->put('/usuario/{id}/atualizar', 'UsuarioController@atualizarUsuario'); // Pega id na URL e dados no body

//$router->delete('/usuario/{id}/deletar', 'UsuarioController@deletarUsuario');

/*$router->get('/teste', function () use ($router) {
    return '[routes/web.php] Rota de teste';
});

$router->post('/teste', function () use ($router) {
    return '[routes/web.php] Rota de teste';
});*/
