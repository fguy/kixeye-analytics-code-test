<?php
return array(
		'router' => array(
				'routes' => array(
						'default' => array(
								'type'    => 'segment',
								'options' => array(
										'route'    => '[/:action][/:id]',
										'constraints' => array(
												'action' => '[a-zA-Z][a-zA-Z0-9_-]*'
										),
										'defaults' => array(
												'controller' => 'Application\Controller\Contact',
												'action'     => 'index',
										),
								),
						),
						'simple-address-book' => array(
								'type'    => 'Literal',
								'options' => array(
										'route'    => '/simple-address-book',
										'defaults' => array(
												'__NAMESPACE__' => 'Application\Controller',
												'controller'    => 'Contact',
												'action'        => 'index',
										),
								),
								'may_terminate' => true,
								'child_routes' => array(
										'default' => array(
												'type'    => 'Segment',
												'options' => array(
														'route'    => '/[:controller[/:action]][/:id]',
														'constraints' => array(
																'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
																'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
																'id'     => '[0-9]+',
														),
														'defaults' => array(
																'__NAMESPACE__' => 'Application\Controller',
																'controller'    => 'Contact',
																'action'        => 'index',
														),
												),
										),
								),
						),
				),
		),
		'controllers' => array(
				'invokables' => array(
						'Application\Controller\Contact' => 'SimpleAddressBook\Controller\ContactController'
				),
		),
		'view_manager' => array(
				'display_not_found_reason' => true,
				'display_exceptions'       => true,
				'doctype'                  => 'HTML5',
				'not_found_template'       => 'error/404',
				'exception_template'       => 'error/index',
				'template_map' => array(
						'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
						'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
						'error/404'               => __DIR__ . '/../view/error/404.phtml',
						'error/index'             => __DIR__ . '/../view/error/index.phtml',
				),
				'template_path_stack' => array(
						__DIR__ . '/../view',
				),
		),
);
