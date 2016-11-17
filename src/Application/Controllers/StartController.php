<?php

namespace KataMarsNasa\Application\Controllers;


use KataMarsNasa\Domain\UseCases\ExploreMarsUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

class StartController extends Controller
{
    public function getStart(Request $request, Response $response)
    {
        return $this->view->render($response, 'start-mission.twig', []);
    }

    public function postStart(Request $request, Response $response)
    {
        $input = $request->getParam('plan');

        $inputArray = explode("\n", $input);

        try {
            /** @var ExploreMarsUseCase $exploreMarsUseCase */
            $exploreMarsUseCase = $this->container->get('ExploreMarsUseCase');
            $mission = $exploreMarsUseCase->execute($inputArray);

            $output = $mission->generateOutput();

            $outputForHTML = str_replace("\n", "<br>", $output);
            $data = ['output' => $outputForHTML];
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        return $this->view->render($response, 'exploration-result.twig', $data);
    }
}
