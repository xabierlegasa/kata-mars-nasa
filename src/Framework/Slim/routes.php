<?php
// Routes

$app->get('/', function ($request, $response, $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->view->render($response, 'index.phtml', $args);
});


$app->get('/start', 'StartController:getStart')->setName('start');
$app->post('/start', 'StartController:postStart');
