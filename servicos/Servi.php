<?php

use PhpParser\Node\Expr\Cast\Double;

class Servi
{
    //private ?int $id_servico;

    private string $nome_servico;

    private string $duracao_servico;

    private string $fx_agenda_servico;

    private string $freq_recomendada_servico;

    private string $descricao_servico;

    private float $preco;



    public function __construct(string $nome_servico, string $duracao_servico, string $fx_agenda_servico, string $freq_recomendada_servico, string $descricao_servico, float $preco)
    {
        //$this->id_servico = $id_servico;
        $this->nome_servico = $nome_servico;
        $this->duracao_servico = $duracao_servico;
        $this->fx_agenda_servico = $fx_agenda_servico;
        $this->freq_recomendada_servico = $freq_recomendada_servico;
        $this->descricao_servico = $descricao_servico;
        $this->preco = $preco;
    }


    //public function getIdServico(): int
    //{
    //return $this->id_servico;
    //}

    public function getNomeServico(): string
    {
        return $this->nome_servico;
    }

    public function getDuracaoServico(): string
    {
        return $this->duracao_servico;
    }

    public function getFxAgendaServico(): string
    {
        return $this->fx_agenda_servico;
    }

    public function getFreqRecomendadaServico(): string
    {
        return $this->freq_recomendada_servico;
    }

    public function getDescricaoServico(): string
    {
        return $this->descricao_servico;
    }


    public function getPreco(): float
    {
        return $this->preco;
    }



}

?>