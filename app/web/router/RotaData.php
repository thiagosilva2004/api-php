<?php

namespace App\web\router;

use App\web\request\RequestType;
use App\web\router\exception\ExceptionGetDataFromInvalidUri;

class RotaData
{
    public function __construct(
        private RotaComparator $rotaComparator
    ){}

    public function getUri(): string
    {
        return str_replace('/' . $_ENV['DIR_PROJETO'], '', $_SERVER['REQUEST_URI']);
    }

    public function getRequestType(): RequestType
    {
        return RequestType::getType($_SERVER['REQUEST_METHOD']);
    }

    /**
     * @throws ExceptionGetDataFromInvalidUri
     */
    public function getDataRota(RotaSchema $rota): array
    {
        if(!$this->rotaComparator->compare($rota)){
            throw new ExceptionGetDataFromInvalidUri(
                $this->rotaComparator->getUri(),
                $rota->uri,
                "can't get data from uris invalids"
            );
        }

        $index = 0;
        $response = [];

        if (substr_count($this->rotaComparator->getUri(), '/') !== substr_count($rota->uri, '/')) {
            return $response;
        }

        $explode_rota_uri = explode('/', $rota->uri);
        $explode_uri = explode('/', $this->rotaComparator->getUri());

        for ($i = 0, $iMax = count($explode_rota_uri); $i < $iMax; $i++) {

            if ($explode_rota_uri[$i] === '') {
                continue;
            }

            foreach (RotaPattern::getPatterns() as $key => $value) {
                if ($explode_rota_uri[$i] === '(:' . $key . ')') {

                    if (array_key_exists($index, $rota->datasNicknames)) {
                        $response[$rota->datasNicknames[$index]] =  $explode_uri[$i];
                    } else {
                        $response['data_' . $index] =  $explode_uri[$i];
                    }

                    $index++;
                }
            }
        }

        return $response;
    }

    public function getHeaderInput(): ?array
    {
        return getallheaders() === false ? null : getallheaders();
    }

    public function getRotaComparator(): RotaComparator
    {
        return $this->rotaComparator;
    }

    public function setRotaComparator(RotaComparator $rotaComparator): void
    {
        $this->rotaComparator = $rotaComparator;
    }
}
