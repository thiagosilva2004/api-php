<?php

namespace App\web\token;

use stdClass;

class TokenJWT implements TokenInterface
{
    private int $duracao; // duracao do token em segundo
    private string $chave;
    private array $header;
    private string $iss;
    private string $aud;

    public function __construct(
        string $chave,
        string $iss,
        string $aud,
        $header = ['alg' => 'HS256', 'typ' => 'JWT'],
        int $duracao = 6048000,
    ) {
        $this->duracao = time() + $duracao;
        $this->chave = $chave;
        $this->header = $header;
        $this->iss = $iss;
        $this->aud = $aud;
    }

    public function gerarToken(array $dados = []): string
    {
        $header = json_encode($this->header);

        $header = base64_encode($header);

        $payload = [
            'iss' => $this->iss,
            'aud' => $this->aud,
            'exp' => $this->duracao,
            'dados' =>  $dados,
        ];

        $payload = json_encode($payload);

        $payload = base64_encode($payload);

        $signature = hash_hmac('sha256', "$header.$payload", $this->chave, true);

        $signature = base64_encode($signature);

        return "$header.$payload.$signature";
    }

    function validarToken(string $token): bool
    {
        $token_array = explode('.', $token);

        if(!is_array($token_array) || count($token_array) < 3){
            return false;
        }

        $header = $token_array[0];
        $payload = $token_array[1];
        $signature = $token_array[2];

        $validar_assinatura = hash_hmac('sha256', "$header.$payload", $this->chave, true);

        $validar_assinatura = base64_encode($validar_assinatura);

        if ($signature !== $validar_assinatura) {
            return false;
        }

        $dados_token = base64_decode($payload);

        $dados_token = json_decode($dados_token);

        if ($dados_token->exp < time()) {
            return false;
        }

        return true;
    }

    public function getPayload(string $token): stdClass
    {
        $token_array = explode('.', $token);

        $payload = $token_array[1];

        $dados_token = base64_decode($payload);

        $dados_token = json_decode($dados_token);

        return $dados_token;
    }

    public function getDados(string $token, string $dados, int $indice_dados = 0): string
    {
        $token_array = explode('.', $token);

        $payload = $token_array[1];

        $payload = base64_decode($payload);

        $payload = json_decode($payload);

        if (isset($payload->dados[$indice_dados]->$dados)) {
            return $payload->dados[$indice_dados]->$dados;
        } else {
            return '';
        }
    }

    public function getDuracao(): int
    {
        return $this->duracao;
    }

    public function setDuracao(int $duracao): void
    {
        $this->duracao = time() + $duracao;
    }

    public function getHeader(): array
    {
        return $this->header;
    }

    public function setHeader(array $header): void
    {
        $this->header = $header;
    }

    public function getIss(): string
    {
        return $this->iss;
    }

    public function setIss(string $iss): void
    {
        $this->iss = $iss;
    }

    public function getAud(): string
    {
        return $this->aud;
    }

    public function setAud($aud): void
    {
        $this->aud = $aud;
    }
}
