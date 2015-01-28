<?php
 return array(
        'view_manager' => array(
             'template_path_stack' => array(
                 __DIR__ . '/../view'
         )
     ),
     'router' => array(
                      'routes' => array(
                   'task' => array(
                       'type' => 'Zend\Mvc\Router\Http\Literal',
                      'options' => array(
                              'route' => '/',
                          'defaults' => array(
                                  'controller' => 'Task\Controller\Index',
                                  'action' => 'index',
                          )
                      )
                  )
             )
         ),
         'controllers' => array(
                 'invokables' => array(
                      'Task\Controller\Index'
                      => 'Task\Controller\IndexController'
             )
         ),

 );