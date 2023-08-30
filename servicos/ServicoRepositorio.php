<?php
    class ServicoRepositorio
    {
        private PDO $pdo;

        public function __construct(PDO $pdo)
        {
            $this->pdo = $pdo;
        }

        private function formarObjeto($dados)
        {
            return new Servi(
                             $dados['nome_servico'],
                             $dados['duracao_servico'],
                             $dados['fx_agenda_servico'],
                             $dados['freq_recomendada_servico'],
                             $dados['descricao_servico'],
                             $dados['preco']
            );
        }

        public function salvarServico(Servi $servico)
        {
            $sql = "INSERT INTO servico (nome_servico, duracao_servico, fx_agenda_servico, freq_recomendada_servico, descricao_servico, preco) VALUES (?,?,?,?,?,?)";
            $statement = $this->pdo->prepare($sql);
            //$statement->bindValue(1, $servico->getIdServico());
            $statement->bindValue(1, $servico->getNomeServico());
            $statement->bindValue(2, $servico->getDuracaoServico());
            $statement->bindValue(3, $servico->getFxAgendaServico());
            $statement->bindValue(4, $servico->getFreqRecomendadaServico());
            $statement->bindValue(5, $servico->getDescricaoServico());
            $statement->bindValue(6, $servico->getPreco());
            $statement->execute();
        }


        public function exibirTodos(){

            $sql = "SELECT * FROM servico";
            $statement = $this->pdo->query($sql);
            $dados = $statement->fetchAll(PDO::FETCH_ASSOC);

            $todosOsDados = array_map(function ($servico){
                return $this->formarObjeto($servico);
            },$dados);
            return $todosOsDados;

        }


    public function buscar(string $nome_servico)
    {
        $sql = "SELECT * FROM servico WHERE nome_servico = ?";
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(1, $nome_servico);
        $statement->execute();

        $dados = $statement->fetch(PDO::FETCH_ASSOC);

        return $this->formarObjeto($dados);
    }



    }
?>