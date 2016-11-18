<?php

namespace KataMarsNasa\Application\Controllers;


use KataMarsNasa\Domain\UseCases\ExploreMarsUseCase;
use Psr\Http\Message\UploadedFileInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\Stream;
use Slim\Http\UploadedFile;

class StartController extends Controller
{
    public function getStart(Request $request, Response $response)
    {
        return $this->view->render($response, 'start-mission.twig', []);
    }

    public function postStart(Request $request, Response $response)
    {
        try {
            $inputArray = $this->getInputArray($request);

            /** @var ExploreMarsUseCase $exploreMarsUseCase */
            $exploreMarsUseCase = $this->container->get('ExploreMarsUseCase');
            $mission = $exploreMarsUseCase->execute($inputArray);

            $output = $mission->generateOutput();
            $exploredPercentage = $mission->plan()->plateau()->getExploredPercentage();

            $outputForHTML = str_replace("\n", "<br>", $output);
            $data = ['output' => $outputForHTML, 'explored_percentage' => $exploredPercentage];
        } catch (\Exception $e) {
            $data = ['error' => $e->getMessage()];
        }

        return $this->view->render($response, 'exploration-result.twig', $data);
    }

    private function getInputArray($request)
    {
        $plainText = $request->getParam('plan');

        $fileText = $this->getTextFromFileIfExists($request);

        if (empty($plainText) && empty($fileText)) {
            throw new \Exception('Introduce a file or a text with the plan plese');
        }

        if (!empty($plainText) && !empty($fileText)) {
            throw new \Exception('Introduce a file OR a text with the plan please');
        }


        if (!empty($plainText)) {
            $inputArray = explode("\n", $plainText);
            return $inputArray;
        }

        if (!empty($fileText)) {
            $inputArray = explode("\n", $fileText);
            return $inputArray;
        }

        return $plainText;
    }

    private function getTextFromFileIfExists(Request $request)
    {
        $files = $request->getUploadedFiles();
        if (isset($files['planFile'])) {

            /** @var UploadedFileInterface $planFile */
            $planFile = $files['planFile'];
            if ($planFile->getSize() > 0) {
                /** @var Stream $planFileText */
                $stream = $planFile->getStream();
                $planFileText = $stream->read($stream->getSize());

                return $planFileText;
            }
        }
    }
}
