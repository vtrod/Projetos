<?php

require_once("../../funcoes/catalogo.php");
require_once("./passagensfuncoes.php");
# Neste PA o menu deve ser montado nos blocos 1 e 2... a execução do bloco 3 acontece SEM a montagem do menu
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
$bloco=( ISSET($_POST['bloco']) ) ? $_POST['bloco'] : 1;
$cordefundo=($bloco<3) ? TRUE : FALSE;
iniciapagina($cordefundo,"Passagens","passagens","Listar");
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
#
# Com o comando a seguir se faz a execução seletiva dos blocos de comandos: montagem do form e Montagem da Listagem.
switch (TRUE)
{
  case ( $bloco==1 ):
  { # este bloco monta o form e passa o bloco para o valor 2 em modo oculto
    # Aqui se executa a função montamenu(). O menu deve ser apresentado nos 'cases' 1 e 2... o 'case' deve exibir a listagem SEM o menu.
    montamenu("Listar","$sair");
    printf(" <form action='./passagenslistar.php' method='post'>\n");
    printf("  <input type='hidden' name='bloco' value=2>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table>\n");
    printf("   <tr><td colspan=2>Escolha a <b>ordem</b> como os dados serão exibidos no relatório:</td></tr>\n");
    printf("   <tr><td>Código da Passagem.:</td><td>(<input type='radio' name='ordem' value='passagens.pkpassagem'>)</td></tr>\n");
    printf("   <tr><td>Data da Passagem...:</td><td>(<input type='radio' name='ordem' value='passagens.dtpassagem' checked>)</td></tr>\n");
    printf("   <tr><td colspan=2>Escolha valores para selação de <b>dados</b> do relatório:</td></tr>\n");
    printf("   <tr><td>Escolha uma viagem:</td><td>");
    $cmdsql="SELECT pkviagem,dtviagem FROM viagens ORDER BY dtviagem";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkviagem'>");
    printf("<option value='TODAS'>Todas</option>");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkviagem]'>$reg[dtviagem]-($reg[pkviagem])</option>");
    }
    printf("<select>\n");
    printf("</td></tr>\n");
    $dtini="1901-01-01";
    $dtfim=date("Y-m-d");
    printf("<tr><td>Intervalo de datas de cadastro:</td><td><input type='date' name='dtcadini' value='$dtini'> até <input type='date' name='dtcadfim' value='$dtfim'></td></tr>");
    printf("   <tr><td></td><td>");
    botoes("Listar",FALSE,TRUE); # Reescrito no arquivo de passagensfuncoes.php. Parâmetros: Ação | Limpar | Voltar
    #printf("<button type='submit'>Listar</button>\n"); # - <font size=6>&#x1f5a8;</font>
    #printf("<button type='button' onclick='history.go(-1)'><font size=5>&#x2397;</font></button>\n");
    #printf("<button type='button' onclick='history.go(-$menu)'>Abertura</button>\n"); # - <font size=5>&#x1f3e0;&#xfe0e;</font>
    #printf("<button type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # - <font size=5>&#x2348;</font>
    printf("</td></tr>\n");
    printf("  </table>\n");
    printf(" </form>\n");
    break;
  }
  case ( $bloco==2 || $bloco==3 ):
  { # Este bloco vai processar a junção de passagens com instituicaoensino, logradouroscompletos (moradia e clinica) e especiaidadesmedicas.
    # Depois monta a tabela com os dados e a seguir um form permitindo que a listagem seja exibida para impressão em uma nova aba.
    $selecao=" WHERE (passagens.dtcadpassagem between '$_REQUEST[dtcadini]' and '$_REQUEST[dtcadfim]')";
    $selecao=( $_REQUEST['fkviagem']!='TODAS' ) ? $selecao." AND v.fkviagem='$_REQUEST[fkviagem]'" : $selecao ;
	# Na base de dados de exemplo existe a implementação de uma visão que faz toda as junções necessárias de 'passagens' e as tabelas relacionadas.
	# Consulte o item de VIEWS da base e veja o código que define 'passagenstotal'.
    $cmdsql="SELECT * FROM passagens left join viagens as v on passagens.fkviagem = v.pkviagem left join funcionarios as f on passagens.fkfuncionario = f.pkfuncionario".$selecao." ORDER BY $_REQUEST[ordem]";
  #  printf("<br><br><br><br>$cmdsql<br>\n");
	# Lendo os dados do banco de dados.
    $execsql=mysqli_query($link,$cmdsql);
    # SE o bloco de execução for 2, então o menu DEVE aparecer no topo da tela.
    ($bloco==2) ? montamenu("Listar","$sair") : "";
	# O operador ternário foi usado acima de um modo 'diferente' executando uma função de modo condicional
	# Abaixo se inicia a construção da tabela com os dados lidos. A Listagem NÃO terá um contador de linhas para formatar os saltos de páginas...
	# Mas isso até que seria interessante implementar... Talvez...
    printf("<table border=1 style=' border-collapse: collapse; '>\n");
	# Aqui se monta o cabeçalho da tabela. Note que existe uma linha dupla para mostrar os dados de clinica e moradia 'agrupados'.
    printf(" <tr><td valign=top rowspan=2>Cod.</td>\n");
    printf("     <td valign=top colspan=2>Viagem</td>\n");
    printf("     <td valign=top colspan=1>Funcionário</td>\n");
    printf("     <td valign=top rowspan=2>Poltrona</td>\n");
    printf("     <td valign=top rowspan=2>Dt. Passagem</td>\n");
    printf("     <td valign=top rowspan=2>Dt. Registro</td></tr>\n");
    printf(" <tr><td valign=top>Data:</td>\n");
    printf("     <td valign=top>Hora de Saída:</td>\n");
    printf("     <td valign=top>Nome:</td></tr>\n");
	# Terminando o 'cabeçalho' segue o corpo da listagem com os dados. Esta listagem será Zebrada com as cores branca e lightgreen
    $corlinha="White";
    while ( $le=mysqli_fetch_array($execsql) )
    {
      printf("<tr bgcolor=$corlinha><td>$le[pkpassagem]</td>\n");
      printf("   <td valign=top>$le[dtviagem]-($le[fkviagem])</td>\n");
      printf("   <td valign=top>$le[hrsaida]</td>\n");
	  # campos de 'passagens' que são chaves estrangeiras são exibidos com seus 'campos descritivos'.
      printf("   <td valign=top>$le[txnomecompleto]-($le[fkfuncionario])</td>\n");
      printf("   <td valign=top>$le[nupoltrona]</td>\n");
      printf("   <td valign=top>$le[dtpassagem]</td>\n");
	  # A data é exibida no formato AAAA-MM-DD. Pode deixar assim ou trabalhar com a função SUBSTRING() para exibir em outro formato.
      printf("   <td valign=top>$le[dtcadpassagem]</td></tr>\n");
      $corlinha=( $corlinha=="White" ) ? "lightgreen" : "White"; # Navajowhite | lightblue 
    }
    printf("</table>\n");
    if ( $bloco==2 )
    { # Aqui se monta o form que é apresentado no final da listagem permitindo a escolha de emitir a mesma listagem em nova aba SEM o MENU.
      printf("<form action='./passagenslistar.php' method='POST' target='_NEW'>\n");
      printf(" <input type='hidden' name='bloco' value=3>\n");
      printf(" <input type='hidden' name='sair' value='$sair'>\n");
      printf(" <input type='hidden' name='fkviagem' value=$_REQUEST[fkviagem]>\n");
      printf(" <input type='hidden' name='dtcadini' value=$_REQUEST[dtcadini]>\n");
      printf(" <input type='hidden' name='dtcadfim' value=$_REQUEST[dtcadfim]>\n");
      printf(" <input type='hidden' name='ordem' value=$_REQUEST[ordem]>\n");
      botoes("Imprimir",FALSE,TRUE); # Reescrito no arquivo de passagensfuncoes.php. Parâmetros: Ação | Limpar | Voltar
      printf("</form>\n");
    }
    else
    {
      printf("<hr>\n<button class='imp' type='submit' onclick='window.print();'>Imprimir</button> - Corte a folha na linha acima.\n");
    }
    break;
  }
}
terminapagina("Passagens","Listar","passagenslistar.php");
?>