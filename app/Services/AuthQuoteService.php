<?php

namespace App\Services;

class AuthQuoteService
{
    private $quotes = [
        [
            'quote' =>
            'O Sistema de Controle de Vendas revolucionou a forma como gerencio meu negócio e elaboro propostas incríveis,
                 permitindo que eu me concentre no que faço de melhor: vender.
                 É verdadeiramente a minha solução única para tudo relacionado a vendas!',
            'author' => 'Ana Silva',
            'company' => 'Proprietária da Franquia Vendas Mais',
        ],
        [
            'quote' =>
            'Lidar com os dados de clientes e informações de vendas de centenas de clientes recorrentes era esmagador.
                 O Sistema de Controle de Vendas transformou esse caos em ordem, simplificando muito meu trabalho.',
            'author' => 'Carlos Pereira',
            'company' => 'Gerente de Vendas, Sucesso Comercial',
        ],
        [
            'quote' =>
            'Antes do Sistema de Controle de Vendas, acompanhar as vendas e o inventário era um desafio constante.
                 Agora, tudo está mais organizado e eficiente, o que nos permite focar no crescimento da empresa.',
            'author' => 'Mariana Rodrigues',
            'company' => 'Diretora de Operações, Top Vendas',
        ],
        [
            'quote' =>
            'A ferramenta facilitou a geração de relatórios detalhados, ajudando-nos a tomar decisões estratégicas mais assertivas.
                 Recomendo a todos que buscam otimizar seu processo de vendas.',
            'author' => 'João Santos',
            'company' => 'Consultor de Vendas, Alpha Soluções',
        ],
        [
            'quote' =>
            'O sistema tornou a gestão de produtos e o acompanhamento de vendas muito mais fáceis.
                 A interface intuitiva e os recursos robustos são inestimáveis para nossa equipe de vendas.',
            'author' => 'Beatriz Almeida',
            'company' => 'Coordenadora de Vendas, Vendas Brilhantes',
        ],
    ];

    public function getQuote(): array
    {
        $randomQuote = $this->quotes[array_rand($this->quotes)];
        return $randomQuote;
    }
}
