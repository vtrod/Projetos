<?php

# Este é um exemplo de um programa recursivo. Neste código-fonte resolvi retirar a maioria dos comentários.
# Referenciando o arquivo catalogo.php e o passagensfuncoes.php
require_once("../../funcoes/catalogo.php");
require_once("./passagensfuncoes.php");
iniciapagina(TRUE,"Passagens","passagens","Excluir");
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
montamenu("Excluir",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
switch (TRUE)
{
  case ($bloco==1):
  { # Executa a função de picklist para escolha do registro a excluir
    picklist("Excluir");
    break;
  }
  case ($bloco==2):
  { # mostra o registro que será excluído e pede confirmação do usuário.
    mostraregistro("$_REQUEST[pkpassagem]");
    printf("<form action='passagensexcluir.php' method='POST'>\n");
    printf(" <input type='hidden' name='bloco' value='3'>\n");
    printf(" <input type='hidden' name='sair' value='$sair'>\n");
    printf(" <input type='hidden' name='pkpassagem' value='$_REQUEST[pkpassagem]'>\n");
	botoes("Excluir",FALSE,TRUE); # Reescrito no arquivo de passagensfuncoes.php. Parâmetros: Ação | Limpar | Voltar
    printf("</form>");
    break;
  }
  case ($bloco==3):
  { # tratamento da transação.
    # construção do comando de atualização.
    $cmdsql="DELETE FROM passagens WHERE passagens.pkpassagem='$_REQUEST[pkpassagem]'";
    # printf("$cmdsql<br>\n");
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laço de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # execução do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluída e não reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro com código $_REQUEST[pkpassagem] excluído!";
      }
      else
      {
        if ( mysqli_errno($link)==1213 )
        { # abortar a trans e reiniciar
          $tenta=TRUE;
        }
        else
        { # abortar a trans e NÃO reiniciar
          $tenta=FALSE;
          $mens=mysqli_errno($link)."-".mysqli_error($link);
        }
        mysqli_query($link,"ROLLBACK");
        $mostrar=FALSE;
      }
    }
    printf("$mens<br>\n");
    break;
  }
}
terminapagina("Passagens","Excluir","passagensexcluir.php");
?> 