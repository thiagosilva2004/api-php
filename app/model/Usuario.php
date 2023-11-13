<?php

    namespace App\model;

    use App\Util\Enums\TipoUsuario;

    class Usuario{
        public function __construct(
            private int $id = 0,
            private string $email = '',
            private string $senha = '',
            private string $nome = '',
            private TipoUsuario $tipo = TipoUsuario::CLIENTE 
        ){

        }
    }