<?php

namespace KataMarsNasa\Application\Controllers;


use KataMarsNasa\Domain\UseCases\ExploreMarsUseCase;
use Slim\Http\Request;
use Slim\Http\Response;

class StartController extends Controller
{
    public function getStart(Request $request, Response $response)
    {
        return $this->view->render($response, 'start.phtml', []);
    }

    public function postStart(Request $request, Response $response)
    {
        $input = $request->getParam('plan');

        $inputArray = explode("\n", $input);

        try {
            /** @var ExploreMarsUseCase $exploreMarsUseCase */
            $exploreMarsUseCase = $this->container->get('ExploreMarsUseCase');
            $result = $exploreMarsUseCase->execute($inputArray);

        } catch (\Exception $e) {
            return $this->view->render($response, 'explorationResult.phtml', ['error' => $e->getMessage()]);

        }

        return $this->view->render($response, 'explorationResult.phtml', []);
    }
}
