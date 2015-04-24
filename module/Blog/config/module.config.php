<?php

return array(
    // Db config
    'db' => array(
        'driver' => 'Pdo',
        'username' => 'root',
        'password' => 'root',
        'dsn' => 'mysql:dbname=zf2blog;host=localhost',
        'driver_options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
        ),
    ),
    // this lines allow to register a Service : ServiceManager Config
    'service_manager' => array(
        //'invokables' => array(
        //    'Blog\Service\PostServiceInterface' => 'Blog\Service\PostService'
        'factories' => array(
            'Blog\Mapper\PostMapperInterface' => 'Blog\Factory\ZendDbSqlMapperFactory',
            'Blog\Service\PostServiceInterface' => 'Blog\Factory\PostServiceFactory',
            'Zend\Db\Adapter\Adapter' => 'Zend\Db\Adapter\AdapterServiceFactory'
        ),
    ),
    // This lines let the application to know where to look for view files : ViewManager Config
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // this lines tell the module where to find the controller named 'Blog\Controller\List
    'controllers' => array(
        'factories' => array(
            'Blog\Controller\List' => 'Blog\Factory\ListControllerFactory',
            'Blog\Controller\Write' => 'Blog\Factory\WriteControllerFactory',
            'Blog\Controller\Delete' => 'Blog\Factory\DeleteControllerFactory'
        ),
    ),
    // This lines opens the configuration for the Route Manager
    'router' => array(
        // Open configuration for all possible routes
        'routes' => array(
            // Define a new route called "blog"
            'blog' => array(
                // Define the routes type to be "Zend\Mvc\Router\Http\Literal", which is basically just a string
                'type' => 'literal',
                // Configure the route itself
                'options' => array(
                    // Listen to "/blog" as uri
                    'route' => '/blog',
                    // Define default controller and action to be called when this route is matched
                    'defaults' => array(
                        'controller' => 'Blog\Controller\List',
                        'action' => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'detail' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/:id',
                            'defaults' => array(
                                'action' => 'detail'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            ),
                        ),
                    ),
                    'add' => array(
                        'type' => 'literal',
                        'options' => array(
                            'route' => '/add',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'add'
                            ),
                        ),
                    ),
                    'edit' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/edit/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Write',
                                'action' => 'edit'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            ),
                        ),
                    ),
                    'delete' => array(
                        'type' => 'segment',
                        'options' => array(
                            'route' => '/delete/:id',
                            'defaults' => array(
                                'controller' => 'Blog\Controller\Delete',
                                'action' => 'delete'
                            ),
                            'constraints' => array(
                                'id' => '\d+'
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
