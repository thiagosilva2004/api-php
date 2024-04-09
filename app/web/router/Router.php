<?php

namespace App\web\router;

use App\di\ContainerBuilder;
use App\web\request\NetworkRequest;
use App\web\request\NetworkResponse;

readonly class Router
{
    public function __construct(private Rota           $rota,
                                private RotaComparator $rotaComparator,
                                private RotaData       $rotaData,
                                private array $requestBodyData
                                ){}

    public function execute_uri(): NetworkResponse
    {
        $found = false;
        $response = new NetworkResponse();

        foreach ($this->rota->getRotas() as $rota) {
            if ($this->rotaComparator->compare($rota)) {
                $found = true;

                $networkRequest = new NetworkRequest(
                    $this->requestBodyData,
                    $this->rotaData,
                    $this->rotaData->getDataRota($rota));

                foreach ($rota->middlewares_classes_names as $rota_middleware) {
                    $response = $this->executeRequestCallback($rota_middleware,'execute',$networkRequest);
                    if ($response->success !== true) {
                        return $response;
                    }
                }

                $response = $this->executeRequestCallback(
                    $rota->controller_class_name,
                    $rota->controller_function_name,
                    $networkRequest
                );
                break;
            }
        }
        if (!$found) {
            $response->code = 404;
        }
        return $response;
    }

    private function executeRequestCallback(
        string $className,
        string $function_name,
        NetworkRequest $request
    ):NetworkResponse
    {
        return ContainerBuilder::get($className)->$function_name($request);
    }
}
