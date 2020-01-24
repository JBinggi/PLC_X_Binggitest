<?php
/**
 * module.config.php - Binggitest Config
 *
 * Main Config File for Binggitest Module
 *
 * @category Config
 * @package Binggitest
 * @author Verein onePlace
 * @copyright (C) 2020  Verein onePlace <admin@1plc.ch>
 * @license https://opensource.org/licenses/BSD-3-Clause
 * @version 1.0.0
 * @since 1.0.0
 */

namespace OnePlace\Binggitest;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    # Binggitest Module - Routes
    'router' => [
        'routes' => [
            # Module Basic Route
            'binggitest' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/binggitest[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\BinggitestController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'binggitest-api' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/binggitest/api[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\ApiController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],

    # View Settings
    'view_manager' => [
        'template_path_stack' => [
            'binggitest' => __DIR__ . '/../view',
        ],
    ],
];
