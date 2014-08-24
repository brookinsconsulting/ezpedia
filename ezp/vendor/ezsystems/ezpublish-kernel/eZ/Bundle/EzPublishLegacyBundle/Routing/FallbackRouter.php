<?php
/**
 * File containing the FallbackRouter class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Bundle\EzPublishLegacyBundle\Routing;

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Psr\Log\LoggerInterface;

class FallbackRouter implements RouterInterface
{
    const ROUTE_NAME = 'ez_legacy';

    /**
     * @var \Symfony\Component\Routing\RequestContext
     */
    private $context;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    /**
     * @var UrlGenerator
     */
    private $urlGenerator;

    public function __construct( UrlGenerator $urlGenerator, RequestContext $context = null, LoggerInterface $logger = null )
    {
        $this->urlGenerator = $urlGenerator;
        $this->context = $context = $context ?: new RequestContext;
        $this->logger = $logger;
    }

    /**
     * Sets the request context.
     *
     * @param \Symfony\Component\Routing\RequestContext $context The context
     */
    public function setContext( RequestContext $context )
    {
        $this->context = $context;
    }

    /**
     * Gets the request context.
     *
     * @return \Symfony\Component\Routing\RequestContext The context
     */
    public function getContext()
    {
        return $this->context;
    }

    /**
     * Gets the RouteCollection instance associated with this Router.
     *
     * @return RouteCollection A RouteCollection instance
     */
    public function getRouteCollection()
    {
        // No route registered for legacy fallback, request will be forwarded directly to the legacy kernel
        return new RouteCollection();
    }

    /**
     * Generates a URL for an eZ Publish legacy fallback route, from the given parameters.
     * "module_uri" must be provided as a key in $parameters. The module URI must contain ordered parameters if any
     * (e.g. /content/view/full/2, "full", and "2" being regular ordered parameters. See your module definition for more info.).
     * All additional named parameters will be passed as unordered params in the form "/(<paramName>)/<paramValue"
     *
     * Example :
     * <code>
     * $params = array(
     *     'module_uri'    => '/content/view/full/2',
     *     'offset'        => 30,
     *     'limit'         => 10
     * );
     * $url = $legacyRouter->generate( 'ez_legacy', $params );
     * // $url will be "/content/view/full/2/(offset)/30/(limit)/10"
     * </code>
     *
     * @param string $name The name of the route
     * @param mixed $parameters An array of parameters
     * @param boolean $absolute Whether to generate an absolute URL
     *
     * @throws \Symfony\Component\Routing\Exception\RouteNotFoundException
     * @throws \InvalidArgumentException
     *
     * @return string The generated URL
     *
     * @api
     */
    public function generate( $name, $parameters = array(), $absolute = false )
    {
        if ( $name === self::ROUTE_NAME )
        {
            if ( !isset( $parameters['module_uri'] ) )
            {
                throw new \InvalidArgumentException( 'When generating an eZ Publish legacy fallback route, "uri" parameter must be provided.' );
            }

            $moduleUri = $parameters['module_uri'];
            unset( $parameters['module_uri'] );
            return $this->urlGenerator->generate( $moduleUri, $parameters, $absolute );
        }

        throw new RouteNotFoundException();
    }

    /**
     * Tries to match a URL with a set of routes.
     *
     * If the matcher can not find information, it must throw one of the exceptions documented
     * below.
     *
     * @param string $pathinfo The path info to be parsed (raw format, i.e. not urldecoded)
     *
     * @return array An array of parameters
     *
     * @throws ResourceNotFoundException If the resource could not be found
     * @throws MethodNotAllowedException If the resource was found but the request method is not allowed
     *
     * @api
     */
    public function match( $pathinfo )
    {
        return array(
            "_route" => self::ROUTE_NAME,
            "_controller" => "ezpublish_legacy.controller:indexAction",
        );
    }
}
