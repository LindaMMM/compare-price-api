<?php

namespace App\OpenApi;

use Symfony\Component\DependencyInjection\Attribute\AsDecorator;
use ApiPlatform\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\OpenApi\OpenApi;
use ApiPlatform\OpenApi\Model\MediaType;
use ApiPlatform\OpenApi\Model\Operation;
use ApiPlatform\OpenApi\Model\PathItem;
use ApiPlatform\OpenApi\Model\RequestBody;
use Symfony\Component\HttpFoundation\Response;
use ApiPlatform\OpenApi\Model\SecurityScheme;
use ApiPlatform\OpenApi\Model\SecurityRequirement;

#[AsDecorator('api_platform.openapi.factory')]
class OpenApiFactory implements OpenApiFactoryInterface
{
    private string $registerPath = "/auth/register";
    private string $refreshPath = "/auth/token/refresh";
    private string $invalidatePath = "/auth/token/invalidate";
    private string $checkPath = "/auth/login";
    private string $usernamePath = "email";
    private string $passwordPath = "password";

    public function __construct(private OpenApiFactoryInterface $decorated) {}

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = ($this->decorated)($context);
        $securitySchemes = $openApi->getComponents()->getSecuritySchemes() ?: new \ArrayObject();
        $securitySchemes['JWT'] = new SecurityScheme(
            type: 'http',
            scheme: 'bearer',
        );

        /* $openApi
            ->getComponents()->getSecuritySchemes()->offsetSet(
                'BearerJWT',
                new \ArrayObject(
                    [
                        'type' => 'http',
                        'scheme' => 'bearer',
                        'bearerFormat' => 'Token jwt',
                    ]
                )
            );
    */
        // $openApi = $openApi->withSecurity(['JWT' => [], 'BearerJWT' => []]);
        $openApi
            ->getPaths()
            ->addPath($this->checkPath, $this->createPathItemLogin());
        $openApi
            ->getPaths()
            ->addPath($this->refreshPath, $this->createPathItemRefreshPath());
        $openApi
            ->getPaths()
            ->addPath($this->invalidatePath, $this->createPathItemInvalidatePath());
        $openApi
            ->getPaths()
            ->addPath($this->registerPath, $this->createPathItemRegisterPath());
        return $openApi;
    }

    private function createPathItemLogin(): PathItem
    {
        return (new PathItem())->withPost(
            (new Operation())
                ->withOperationId('login_check_post')
                ->withTags(['Authentification'])
                ->withSecurity([])
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
                                        'refresh_token' => [
                                            'readOnly' => true,
                                            'type' => 'string',
                                            'nullable' => false,
                                        ],
                                    ],
                                    'required' => ['token', 'refresh_token'],
                                ],
                            ],
                        ],
                    ],
                ])
                ->withSummary("Création d'un token utilisateur")
                ->withDescription("Créationd'un token utilisateur.")
                ->withRequestBody(
                    (new RequestBody())
                        ->withDescription('Donnée de connexion')
                        ->withContent(new \ArrayObject([
                            'application/json' => new MediaType(new \ArrayObject(new \ArrayObject([
                                'type' => 'object',
                                'properties' => $properties = array_merge_recursive($this->getJsonSchemaFromPathParts(explode('.', $this->usernamePath)), $this->getJsonSchemaFromPathParts(explode('.', $this->passwordPath))),
                                'required' => array_keys($properties),
                            ]))),
                        ]))
                        ->withRequired(true)
                )
        );
    }
    private function createPathItemRefreshPath(): PathItem
    {
        return (new PathItem())->withPost(
            (new Operation())
                ->withOperationId('refresh_post')
                ->withTags(['Authentification'])
                ->withSecurity([])
                ->withResponses([
                    Response::HTTP_OK => [
                        'description' => "Mise à jour d'un token utilisateur",
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
                                        'refresh_token' => [
                                            'readOnly' => true,
                                            'type' => 'string',
                                            'nullable' => false,
                                        ],
                                    ],
                                    'required' => ['token', 'refresh_token'],
                                ],
                            ],
                        ],
                    ],
                ])
                ->withSummary("Mise à jour d'un token utilisateur")
                ->withDescription("Mise à jour d'un token utilisateur.")
                ->withRequestBody(
                    (new RequestBody())
                        ->withDescription('Données pour rafraichir le token')
                        ->withContent(new \ArrayObject([
                            'application/json' => new MediaType(new \ArrayObject(new \ArrayObject([
                                'type' => 'object',
                                'properties' => $properties = array_merge_recursive($this->getJsonSchemaFromPathParts(explode('.', "refresh_token"))),
                                'required' => array_keys($properties),
                            ]))),
                        ]))
                        ->withRequired(true)
                )
        );
    }

    private function createPathItemInvalidatePath(): PathItem
    {
        return (new PathItem())->withPost(
            (new Operation())
                ->withOperationId('logout_post')
                ->withTags(['Authentification'])
                ->withResponses([
                    Response::HTTP_OK => [
                        'description' => "Deconnexion d'un utilisateur",
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'message' => [
                                            'readOnly' => true,
                                            'type' => 'Logoff Successfully',
                                            'nullable' => false,
                                        ]
                                    ],
                                    'required' => ['message'],
                                ],
                            ],
                        ],
                    ],
                ])
                ->withSummary("Deconnexion d'un utilisateur")
                ->withDescription("Deconnexion d'un utilisateur.")
        );
    }

    private function createPathItemRegisterPath(): PathItem
    {
        return (new PathItem())->withPost(
            (new Operation())
                ->withOperationId('register_user_post')
                ->withTags(['Authentification'])
                ->withSecurity([])
                ->withResponses([
                    Response::HTTP_OK => [
                        'description' => "Création d'un utilisateur",
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
                                        'refresh_token' => [
                                            'readOnly' => true,
                                            'type' => 'string',
                                            'nullable' => false,
                                        ],
                                    ],
                                    'required' => ['token', 'refresh_token'],
                                ],
                            ],
                        ],
                    ],
                ])
                ->withSummary("Mise à jour d'un token utilisateur")
                ->withDescription("Mise à jour d'un token utilisateur.")
                ->withRequestBody(
                    (new RequestBody())
                        ->withDescription('Données pour rafraichir le token')
                        ->withContent(new \ArrayObject([
                            'application/json' => new MediaType(new \ArrayObject(new \ArrayObject([
                                'type' => 'object',
                                'properties' => $properties = array_merge_recursive($this->getJsonSchemaFromPathParts(explode('.', "refresh_token"))),
                                'required' => array_keys($properties),
                            ]))),
                        ]))
                        ->withRequired(true)
                )
        );
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
