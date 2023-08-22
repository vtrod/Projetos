<?php
require_once("../../funcoes/catalogo.php");
require_once("./passagensfuncoes.php");
iniciapagina(TRUE,"Passagens","passagens","Alterar");
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
montamenu("Alterar",$sair);
switch (TRUE)
{
  case ($bloco==1):
  {
    picklist("Alterar");
    break;
  }
  case ($bloco==2):
  { 
    $reglido=mysqli_fetch_array(mysqli_query($link,"SELECT * FROM passagens WHERE pkpassagem='$_REQUEST[pkpassagem]'"));
    printf("<form action='passagensalterar.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    printf(" <input type='hidden' name='pkpassagem' value='$_REQUEST[pkpassagem]'>\n");
    printf("<table>");
    printf("<tr><td>Viagem:</td>     <td>");
    $cmdsql="SELECT pkviagem,dtviagem from viagens order by dtviagem";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkviagem'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      $selected=( $reg['pkviagem']==$reglido['fkviagem'] ) ? " SELECTED": "" ;
      printf("<option value='$reg[pkviagem]'$selected>$reg[dtviagem]-($reg[pkviagem])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    printf("<tr><td>Funcionário:</td><td>");
    $cmdsql="SELECT pkfuncionario,txnomecompleto from funcionarios order by txnomecompleto";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkfuncionario'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      $selected=( $reg['pkfuncionario']==$reglido['fkfuncionario'] ) ? " SELECTED": "" ;
    printf("<option value='$reg[pkfuncionario]'$selected>$reg[txnomecompleto]-($reg[pkfuncionario])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    
    printf("<tr><td>Poltrona:</td>                   <td><input type='text' name='nupoltrona' value='$reglido[nupoltrona]' size='8' maxlength='8'></td></tr>\n");
    printf("<tr><td>Data da Passagem:</td>                   <td><input type='date' name='dtpassagem' value='$reglido[dtpassagem]'></td></tr>\n");
    printf("<tr><td></td>                   <td><hr></td></tr>\n");
    printf("<tr><td>Data de Registro:</td>       <td><input type='date' name='dtcadpassagem' value='$reglido[dtcadpassagem]'></td></tr>\n");
    # Aqui termina a montagem dos campos preenchidos com os dados para alteraÃ§Ã£o. Vamos montar a barra de botÃµes
    # Note a barra de botÃµes deve ser montada na coluna da direita da tabela.
    printf("<tr><td></td><td>");
	botoes("Alterar",TRUE,TRUE); # Reescrito no arquivo de medicosfuncoes.php. ParÃ¢metros: AÃ§Ã£o | Limpar | Voltar
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
    $cmdsql="UPDATE passagens
                    SET 
                        fkviagem             = '$_REQUEST[fkviagem]',
                        fkfuncionario        = '$_REQUEST[fkfuncionario]',
                        nupoltrona           = '$_REQUEST[nupoltrona]',
                        dtpassagem        = '$_REQUEST[dtpassagem]',
                        dtcadpassagem  = '$_REQUEST[dtcadpassagem]'
                    WHERE
                        pkpassagem='$_REQUEST[pkpassagem]'";
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
        $mens="Registro com código $_REQUEST[pkpassagem] Alterado!";
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
      mostraregistro("$_REQUEST[pkpassagem]");
    }
    break;
  }
}
terminapagina("Passagens","Alterar","passagensalterar.php");
?>