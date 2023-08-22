<?php
function picklist($acao)
{ #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # Monta a caixa de seleção para escolha de um médico para as funcionalidades de consulta, exclusão ou alteração.
  # Esta função tem os parâmetros:
  # $acao.: Texto com o nome da funcionalidade ("Consultar","Alterar" ou "Excluir").
  #------------------------------------------------------------------------------------------------------------------------------------------------------------
  # globalizando uma variavel de conexão
  global $link;
  # determinando o NOME do PA que será chamado (recursivamente) pela função
  $prg=($acao=="Consultar") ? "passagensconsultar.php" : (($acao=="Alterar") ? "passagensalterar.php" : "passagensexcluir.php" ) ;
  # Atribuindo valores em $sair e $menu (variáveis usadas na função que monta a barra de botões) e que devem ser 'transmitidas'
  # para o PA seguinte que executa esta função.
  $sair=$_REQUEST['sair']+1;
  $menu=$_REQUEST['sair'];
  $btacao=($acao=="Consultar") ? "Consultar" : (($acao=="Alterar") ? "Alterar": "Excluir" );  # Consultar-&#x1f50d;&#xfe0e; | Alterar-&#x1f589; | Excluir-&#x1f5f7;
  /* desenhos dos botões:         Lupa                                        Lápis        'X' de excluir */
  printf("  <form action='./$prg' method='POST'>\n");
  printf("  <input type='hidden' name='bloco' value='2'>\n");
  printf("  <input type='hidden' name='sair' value='$sair'>\n");
  # Lendo os dados de medicos para montar uma picklist de escolha da passagem a consultar
  $cmdsql="SELECT pkpassagem, hrsaida, dtcadpassagem FROM passagens as p inner join viagens as v on p.fkviagem = v.pkviagem ORDER BY p.dtcadpassagem";
  //printf("$cmdsql<br>\n");
  $execcmd=mysqli_query($link,$cmdsql);
  printf("<select name='pkpassagem'>\n");
  //$ceespec="";
  while ( $registro=mysqli_fetch_array($execcmd) )
  { # laço para 'montar' as linhas de option da picklist
    printf("<option value='$registro[pkpassagem]'>$registro[hrsaida] - $registro[dtcadpassagem] - 
    ($registro[pkpassagem])</option>\n");
    }
   
  printf("</optgroup>\n");
  printf("</select>\n");
  botoes($acao,TRUE,FALSE);
  # Parametros na ordem: ($acao,$limpar,$voltar,$menu,$sair) - Nome da ação | TRUE ou FALSE | TRUE ou FALSE | saltos para ABERTURA | saltos para SAIR
//printf("<button class='nav' type='submit'                             >$btacao</button>\n");
//printf("<button class='nav' type='button' onclick='history.go(-$menu)'>Abertura</button>\n"); # &#x1f3e0;&#xfe0e;
//printf("<button class='nav' type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # &#x2348;
  printf("  </form>\n");
}
function mostraregistro($CP)
{ #--------------------------------------------------------------------------------------------------------------------------------------------------
  # Função.....: mostraregistro
  # Objetivo...: Receber o valor da Chave Primária da tabela 'passagens' e apresentar os dados do registro em uma tabela HTML.
  # Descricao..: O parâmetro $CP recebe o valor da CP da tabela 'passagens'. A função executa a leitura do registro com um comando SQL de SELEÇÃO.
  #              Os dados do registro são vetorizados na função usando a função de ambiente fetch_array da PHP. A seguir são emitidas as TAGs que
  #              montam uma tabela HTML com os dados. NOTE o comando SQL que tras os dados da tabela... vale a pena estudá-lo.
  # Parametros.: Esta Funcao recebe os parametros:
  #              $CP - valor da chave primária da tabela medicos.
  # Autor......: JMH - Use! Mas fale quem fez!
  # Criação....: 2020-02-10
  # Atualização: 2020-02-10 - Desenvolvimento e teste da funcao.
  #--------------------------------------------------------------------------------------------------------------------------------------------------

  global $link;
  $cmdsql="SELECT * FROM passagens left join viagens as v on passagens.fkviagem = v.pkviagem left join funcionarios as f on passagens.fkfuncionario = f.pkfuncionario WHERE pkpassagem='$CP'";
  //printf("$cmdsql<br>\n");
  $execcmd=mysqli_query($link,$cmdsql);
  $registro=mysqli_fetch_array($execcmd);

  printf("<table>\n");
  printf("<tr><td>Código:</td>      <td>$registro[pkpassagem]</td></tr>\n");
  printf("<tr><td>Código Viagem:</td>        <td>$registro[fkviagem]</td></tr>\n");
  printf("<tr><td>Funcionario:</td>       <td>$registro[txnomecompleto]-($registro[fkfuncionario])</td></tr>\n");
  printf("<tr><td>N&uacute;mero da poltrona:</td>        <td>$registro[nupoltrona]</td></tr>\n");
  printf("<tr><td>Data de viagem:</td> <td>$registro[dtviagem]</td></tr>\n");
  printf("<tr><td>Horário de Saída:</td>        <td>$registro[hrsaida]</td></tr>\n");
  printf("<tr><td>Data de gera&ccedil;&atilde;o:</td>      <td>$registro[dtcadpassagem]</td></tr>\n");
  printf("</table>\n");
}
function montamenu($acao,$sair)
{
  printf("<div class='$acao fixed'>\n");
  printf(" <div class='menu'>\n");
  printf(" <form action='' method='POST'>\n");

  printf("  <input type='hidden' name='sair' value='$sair'>\n");
  printf("<titulo>Passagens</titulo>:\n");
  printf("<button class='Incluir' type='submit' formaction='./passagensincluir.php'  >Incluir</button>\n"); # &#x1f7a5;
  printf("<button class='Alterar' type='submit' formaction='./passagensalterar.php'  >Alterar</button>\n"); # &#x1f589;
  printf("<button class='Excluir' type='submit' formaction='./passagensexcluir.php'  >Excluir</button>\n"); # &#x1f7ac;
  printf("<button class='Consultar' type='submit' formaction='./passagensconsultar.php'>Consultar</button>\n"); # &#x1f50d;&#xfe0e;
  printf("<button class='Listar' type='submit' formaction='./passagenslistar.php'   >Listar</button>\n"); # &#x1f5a8;

  $menu=$sair-1;
  printf(($menu>0) ? "<input class='imp' type='button' value='Abertura' onclick='history.go(-$menu)'>" : "");

  printf("<input class='imp' type='button' value='Sair' onclick='history.go(-$sair)'>\n");
  printf(" </form>\n");
  printf("</div>\n");
  printf("<redbold>$acao</redbold><hr>\n");
  printf("</div>\n<br><br><br>\n");
}

function botoes($acao,$limpar,$voltar)
{
  $barra="";
  $barra=( $acao!="" ) ? $barra."   <input class='imp' type='submit' value='$acao'>" : "";
  $barra=(  $limpar  ) ? $barra."   <input class='imp' type='reset'  value='Limpar'>" : $barra ;
  $barra=(  $voltar  ) ? $barra."   <input class='imp' type='button' value='Voltar' onclick='history.go(-1)'>" : $barra ;
  printf("$barra\n");
}
?>