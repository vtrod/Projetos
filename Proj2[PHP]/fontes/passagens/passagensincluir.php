<?php
require_once("../../funcoes/catalogo.php");
# Referenciando o arquivo instensinoniveiseducfuncoes.php
require_once("./passagensfuncoes.php");
# Determinando $bloco
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
# monstrando o valor de $bloco em cada execuÃ§Ã£o
# printf("$bloco<br>$sair<br>$menu\n");
iniciapagina(TRUE,"Passagens","passagens","Incluir");
montamenu("Incluir",$sair);
# printf("\$bloco = $bloco<br>\$sair = $sair<br>\$menu = $menu\n");
# As variÃ¡veis $bloco, $sair e $menu devem ser 'transmitidas' entre os PA sempre em campos de formulÃ¡rios em modo 'hidden'.
# Se for necessÃ¡rio verificar se algum form passa corretamente os valores em modo recursivo, RETIRE o comentÃ¡rio da linha no inÃ­cio deste bloco de comentÃ¡rio.
# Este comando printf() estÃ¡ escrito depois da execuÃ§Ã£o da funÃ§Ã£o montamenu porque o menu Ã© exibido em uma <DIV> no topo da tela.
###############################################################################################################################################################
# Com o comando a seguir se faz a execuÃ§Ã£o seletiva dos blocos de comandos: montagem do form e controle da transaÃ§Ã£o com base no valor de $bloco.
switch (TRUE)
{
  case ($bloco==1):
  { # montando o form
    
    printf("  <form action='passagensincluir.php' method='POST'>\n");
    printf("  <input type='hidden' name='bloco' value='2'>\n");
    printf("  <input type='hidden' name='sair' value='$sair'>\n");
    printf("  <table>\n");
    printf("   <tr><td>Código:</td>         <td>O Código será gerado pelo Sistema</td></tr>\n");
    
    # Montando a Picklist para a seleção de viagem (tabela: passagens)
    printf("<tr><td>Viagem:</td>     <td>");
    $cmdsql="SELECT pkviagem, dtviagem from viagens order by dtviagem";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkviagem'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkviagem]'>$reg[dtviagem]-($reg[pkviagem])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");

    printf("<tr><td>Funcionário:</td>     <td>");
    $cmdsql="SELECT pkfuncionario, txnomecompleto from funcionarios order by txnomecompleto";
    $execcmd=mysqli_query($link,$cmdsql);
    printf("<select name='fkfuncionario'>\n");
    while ( $reg=mysqli_fetch_array($execcmd) )
    {
      printf("<option value='$reg[pkfuncionario]'>$reg[txnomecompleto]-($reg[pkfuncionario])</option>");
    }
    printf("</select>\n");
    printf("</td></tr>\n");
    # Montando a Picklist para viagem (tabela: viagens)
    
      
    printf("   <tr><td>Poltrona:</td>  <td><input type='text' name='nupoltrona' placeholder='Apenas numeros' size='13' maxlenght='13'></td></tr>\n");
    printf("   <tr><td>Data da Passagem:</td>  <td><input type='date' name='dtpassagem'></td></tr>\n");
    printf("   <tr><td>Data de Registro:</td>  <td><input type='date' name='dtcadpassagem'></td></tr>\n");
    printf("   <tr><td></td>                <td>");
    botoes("Incluir",TRUE,FALSE);
    printf("<tr><td></td>                                        <td><hr></td></tr>\n");
    # Reescrito no arquivo de instensinoniveiseducfuncoes.php. ParÃ¢metros: AÃ§Ã£o | Limpar | Voltar
#1 botoes($acao,$limpar,$voltar) Estes sÃ£o os parÃ¢metros de chamada da funÃ§Ã£o botÃµes
#2 Os comandos que montam as TAGS de montagem dos botÃµes de navegaÃ§Ã£o foram 'migradas' para a funÃ§Ã£o botoes().
#3 Note que alguns botÃµes foram muigrados para a funÃ§Ã£o montamenu().
#4 Ao desenvolver o SEU PA estas linhas de comentÃ¡rios 'numerados' podem ser removidas
    //printf("<button class='nav' type='submit'                             >Salvar</button>\n"); # <font size=5>&#x1f5f9;</font>
    //printf("<button class='nav' type='reset'                              >Limpar</button>\n"); # <font size=5>&#x2b6e;</font>
    //printf("<button class='nav' type='button' onclick='history.go(-$menu)'>Abertura</button>\n"); # <font size=5>&#x1f3e0;&#xfe0e;</font>
    //printf("<button class='nav' type='button' onclick='history.go(-$sair)'>Sair</button>\n"); # <font size=5>&#x2348;</font>
    printf("</td></tr>\n");
    printf("  </table>\n");
    printf("  </form>\n");
    break;
  }
  case ($bloco==2):
  { # Tratamento da transaÃ§Ã£o.
    # lendo os valores digitados nos campos do form
    # a transaÃ§Ã£o se inicia com o comando: START TRANSACTION
    # a transaÃ§Ã£o deve ser executada 'dentro' de um laÃ§o de repetiÃ§Ã£o.
    $mostrar=FALSE;
    $tenta=TRUE;
    while ( $tenta )
    { # laÃ§o de controle de exec da trans.
      mysqli_query($link,"START TRANSACTION");
      # ConstruÃ§Ã£o do comando de atualizaÃ§Ã£o. Isso deve ser feito '' da transaÃ§Ã£o porque, se algo der errado na atualizaÃ§Ã£o, outro nÃºmero da CP deve ser criado.
      # RecuperaÃ§Ã£o do Ãºltimo valor gravado na PK da tabela Usando a funÃ§Ã£o MAX (SQL) e as funÃ§Ãµes PHP '_query' e '_fetch_array' combinadas.
      $ultimacp=mysqli_fetch_array(mysqli_query($link,"SELECT MAX(pkpassagem) AS CpMAX FROM passagens"));
      $CP=$ultimacp['CpMAX']+1;
      # ConstruÃ§Ã£o do comando de atualizaÃ§Ã£o.
      $cmdsql="INSERT INTO passagens (pkpassagem,fkviagem,fkfuncionario,nupoltrona,dtpassagem,
      dtcadpassagem)
                                VALUES ('$CP',
                                '$_REQUEST[fkviagem]',
                                '$_REQUEST[fkfuncionario]',
                                '$_REQUEST[nupoltrona]',
                                '$_REQUEST[dtpassagem]',
                                '$_REQUEST[dtcadpassagem]')";
      # printf("$cmdsql<br>\n");
      # execuÃ§Ã£o do cmd.
      mysqli_query($link,$cmdsql);
      # tratamento dos erros de exec do cmd.
      if ( mysqli_errno($link)==0 )
      { # trans pode ser concluÃ­da e nÃ£o reiniciar
        mysqli_query($link,"COMMIT");
        $tenta=FALSE;
        $mostrar=TRUE;
        $mens="Registro incluído!";
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
    { # mostraregistro incova botoes que recebe os parÃ¢metros ($acao,$clear,$voltar,$menu,$sair)
      mostraregistro("$CP",);
      # como colocamos os botoes de Pular para Abertura e Sair do Sistema na barra do menu, entÃ£o precisamos mais executar nada da funÃ§Ã£o botoes().
    }
    break;
  }
}
terminapagina("Passagens","Incluir","passagensincluir.php");
?> 