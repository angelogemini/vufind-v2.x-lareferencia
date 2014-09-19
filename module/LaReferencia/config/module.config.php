<?php
namespace LaReferencia\Module\Configuration;

$config = array(
    'controllers' => array(
        'invokables' => array(
            'statistics' => 'LaReferencia\Controller\StatisticsController',
        ),
    ),
	'service_manager' => array(
			'allow_override' => true,
			'factories' => array(
					'LaReferencia\SolrStats' => 'LaReferencia\Service\Factory::getSolrStats',
			),
	),
    'router' => array(
        'routes' => array(
        	'default' => array(
        		'type'    => 'Zend\Mvc\Router\Http\Segment',
        		'options' => array(
	        		'route'    => '/[:controller[/[:action]]]',
	        		'constraints' => array(
	        			'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
	        			'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
	        		),
	        		'defaults' => array(
	        					'controller' => 'statistics',
        						'action'     => 'Clicks',
        			),
        		),
        	),
        ),
    ),
);

return $config;
