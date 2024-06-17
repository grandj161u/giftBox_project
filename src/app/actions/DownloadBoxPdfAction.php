<?php

namespace gift\appli\app\actions;

use Exception;
use gift\appli\core\services\Box\ServiceBox;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Exception\HttpNotFoundException;
use Slim\Views\Twig;
use TCPDF;

class DownloadBoxPdfAction
{
    public function __invoke(Request $request, Response $response, $args)
    {
        // Récupérer le token depuis les arguments de la requête
        $token = $args['token'];

        // Récupérer le service Box et le moteur de template Twig directement
        $serviceBox = new ServiceBox();
        $twig = Twig::fromRequest($request);

        try {
            // Obtenir les détails de la box en fonction du token
            $box = $serviceBox->getBoxByToken($token);

            // Utilisation de TCPDF pour générer le contenu PDF
            $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

            // Paramètres du document PDF
            $pdf->SetTitle('Box Details');
            $pdf->SetSubject('Box Details');
            $pdf->SetKeywords('Box, PDF, Details');

            // Ajouter une page
            $pdf->AddPage();

            // Contenu HTML généré avec Twig
            $html = $twig->fetch('pdf-template.html.twig', ['box' => $box]);

            // Ajouter le contenu au PDF
            $pdf->writeHTML($html, true, false, true, false, '');

            // Télécharger le PDF
            $response->getBody()->write($pdf->Output('box.pdf', 'D'));
            return $response->withHeader('Content-Type', 'application/pdf');
        } catch (Exception $e) {
            throw new HttpNotFoundException($request, $e->getMessage());
        }
    }
}
