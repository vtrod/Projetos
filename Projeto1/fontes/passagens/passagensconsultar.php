<?php
require_once("../../funcoes/catalogo.php");
require_once("./passagensfuncoes.php");
iniciapagina(TRUE,"Passagens","passagens","Consultar");
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1;
$sair=$_REQUEST['sair']+1;
$menu=$_REQUEST['sair'];
montamenu("Consultar",$sair);
$bloco=( ISSET($_REQUEST['bloco']) ) ? $_REQUEST['bloco'] : 1 ;
switch (TRUE)
{
  case ($bloco==1):
  {
    picklist("Consultar");
    break;
  }
  case ( $bloco==2 ):
  {
    mostraregistro("$_REQUEST[pkpassagem]");
    botoes("",FALSE,TRUE);
    break;
  }
}
terminapagina("Passagens","Consultar","passagensconsultar.php");
 ?>