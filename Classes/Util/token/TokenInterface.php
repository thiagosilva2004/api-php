<?php

    namespace Util\token;

    interface TokenInterface{
        public function gerarToken(array $dados = []): string;
        public function validarToken(string $token): bool;
    }