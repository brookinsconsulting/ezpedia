<?php
/**
 * File containing the ConfigParser class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use eZ\Publish\Core\Base\Exceptions\InvalidArgumentType;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;

/**
 * Main configuration parser/mapper.
 * It acts as a proxy to inner parsers.
 */
class ConfigParser implements ParserInterface
{
    /**
     * @var \eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ParserInterface[]
     */
    private $configParsers;

    public function __construct( array $configParsers = array() )
    {
        foreach ( $configParsers as $parser )
        {
            if ( !$parser instanceof ParserInterface )
            {
                throw new InvalidArgumentType(
                    'Inner config parser',
                    'eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ParserInterface',
                    $parser
                );
            }
        }

        $this->configParsers = $configParsers;
    }

    /**
     * @param \eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ParserInterface[] $configParsers
     */
    public function setConfigParsers( $configParsers )
    {
        $this->configParsers = $configParsers;
    }

    /**
     * @return \eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\ParserInterface[]
     */
    public function getConfigParsers()
    {
        return $this->configParsers;
    }

    public function mapConfig( array &$scopeSettings, $currentScope, ContextualizerInterface $contextualizer )
    {
        foreach ( $this->configParsers as $parser )
        {
            $parser->mapConfig( $scopeSettings, $currentScope, $contextualizer );
        }
    }

    public function preMap( array $config, ContextualizerInterface $contextualizer )
    {
        foreach ( $this->configParsers as $parser )
        {
            $parser->preMap( $config, $contextualizer );
        }
    }

    public function postMap( array $config, ContextualizerInterface $contextualizer )
    {
        foreach ( $this->configParsers as $parser )
        {
            $parser->postMap( $config, $contextualizer );
        }
    }

    public function addSemanticConfig( NodeBuilder $nodeBuilder )
    {
        foreach ( $this->configParsers as $parser )
        {
            $parser->addSemanticConfig( $nodeBuilder );
        }
    }
}
