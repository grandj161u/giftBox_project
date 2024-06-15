<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\authentification\AuthService;
use gift\appli\core\services\authentification\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteContext;

class AuthPostAction
{
    private AuthServiceInterface $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $postData = $request->getParsedBody();

        // recuperation des credentials entrees dans le formulaire
        $user_id = $postData['user_id'] ?? '';
        $password = $postData['password'] ?? '';

        // verification des credentials
        if($this->authService->checkPasswordValid($password, $user_id))
        {
            // Connexion reussi
            $user = $this->authService->connectuser(['id' => $user_id]);
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();

            // redirection après connexion
            $url = $routeParser->urlFor('home');
            return $response->withStatus(302)->withHeader('Location', $url);
        } else {
            $response->getBody()->write('Identifiants incorrects');
            return $response->withStatus(401);
        }

    }
}