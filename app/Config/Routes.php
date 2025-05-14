<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'ViewController::index');
$routes->get('ping', 'ViewController::pingDataBase');