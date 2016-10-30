<?php

use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Route;

$collection = new RouteCollection();

$collection->add('factor_index', new Route(
    '/',
    array('_controller' => 'AppBundle:Factor:index'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('factor_show', new Route(
    '/{id}/show',
    array('_controller' => 'AppBundle:Factor:show'),
    array(),
    array(),
    '',
    array(),
    array('GET')
));

$collection->add('factor_new', new Route(
    '/new',
    array('_controller' => 'AppBundle:Factor:new'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('factor_edit', new Route(
    '/{id}/edit',
    array('_controller' => 'AppBundle:Factor:edit'),
    array(),
    array(),
    '',
    array(),
    array('GET', 'POST')
));

$collection->add('factor_delete', new Route(
    '/{id}/delete',
    array('_controller' => 'AppBundle:Factor:delete'),
    array(),
    array(),
    '',
    array(),
    array('DELETE')
));

return $collection;
