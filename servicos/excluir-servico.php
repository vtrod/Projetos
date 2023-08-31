<?php
require "connect.php";
require "Servi.php";
require "ServicoRepositorio.php";

$servicoRepositorio = new ServicoRepositorio($pdo);
$servicoRepositorio->excluir($_GET['id']);


?>