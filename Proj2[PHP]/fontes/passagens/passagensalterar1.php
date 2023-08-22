<?php
# Referenciando o arquivo catalogo.php
require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo movimentosfuncoes.php
require_once("./movimentosfuncoes.php");
iniciapagina(TRUE,"Movimentos","movimentos","Alterar");
# Determinando variÃ¡veis de controle: $bloco $menu e $sair
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
# Executando funÃ§Ã£o que monta o menu no topo da tela
montamenu("Alterar",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
#
# Com o comando a seguir se faz a execuÃ§Ã£o seletiva dos blocos de comandos: montagem do form e controle da transaÃ§Ã£o com base no valor de $bloco.
switch (TRUE)
{
  case ($bloco==1):
  { # NESTE case a picklist monta a tela com a caixa de seleÃ§Ã£o para escolha do registro.
    picklist("Alterar");
    break;
  }
  case ($bloco==2):
  { # NESTE case se faz a leitura do registro da tabela movimentos, com o registro lido se monta um formulÃ¡rio com os dados nos campos para ediÃ§Ã£o.
    #
    # Lendo o registro da tabela 'movimentos'
    # Note que neste comando se executa o '_fetch_query()' dentro do '_fetch_array()'. O '_fetch_query()' retorna somente UMA linha pois consulta
    # o registro pela chave primÃ¡ria da tabela. EntÃ£o o '_fetch_array()' sÃ³ precisa 'vetorizar' um registro para $reg[]. 
    $reglido=mysqli_fetch_array(mysqli_query($link,"SELECT * FROM movimentos WHERE pkmovimento='$_REQUEST[pkmovimento]'"));
    # montando o form. O form deve 'passar' o valor do cÃ³digo do movimento em modo OCULTO (hidden).
    printf("<form action='movimentosalterar.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    printf(" <input type='hidden' name='pkmovimento' value='$_REQUEST[pkmovimento]'>\n");
	# Os campos do form devem aparecer na coluna da DIREITA de uma tabela.
    # Na coluna da ESQUERDA se exibe os textos que devem orientar o usuÃ¡rio na digitaÃ§Ã£o de valores nos campos.
    # Os campos do form podem ser preenchidos com os valores do registro de mÃ©dicos atravÃ©s do uso do atributo HTML 'value'.
    printf("<table>");

    # Montando a Picklist para a Especialidade MÃ©dica (tabela:especmedicas)
	# a cx de seleÃ§Ã£o deve 'mostrar' a linha com a escolha prÃ© estabelecida no valor da chave primÃ¡ria da tabela especmedicas
    # (gravada no valor da chave estrangeira em mÃ©dicos - que estÃ¡ no vetor $reglido[fkespecialidade].
    # NOTE entÃ£o a comparaÃ§Ã£o $reglido[fkespecialidade]==$reg[pkespecialidade] atribuindo valor na variÃ¡vel $seleted
    # Esta comparaÃ§Ã£o deve ser feita 'dentro' do laÃ§o de repetiÃ§Ã£o que monta as linhas da cx de seleÃ§Ã£o.
    printf("<tr><td>Livro:</td>     <td>");
    $cmdsql="SELECT pklivro,txtituloacervo from livros order by txtituloacervo";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fklivro'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    { # LaÃ§o de RepetiÃ§Ã£o montando as linhas da Cx de SeleÃ§Ã£o
      # Eis o comando que verifica se existe igual entre $reglido[fkespecialidade] e $reg[pkespecialidade]. Se sim coloca "SELETED" na variÃ¡vel.
      $selected=( $reg['pklivro']==$reglido['fklivro'] ) ? " SELECTED": "" ;
      printf("<option value='$reg[pklivro]'$selected>$reg[txtituloacervo]-($reg[pklivro])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");

    printf("<tr><td>Funcionário:</td>     <td>");
    $cmdsql="SELECT pkfuncionario,txnomecompleto from funcionarios order by txnomecompleto";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkfuncionario'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    { # LaÃ§o de RepetiÃ§Ã£o montando as linhas da Cx de SeleÃ§Ã£o
      # Eis o comando que verifica se existe igual entre $reglido[fkfuncionario] e $reg[pkfuncionario]. Se sim coloca "SELETED" na variÃ¡vel.
      $selected=( $reg['pkfuncionario']==$reglido['fkfuncionario'] ) ? " SELECTED": "" ;
      printf("<option value='$reg[pkfuncionario]'$selected>$reg[txnomecompleto]-($reg[pkfuncionario])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td>Data do Movimento</td>   <td><input type='datetime-local' name='dtmovimento' value='$reglido[dtmovimento]'></td></tr>\n");
    # Note: TODA a cx de seleÃ§Ã£o foi 'montada' na coluna da direita da tabela.
	# Daqui para frente, praticamente acontece a repetiÃ§Ã£o do segmento de cÃ³digo anterior.
    #
    # Montando a Picklist para a Escola de FormaÃ§Ã£o do MÃ©dico (tabela:escolas)
    printf("<tr><td>Tipo de Movimento:</td><td>");
    $cmdsql="SELECT pktipomovimento,txnometipomov from movimentostipos order by txnometipomov";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fktipomovimento'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      $selected=( $reg['pktipomovimento']==$reglido['fktipomovimento'] ) ? " SELECTED": "" ;
    printf("<option value='$reg[pktipomovimento]'$selected>$reg[txnometipomov]-($reg[pktipomovimento])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td>Previsão de Devolução</td>   <td><input type='date' name='dtprevistadevolucao' value='$reglido[dtprevistadevolucao]'></td></tr>\n");
    printf("<tr><td>Data real de Devolução</td>   <td><input type='date' name='dtrealdevolucao' value='$reglido[dtrealdevolucao]'></td></tr>\n");
    printf("<tr><td></td>                   <td><hr></td></tr>\n");
    printf("<tr><td>Cadastro em:</td>       <td><input type='date' name='dtcadmovimento' value='$reglido[dtcadmovimento]'></td></tr>\n");
    # Aqui termina a montagem dos campos preenchidos com os dados para alteraÃ§Ã£o. Vamos montar a barra de botÃµes
    # Note a barra de botÃµes deve ser montada na coluna da direita da tabela.
    printf("<tr><td></td><td>");
	botoes("Alterar",TRUE,TRUE); # Reescrito no arquivo de movimentosfuncoes.php. ParÃ¢metros: AÃ§Ã£o | Limpar | Voltar
    printf("</td></tr>\n");
    printf("</table>");
    printf("</form>");
    break;
  }
  case ($bloco==3):
  { # tratamento da transaÃ§Ã£o.
    # Este bloco Ã© muito semelhante so outros blocos de tratamento de transaÃ§Ã£o que jÃ¡ vimos.
    # PORÃ‰M o bloco de INSERT tem o comando montado DENTRO da transaÃ§Ã£o.
    # Por este motivo este segmento de cÃ³digo nÃ£o precisa ser 'migrado' para uma funÃ§Ã£o 'local'
    # construÃ§Ã£o do comando de atualizaÃ§Ã£o.
    $cmdsql="UPDATE movimentos
                    SET fklivro         = '$_REQUEST[fklivro]',
                        fkfuncionario      = '$_REQUEST[fkfuncionario]',
                        dtmovimento                = '$_REQUEST[dtmovimento]',
                        fktipomovimento           = '$_REQUEST[fktipomovimento]',
                        dtprevistadevolucao        = '$_REQUEST[dtprevistadevolucao]',
                        dtrealdevolucao  = '$_REQUEST[dtrealdevolucao]',
                        dtcadmovimento = '$_REQUEST[dtcadmovimento]'
                    WHERE
                        pkmovimento='$_REQUEST[pkmovimento]'";
    # printf("$cmdsql<br>\n");
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laÃ§o de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # execuÃ§Ã£o do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluÃ­da e nÃ£o reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro com Código $_REQUEST[pkmovimento] Alterado!";
      }
      else
      {
        if ( mysqli_errno($link)==1213 )
        { # abortar a trans e reiniciar
          $tenta=TRUE;
        }
        else
        { # abortar a trans e NÃƒO reiniciar
          $tenta=FALSE;
          $mens=mysqli_errno($link)."-".mysqli_error($link);
        }
        mysqli_query($link,"ROLLBACK");
        $mostrar=FALSE;
      }
    }
    printf("$mens<br>\n");
    if ( $mostrar )
    {
      mostraregistro("$_REQUEST[pkmovimento]");
    }
    break;
  }
}
terminapagina("Passagens","Alterar","passagensalterar.php");
?>