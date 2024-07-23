<?php

namespace App\Services;

class AuthQuoteService
{
    private $quotes = [
        [
            'quote' =>
            'O Sistema de Controle de Transações Financeiras simplificou o gerenciamento das minhas finanças pessoais.
                 Agora, posso categorizar despesas e receitas facilmente e ter uma visão clara do meu orçamento.',
            'author' => 'Ana Silva',
            'company' => 'Usuária Pessoal',
        ],
        [
            'quote' =>
            'Antes do Sistema de Controle de Transações, era difícil acompanhar as entradas e saídas de dinheiro da minha empresa.
                 Este sistema trouxe mais organização e eficiência, permitindo-me focar em estratégias de crescimento.',
            'author' => 'Carlos Pereira',
            'company' => 'Empresário, Sucesso Financeiro',
        ],
        [
            'quote' =>
            'O sistema transformou a maneira como gerencio minhas finanças empresariais. Agora, tudo está bem categorizado e fácil de acessar,
                 o que me ajuda a tomar decisões financeiras mais informadas.',
            'author' => 'Mariana Rodrigues',
            'company' => 'Diretora Financeira, Crescimento Certo',
        ],
        [
            'quote' =>
            'Com o Sistema de Controle de Transações, a geração de relatórios detalhados se tornou muito mais simples.
                 Isso me ajuda a ter uma visão clara das minhas finanças e a tomar decisões mais estratégicas.',
            'author' => 'João Santos',
            'company' => 'Consultor Financeiro, Alpha Finanças',
        ],
        [
            'quote' =>
            'A gestão de despesas e receitas ficou muito mais fácil com este sistema. A interface intuitiva e os recursos robustos
                 são inestimáveis para o meu controle financeiro pessoal.',
            'author' => 'Beatriz Almeida',
            'company' => 'Usuária Pessoal',
        ],
    ];

    public function getQuote(): array
    {
        $randomQuote = $this->quotes[array_rand($this->quotes)];
        return $randomQuote;
    }
}

