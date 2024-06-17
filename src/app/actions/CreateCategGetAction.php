<?php

namespace gift\appli\app\actions;

use gift\appli\app\utils\CsrfService;
use Slim\Views\Twig;

class CreateCategGetAction
{
    public function __invoke($request, $response, $args)
    {

        if (!isset($_SESSION['id'])) {
            // Utilisateur redirigé vers le formulaire de login s'il n'est pas authentifié
            $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
            $routeParser = $routeContext->getRouteParser();
            $loginUrl = $routeParser->urlFor('login'); // Adjust the route name as needed

            return $response->withStatus(302)->withHeader('Location', $loginUrl);
        }

        $csrf_token = CsrfService::generate();
        $view = Twig::fromRequest($request);
        return $view->render(
            $response,
            'CreateCateg.html.twig',
            [
                'csrf' => $csrf_token
            ]
        );
    }
}
