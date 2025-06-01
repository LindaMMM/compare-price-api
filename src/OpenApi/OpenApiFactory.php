<?php

namespace App\OpenApi;

use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\OpenApi\Model\SecurityScheme;
use ApiPlatform\OpenApi\Model\SecurityRequirement;

class OpenApiFactory implements OpenApiFactoryInterface
{
    # private string $checkPath = "/api/token/refresh";
    # private string $checkPath = "/api/token/invalidate";
    private string $checkPath = "/auth/login";
    private string $usernamePath = "email";
    private string $passwordPath = "password";

    public function __construct(private OpenApiFactoryInterface $decorated) {}

    public function __invoke(array $context = []): OpenApi
    {


        $openApi = ($this->decorated)($context);
        // to define base path URL
        // $openApi = $openApi->withServers([new Model\Server('https://www.api.compare.nitramlinda.fr/api')]);
        $components = $openApi->getComponents();
        // string $type = null, private string $description = '', private ?string $name = null, private ?string $in = null, private ?string $scheme = null, private ?string $bearerFormat = null, private ?OAuthFlows $flows = null, private ?string $openIdConnectUrl = null
        $securityScheme = new SecurityScheme('http', 'description', 'name', null, 'bearer', 'JWT token authentication');
        $shema_secu = new \ArrayObject(['bearerAuth' => $securityScheme]);
        $components = $components->withSecuritySchemes($shema_secu);;

        // Appliquer la sécurité globale à toutes les routes
        $openApi = $openApi->withComponents($components)->withSecurity([
            ['bearerAuth' => []],
        ]);

        $paths = $openApi->getPaths();

        foreach ($paths->getPaths() as $path => $pathItem) {
            foreach (['get', 'post', 'put', 'patch', 'delete'] as $method) {
                $operation = $pathItem->{'get' . ucfirst($method)}();
                if ($operation) {
                    $operation->withSecurity([
                        ['bearerAuth' => []],
                    ]);
                }
            }
        }
        $openApi = $openApi->withComponents($components)->withPaths($paths);

        /* $shemas = $openApi->getComponents()->getSecuritySchemes();


        $shemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT',
        ]);*/
        $openApi = $openApi->withSecurity(['BearerAuth' => []]);
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
