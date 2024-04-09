<?php

    namespace App\web\token;

    interface TokenInterface{
        public function gerarToken(array $dados = []): string;
        public function validarToken(string $token): bool;
        public function getDados(string $token, string $dados, int $indice_dados = 0): string;
    }