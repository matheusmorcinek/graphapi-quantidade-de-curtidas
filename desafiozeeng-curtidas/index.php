<!DOCTYPE html>
<!--
@author: Matheus Morcinek.
17/sep/2016.
-->
<html lang="pt-br">
<head>
<meta charset="UTF-8" />
<title>Desafio - Curtidas</title>
</head>

<body>
	<script>
            //carrega e inicializa o SDK do facebook, é necessario informar o appId cadastrado.
            window.fbAsyncInit = function () {
                FB.init({
                    appId: 'aqui vai sua AppId',
                    xfbml: true,
                    version: 'v2.7'
                });
            };
            (function (d, s, id) {
                var js, fjs = d.getElementsByTagName(s)[0];
                if (d.getElementById(id)) {
                    return;
                }
                js = d.createElement(s);
                js.id = id;
                js.src = "//connect.facebook.net/en_US/sdk.js";
                fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));
            
            //faz a chamada da api para consultar informações do usuário logado.
            function myData() {
                FB.api(
                        '/me',
                        'GET',
                        {"fields": "name"},
                        function (response) {
                            document.getElementById('userlogado').innerHTML = 'Olá ' + response.name + ', insira a url de uma página do facebook no campo a seguir:';
                        });
            }
            ;
            
            // login facebook com permissoes.
            function login() {
                FB.login(function (response) {
                    if (response.status === 'connected') {
                        document.getElementById('login').style.visibility = 'hidden';
                        myData();
                    } else if (response.status === 'not_authorized') {
                        document.getElementById('status').innerHTML = 'Erro ao logar.';
                    } else {
                        document.getElementById('status').innerHTML = 'Você não está conectado ao Facebook.';
                    }
                }, {scope: 'email'});
            }
        </script>

	<div class="container">
		<div class="row">
			<div id="header">
				<h1>Quantidade de curtidas</h1>
				<button onclick="login()" id="login">Entrar</button>
				<br>
				<div>
					<h3 id="userlogado"></h3>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div id="formulario">
				<h2>Formulário</h2>

				<div class="col-lg-12">
					<div class="form-group">
						<form method="get" action="index.php">
							<label>URL</label> <input id="txtUrl" type="url" name="texto" />
							</br> <input id="enviar" type="button" name="btn" value="ok!" />
						</form>

					</div>

					<script>
                            //recebe a url informada, e faz a consulta inicializando a api.
                            var div = document.getElementById('enviar');
                            div.onclick = function () {

                                var url = (document.getElementById('txtUrl').value);
                                if (url.match(/https/)) {
                                    var nomepagina = url.slice(25);
                                } else if (url.match(/facebook/)) {
                                    var nomepagina = url.slice(17);
                                } else {
                                    var nomepagina = url;
                                }

                                FB.api(nomepagina, 'GET', {fields: 'name,fan_count,website'}, function (response) {
                                    document.getElementById('infopagina').innerHTML = 'A Página ' + response.name + ' tem ' + response.fan_count + ' curtidas.';
                                    document.getElementById('website').innerHTML = response.website;
                                });
                            };

                        </script>
				</div>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div id="informacoes">
				<h2>Informações</h2>
				<div class="col-lg-12">
					<div>
						<h3 id="infopagina"></h3>
					</div>
					<br />

				</div>
			</div>
		</div>
		</div>
		<div id="status"></div>

</body>
</html>

