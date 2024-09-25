<?php

namespace App\Services;

class AuthQuoteService
{
    private $quotes = [
        [
            'quote' => 'Chega de planilhas complicadas e desorganizadas. Com o quantofoi eu e meu marido conseguimos
                 gerenciar nossas finanças pessoais de forma simples e eficiente.',
            'author' => 'Maria Santos',
            'company' => 'Usuária Pessoal',
        ],
        [
            'quote' =>
            'O quantofoi simplificou o gerenciamento das minhas finanças pessoais.
                 Agora, posso categorizar despesas e receitas facilmente e ter uma visão clara do meu orçamento.',
            'author' => 'Ana Silva',
            'company' => 'Usuária Pessoal',
        ],
        [
            'quote' =>
            'Antes do quantofoi era difícil acompanhar as entradas e saídas de dinheiro da minha empresa.
                 Este sistema trouxe mais organização e eficiência, permitindo-me focar em estratégias de crescimento.',
            'author' => 'Carlos Pereira',
            'company' => 'Usuária Pessoal',
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

