<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use Symfony\Component\HttpFoundation\Response;

class OpenApiFactory implements OpenApiFactoryInterface
{
    private string $checkPath = "/api/login";
    private string $usernamePath = "email";
    private string $passwordPath = "password";

    public function __construct(private OpenApiFactoryInterface $decorated) {}

    /* public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);
        foreach ($openApi->getPaths()->getPaths() as $key => $path) {
            if ($path->getGet() && $path->getGet()->getSummary() == 'hidden') {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }
        return $openApi;
    }*/

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        /* $openApi
            ->getComponents()->getSecuritySchemes()->offsetSet(
                'JWT',
                new \ArrayObject(
                    [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'JWT',
                    ]
                )
            );*/
        $openApi
            ->getPaths()
            ->addPath($this->checkPath, (new PathItem())->withPost(
                (new Operation())
                    ->withOperationId('login_check_post')
                    ->withTags(['Authentification'])
                    ->withResponses([
                        Response::HTTP_OK => [
                            'description' => "Création d'un token utilisateur",
                            'content' => [
                                'application/json' => [
                                    'schema' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'token' => [
                                                'readOnly' => true,
                                                'type' => 'string',
                                                'nullable' => false,
                                            ],
                                        ],
                                        'required' => ['token'],
                                    ],
                                ],
                            ],
                        ],
                    ])
                    ->withSummary("Création d'un token utilisateur")
                    ->withDescription("Créationd'un token utilisateur.")
                    ->withRequestBody(
                        (new RequestBody())
                            ->withDescription('The login data')
                            ->withContent(new \ArrayObject([
                                'application/json' => new MediaType(new \ArrayObject(new \ArrayObject([
                                    'type' => 'object',
                                    'properties' => $properties = array_merge_recursive($this->getJsonSchemaFromPathParts(explode('.', $this->usernamePath)), $this->getJsonSchemaFromPathParts(explode('.', $this->passwordPath))),
                                    'required' => array_keys($properties),
                                ]))),
                            ]))
                            ->withRequired(true)
                    )
            ));

        return $openApi;
    }

    private function getJsonSchemaFromPathParts(array $pathParts): array
    {
        $jsonSchema = [];

        if (count($pathParts) === 1) {
            $jsonSchema[array_shift($pathParts)] = [
                'type' => 'string',
                'nullable' => false,
            ];

            return $jsonSchema;
        }

        $pathPart = array_shift($pathParts);
        $properties = $this->getJsonSchemaFromPathParts($pathParts);
        $jsonSchema[$pathPart] = [
            'type' => 'object',
            'properties' => $properties,
            'required' => array_keys($properties),
        ];

        return $jsonSchema;
    }
}
