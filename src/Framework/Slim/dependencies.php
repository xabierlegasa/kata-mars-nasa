<?php
// DIC configuration

use KataMarsNasa\Application\Controllers\StartController;
use KataMarsNasa\Application\Validations\CoordinateValidator;
use KataMarsNasa\Application\Validations\InitialValidator;
use KataMarsNasa\Application\Validations\PlanOverlappingValidator;
use KataMarsNasa\Application\Validations\RoversMovementsValidator;
use KataMarsNasa\Application\Validations\RoversPositionValidator;
use KataMarsNasa\Domain\Services\InputToPlanTransformer;
use KataMarsNasa\Domain\Services\InputToPlateauSizeConverter;
use KataMarsNasa\Domain\Services\InputToRoverMovementsConverter;
use KataMarsNasa\Domain\Services\InputToRoversPositionConverter;
use KataMarsNasa\Domain\UseCases\ExploreMarsUseCase;

$container = $app->getContainer();

$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];

    $view = new \Slim\Views\Twig($settings['template_path'], [
        'cache' => false
    ]);

    // Instantiate and add Slim specific extension
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new Slim\Views\TwigExtension($c['router'], $basePath));

    return $view;
};

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings')['logger'];
    $logger = new Monolog\Logger($settings['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['path'], $settings['level']));
    return $logger;
};

$container['StartController'] = function ($c) {
    return new StartController($c);
};


$container['InitialValidator'] = function ($c) {
    return new InitialValidator();
};
$container['PlanOverlappingValidator'] = function ($c) {
    return new PlanOverlappingValidator();
};
$container['CoordinateValidator'] = function ($c) {
    return new CoordinateValidator();
};
$container['RoversMovementsValidator'] = function ($c) {
    return new RoversMovementsValidator();
};
$container['RoversPositionValidator'] = function ($c) {
    return new RoversPositionValidator();
};

$container['InputToPlanTransformer'] = function ($c) {
    return new InputToPlanTransformer(
        $c->get('InitialValidator'),
        $c->get('PlanOverlappingValidator'),
        $c->get('InputToPlateauSizeConverter'),
        $c->get('InputToRoversPositionConverter'),
        $c->get('InputToRoverMovementsConverter')
    );
};

$container['ExploreMarsUseCase'] = function ($c) {
    return new ExploreMarsUseCase(
        $c->get('InputToPlanTransformer'),
        $c->get('PlanOverlappingValidator')
    );
};

$container['InputToPlateauSizeConverter'] = function ($c) {
    return new InputToPlateauSizeConverter(
        $c->get('CoordinateValidator')
    );
};


$container['InputToRoversPositionConverter'] = function ($c) {
    return new InputToRoversPositionConverter(
        $c->get('RoversPositionValidator')
    );
};

$container['InputToRoverMovementsConverter'] = function ($c) {
    return new InputToRoverMovementsConverter(
        $c->get('RoversMovementsValidator')
    );
};
