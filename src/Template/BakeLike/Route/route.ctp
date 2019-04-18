Router::scope('/<?= $scope;?>', ['controller' => '<?= $controller;?>'], function (RouteBuilder <?= '\$' . 'routes';?>) {
    <?= '\$' . 'routes';?>->connect('/<?= $path;?>', ['action' => '<?= $action;?>'], ['pass' => <?= $pass;?>]);
});