<?php
/**
 * File containing the UrlAliasRouterTest class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Publish\Core\MVC\Symfony\Routing\Tests;

use eZ\Publish\API\Repository\LocationService;
use eZ\Publish\API\Repository\URLAliasService;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Request;
use eZ\Publish\API\Repository\Values\Content\URLAlias;
use eZ\Publish\Core\Base\Exceptions\NotFoundException;
use eZ\Publish\Core\MVC\Symfony\Routing\Generator\UrlAliasGenerator;
use eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter;
use eZ\Publish\Core\MVC\Symfony\SiteAccess;
use eZ\Publish\Core\Repository\Values\Content\Location;
use eZ\Publish\Core\MVC\Symfony\View\Manager as ViewManager;
use PHPUnit_Framework_TestCase;

class UrlAliasRouterTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $repository;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlAliasService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $locationService;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    protected $urlALiasGenerator;

    protected $requestContext;

    /**
     * @var UrlAliasRouter
     */
    protected $router;

    protected function setUp()
    {
        parent::setUp();
        $repositoryClass = 'eZ\\Publish\\Core\\Repository\\Repository';
        $this->repository = $repository = $this
            ->getMockBuilder( $repositoryClass )
            ->disableOriginalConstructor()
            ->setMethods(
                array_diff(
                    get_class_methods( $repositoryClass ),
                    array( 'sudo' )
                )
            )
            ->getMock();
        $this->urlAliasService = $this->getMock( 'eZ\\Publish\\API\\Repository\\URLAliasService' );
        $this->locationService = $this->getMock( 'eZ\\Publish\\API\\Repository\\LocationService' );
        $this->urlALiasGenerator = $this
            ->getMockBuilder( 'eZ\\Publish\\Core\\MVC\\Symfony\\Routing\\Generator\\UrlAliasGenerator' )
            ->setConstructorArgs(
                array(
                    $repository,
                    $this->getMock( 'Symfony\\Component\\Routing\\RouterInterface' ),
                    $this->getMock( 'eZ\Publish\Core\MVC\ConfigResolverInterface' )
                )
            )
            ->getMock();
        $this->requestContext = new RequestContext();

        $this->router = $this->getRouter( $this->locationService, $this->urlAliasService, $this->urlALiasGenerator, $this->requestContext );
    }

    /**
     * @param \eZ\Publish\API\Repository\LocationService $locationService
     * @param \eZ\Publish\API\Repository\URLAliasService $urlAliasService
     * @param UrlAliasGenerator $urlAliasGenerator
     * @param RequestContext $requestContext
     *
     * @return UrlAliasRouter
     */
    protected function getRouter( LocationService $locationService, URLAliasService $urlAliasService, UrlAliasGenerator $urlAliasGenerator, RequestContext $requestContext )
    {
        return new UrlAliasRouter( $locationService, $urlAliasService, $urlAliasGenerator, $requestContext );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getContext
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::setContext
     */
    public function testRequestContext()
    {
        $this->assertSame( $this->requestContext, $this->router->getContext() );
        $newContext = new RequestContext();
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'setRequestContext' )
            ->with( $newContext );
        $this->router->setContext( $newContext );
        $this->assertSame( $newContext, $this->router->getContext() );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::match
     *
     * @expectedException \RuntimeException
     */
    public function testMatch()
    {
        $this->router->match( '/foo' );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::supports
     *
     * @dataProvider providerTestSupports
     */
    public function testSupports( $routeReference, $isSupported )
    {
        $this->assertSame( $isSupported, $this->router->supports( $routeReference ) );
    }

    public function providerTestSupports()
    {
        return array(
            array( new Location, true ),
            array( new \stdClass(), false ),
            array( UrlAliasRouter::URL_ALIAS_ROUTE_NAME, true ),
            array( 'some_route_name', false ),
        );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getRouteCollection
     */
    public function testGetRouteCollection()
    {
        $this->assertInstanceOf( 'Symfony\\Component\\Routing\\RouteCollection', $this->router->getRouteCollection() );
    }

    /**
     * @param $pathInfo
     *
     * @return Request
     */
    protected function getRequestByPathInfo( $pathInfo )
    {
        $request = Request::create( $pathInfo );
        $request->attributes->set( 'semanticPathinfo', $pathInfo );
        $request->attributes->set(
            'siteaccess',
            new SiteAccess(
                'test',
                'fake',
                $this->getMock( 'eZ\\Publish\\Core\\MVC\\Symfony\\SiteAccess\\Matcher' )
            )
        );

        return $request;
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getUrlAlias
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::matchRequest
     */
    public function testMatchRequestLocation()
    {
        $pathInfo = '/foo/bar';
        $destinationId = 123;
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::LOCATION,
                'destination' => $destinationId,
                'isHistory' => false
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            '_controller' => UrlAliasRouter::LOCATION_VIEW_CONTROLLER,
            'locationId' => $destinationId,
            'viewType' => ViewManager::VIEW_TYPE_FULL,
            'layout' => true
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertSame( $destinationId, $request->attributes->get( 'locationId' ) );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getUrlAlias
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::matchRequest
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testMatchRequestLocationHistory()
    {
        $pathInfo = '/foo/bar';
        $newPathInfo = '/foo/bar-new';
        $destinationId = 123;
        $destinationLocation = new Location( array( 'id' => $destinationId ) );
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::LOCATION,
                'destination' => $destinationId,
                'isHistory' => true
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'loadLocation' )
            ->with( $destinationId )
            ->will(
                $this->returnValue( $destinationLocation )
            );
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $destinationLocation )
            ->will( $this->returnValue( $newPathInfo ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            '_controller' => UrlAliasRouter::LOCATION_VIEW_CONTROLLER,
            'locationId' => $destinationId,
            'viewType' => ViewManager::VIEW_TYPE_FULL,
            'layout' => true
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertSame( $newPathInfo, $request->attributes->get( 'semanticPathinfo' ) );
        $this->assertTrue( $request->attributes->get( 'needsRedirect' ) );
        $this->assertFalse( $request->attributes->get( 'prependSiteaccessOnRedirect' ) );
    }

    public function testMatchRequestLocationCustom()
    {
        $pathInfo = '/foo/bar';
        $destinationId = 123;
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::LOCATION,
                'destination' => $destinationId,
                'isHistory' => false,
                'isCustom' => true,
                'forward' => false
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            '_controller' => UrlAliasRouter::LOCATION_VIEW_CONTROLLER,
            'locationId' => $destinationId,
            'viewType' => ViewManager::VIEW_TYPE_FULL,
            'layout' => true
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertSame( $destinationId, $request->attributes->get( 'locationId' ) );
    }

    public function testMatchRequestLocationCustomForward()
    {
        $pathInfo = '/foo/bar';
        $newPathInfo = '/foo/bar-new';
        $destinationId = 123;
        $destinationLocation = new Location( array( 'id' => $destinationId ) );
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::LOCATION,
                'destination' => $destinationId,
                'isHistory' => false,
                'isCustom' => true,
                'forward' => true
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'loadLocation' )
            ->with( $destinationId )
            ->will(
                $this->returnValue( $destinationLocation )
            );
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $destinationLocation )
            ->will( $this->returnValue( $newPathInfo ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
            '_controller' => UrlAliasRouter::LOCATION_VIEW_CONTROLLER,
            'locationId' => $destinationId,
            'viewType' => ViewManager::VIEW_TYPE_FULL,
            'layout' => true
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertSame( $newPathInfo, $request->attributes->get( 'semanticPathinfo' ) );
        $this->assertTrue( $request->attributes->get( 'needsRedirect' ) );
        $this->assertFalse( $request->attributes->get( 'prependSiteaccessOnRedirect' ) );
    }

    /**
     * @expectedException Symfony\Component\Routing\Exception\ResourceNotFoundException
     *
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getUrlAlias
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::matchRequest
     */
    public function testMatchRequestFail()
    {
        $pathInfo = '/foo/bar';
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->throwException( new NotFoundException( 'URLAlias', $pathInfo ) ) );
        $this->router->matchRequest( $request );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getUrlAlias
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::matchRequest
     */
    public function testMatchRequestVirtual()
    {
        $pathInfo = '/foo/bar';
        $newPathInfo = '/foo/bar/baz';
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::VIRTUAL,
                'destination' => $newPathInfo,
                'forward' => true
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertTrue( $request->attributes->get( 'needsRedirect' ) );
        $this->assertSame( $newPathInfo, $request->attributes->get( 'semanticPathinfo' ) );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::getUrlAlias
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::matchRequest
     */
    public function testMatchRequestVirtualInternalForward()
    {
        $pathInfo = '/foo/bar';
        $newPathInfo = '/foo/bar/baz';
        $urlAlias = new URLAlias(
            array(
                'path' => $pathInfo,
                'type' => UrlAlias::VIRTUAL,
                'destination' => $newPathInfo,
                'forward' => false
            )
        );
        $request = $this->getRequestByPathInfo( $pathInfo );
        $this->urlAliasService
            ->expects( $this->once() )
            ->method( 'lookup' )
            ->with( $pathInfo )
            ->will( $this->returnValue( $urlAlias ) );

        $expected = array(
            '_route' => UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
        );
        $this->assertEquals( $expected, $this->router->matchRequest( $request ) );
        $this->assertTrue( $request->attributes->get( 'needsForward' ) );
        $this->assertSame( $newPathInfo, $request->attributes->get( 'semanticPathinfo' ) );
    }

    /**
     * @expectedException Symfony\Component\Routing\Exception\RouteNotFoundException
     *
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateFail()
    {
        $this->router->generate( 'invalidRoute' );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateWithLocation()
    {
        $location = new Location();
        $parameters = array( 'some' => 'thing' );
        $absolute = false;
        $generatedLink = '/foo/bar';
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $location, $parameters, $absolute )
            ->will( $this->returnValue( $generatedLink ) );
        $this->assertSame( $generatedLink, $this->router->generate( $location, $parameters, $absolute ) );
    }

    /**
     * @expectedException \InvalidArgumentException
     *
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateNoLocation()
    {
        $this->router->generate( UrlAliasRouter::URL_ALIAS_ROUTE_NAME, array( 'foo' => 'bar' ) );
    }

    /**
     * @expectedException \LogicException
     *
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateInvalidLocation()
    {
        $this->router->generate( UrlAliasRouter::URL_ALIAS_ROUTE_NAME, array( 'location' => new \stdClass() ) );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateWithLocationId()
    {
        $locationId = 123;
        $location = new Location( array( 'id' => $locationId ) );
        $parameters = array( 'some' => 'thing' );
        $absolute = false;
        $generatedLink = '/foo/bar';
        $this->locationService
            ->expects( $this->once() )
            ->method( 'loadLocation' )
            ->with( $locationId )
            ->will( $this->returnValue( $location ) );
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $location, $parameters, $absolute )
            ->will( $this->returnValue( $generatedLink ) );
        $this->assertSame(
            $generatedLink,
            $this->router->generate(
                UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
                $parameters + array( 'locationId' => $locationId ),
                $absolute
            )
        );
    }

    /**
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::__construct
     * @covers eZ\Publish\Core\MVC\Symfony\Routing\UrlAliasRouter::generate
     */
    public function testGenerateWithLocationAsParameter()
    {
        $locationId = 123;
        $location = new Location( array( 'id' => $locationId ) );
        $parameters = array( 'some' => 'thing' );
        $absolute = false;
        $generatedLink = '/foo/bar';
        $this->urlALiasGenerator
            ->expects( $this->once() )
            ->method( 'generate' )
            ->with( $location, $parameters, $absolute )
            ->will( $this->returnValue( $generatedLink ) );
        $this->assertSame(
            $generatedLink,
            $this->router->generate(
                UrlAliasRouter::URL_ALIAS_ROUTE_NAME,
                $parameters + array( 'location' => $location ),
                $absolute
            )
        );
    }
}
