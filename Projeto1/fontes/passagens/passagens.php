<?php
require_once("../../funcoes/catalogo.php");
require_once("./passagensfuncoes.php");
$sair=( ISSET($_REQUEST['sair']) ) ? $_REQUEST['sair'] : 1;
$menu=$sair-1;
iniciapagina(TRUE,"Passagens","passagens","Abertura");
montamenu("Abertura",$sair);
printf("<texto>\n");
printf("Este sistema faz o Gerenciamento de dados da Tabela passagens.<br>\n");
printf("O menu apresentado acima indica as funcionalidades do sistema.<br><br>\n");
printf("Este sistema deve permitir a navegação usando botões e acessos configurados<br>\n");
printf("como texto (sem bordas, com fundo transparente e texto no mesmo formato<br>\n");
printf("do ambiente onde o elemento está sendo exibido).<br>\n");
printf("Em cada funcionalidade acessada pelo usuário do sistema devem estar disponíveis<br>\n");
printf("botões e acessos de navegação permitindo:<br>\n");
printf("Abertura - Saltar para a página de abertura<br>\n");
printf("Sair - Saltar para fora do sistema<br>\n");
printf("Voltar - Pular <em>UMA</em> página para trás na lista de páginas acessadas<br>\n");
printf("Salvar - Confirmar a ação de uma funcionalidade acessada.<br>\n");
printf("Limpar - Limpar os dados dos campos de formulários (resetar)<br><br>\n");
printf("Em TODAS as telas deve-se ver o menu na parte superior e a linha de rodapé configurada como abaixo.<br>\n");
printf("Nome: Vitor Rodrigues de Campos <br>Matricula: 0210482122034<br>\n");
printf("</texto>\n");
terminapagina("Passagens","Abertura","passagens.php");
?>