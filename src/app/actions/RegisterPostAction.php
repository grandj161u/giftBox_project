<?php

namespace gift\appli\app\actions;

use gift\appli\core\services\authentification\AuthService;
use gift\appli\core\services\authentification\AuthServiceInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Routing\RouteParser;
use Slim\Routing\RouteContext;

class RegisterPostAction
{
    private AuthServiceInterface $userService;

    public function __construct()
    {
        $this->userService = new AuthService();
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response): ResponseInterface
    {
        $postData = $request->getParsedBody();

        if (isset($postData['createaccount'])) {
            $Cuser_id = htmlspecialchars($postData['Cuser_id'], ENT_QUOTES, 'UTF-8');
            $Cpassword = htmlspecialchars($postData['Cpassword'], ENT_QUOTES, 'UTF-8');

            $args = [
                'user_id' => $Cuser_id,
                'password' => $Cpassword
            ];

            if ($postData["Cpassword"] !== $postData["CCpassword"]) {
                $response->getBody()->write('Les mots de passe ne correspondent pas');
                return $response->withStatus(400)->withHeader('Content-Type', 'text/html');
            }
            $routeContext = RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            $url = $routeParser->urlFor('login');
            try {
                $user = $this->userService->createUser($args);
                return $response->withStatus(302)->withHeader('Location', $url);
            } catch (\InvalidArgumentException $e) {
                $response->getBody()->write($e->getMessage());
                return $response->withStatus(400)->withHeader('Content-Type', 'text/html');
            } catch (\Exception $e) {
                $response->getBody()->write($e->getMessage());
                return $response->withStatus(500)->withHeader('Content-Type', 'text/html');
            }
        }

        $response->getBody()->write('Erreur lors de la création du compte');
        return $response->withStatus(400)->withHeader('Content-Type', 'text/html');
    }
}
