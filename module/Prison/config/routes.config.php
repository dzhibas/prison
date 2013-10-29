<?php

return array(
    'type'    => 'Literal',
    'options' => array(
        'route'    => '/prison',
        'defaults' => array(
            '__NAMESPACE__' => 'Prison\Controller',
            'controller'    => 'Index',
            'action'        => 'index',
        ),
    ),
    'may_terminate' => true,
    'child_routes' => array(
        'default' => array(
            'type'    => 'Segment',
            'options' => array(
                'route'    => '/[:controller[/:action]]',
                'constraints' => array(
                    'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                ),
                'defaults' => array(
                ),
            ),
        ),
        'api' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/api/[:project]',
                'constrains' => array(
                    'project' => '\d+'
                ),
                'defaults' => array(
                    'controller' => 'Prison\Controller\Api',
                    'action' => 'store',
                )
            ),
            'may_terminate' => true,
            'child_routes' => array(
                'store' => array(
                    'type' => 'Literal',
                    'options' => array(
                        'route' => '/store',
                        'defaults' => array(
                            'controller'    => 'Prison\Controller\Api',
                            'action'        => 'store',
                        ),
                    )
                )
            )
        ),
        'team' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/team[/:slug]',
                'constraints' => array(
                    'slug' => '[a-zA-Z0-9\-_]+',
                ),
                'defaults' => array(
                    'controller' => 'Prison\Controller\Team',
                    'action' => 'index',
                )
            ),
        ),
        'team-new'  => array(
            'type'  => 'Literal',
            'options' => array(
                'route' => '/team/new',
                'defaults' => array(
                    'controller' => 'Prison\Controller\Team',
                    'action'     => 'new',
                ),
            ),
        ),
        'project' => array(
            'type'  => 'Segment',
            'options' => array(
                'route' => '/team[/:teamslug]/projects',
                'constraints' => array(
                    'teamslug' => '[a-zA-Z0-9\-_]+',
                ),
                'defaults' => array(
                    'controller' => 'Prison\Controller\Project',
                    'action' => 'index',
                )
            ),
        ),
        'project-new' => array(
            'type'  => 'Segment',
            'options' => array(
                'route' => '/team[/:teamslug]/projects/new',
                'constraints' => array(
                    'teamslug' => '[a-zA-Z0-9\-_]+',
                ),
                'defaults' => array(
                    'controller' => 'Prison\Controller\Project',
                    'action' => 'new',
                )
            ),
        ),

        'project-doc' => array(
            'type'  => 'Segment',
            'options' => array(
                'route' => '/[:team]/[:project]/docs[/:platform]',
                'constraints' => array(
                    'team' => '[a-zA-Z0-9\-_]+',
                    'project' => '[a-zA-Z0-9\-_]+',
                ),
                'defaults' => array(
                    'controller' => 'Prison\Controller\Project',
                    'action' => 'docs',
                )
            ),
        ),
        'project-keys' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/[:team]/[:project]/keys',
                'defaults' => array(
                    'controller' => 'Prison\Controller\Project',
                    'action' => 'keys',
                )
            ),
        ),

        'key-new' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/[:team]/[:project]/keys/new',
                'defaults' => array(
                    'controller' => 'Prison\Controller\Key',
                    'action' => 'new'
                ),
            ),
        ),
        'key-revoke' => array(
            'type' => 'Segment',
            'options' => array(
                'route' => '/key/[:key]/revoke',
                'defaults' => array(
                    'controller' => 'Prison\Controller\Key',
                    'action' => 'revoke'
                ),
            ),
        ),
    ),
);