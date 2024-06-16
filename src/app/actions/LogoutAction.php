<?php

namespace gift\appli\app\actions;

class LogoutAction
{

    public function __invoke($request, $response, $args)
    {
        session_destroy();
        $routeContext = \Slim\Routing\RouteContext::fromRequest($request);
        $routeParser = $routeContext->getRouteParser();
        $url = $routeParser->urlFor('home');
        return $response->withStatus(302)->withHeader('Location', $url);
    }
}