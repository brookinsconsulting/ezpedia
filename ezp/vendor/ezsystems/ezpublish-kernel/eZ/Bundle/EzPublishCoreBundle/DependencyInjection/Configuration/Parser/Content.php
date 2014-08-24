<?php
/**
 * File containing the Content class.
 *
 * @copyright Copyright (C) eZ Systems AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 * @version 2014.07.0
 */

namespace eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\Parser;

use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\AbstractParser;
use eZ\Bundle\EzPublishCoreBundle\DependencyInjection\Configuration\SiteAccessAware\ContextualizerInterface;
use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Configuration parser handling content related config
 */
class Content extends AbstractParser
{
    /**
     * Adds semantic configuration definition.
     *
     * @param \Symfony\Component\Config\Definition\Builder\NodeBuilder $nodeBuilder Node just under ezpublish.system.<siteaccess>
     *
     * @return void
     */
    public function addSemanticConfig( NodeBuilder $nodeBuilder )
    {
        $nodeBuilder
            ->arrayNode( 'content' )
                ->info( 'Content related configuration' )
                ->children()
                    ->booleanNode( 'view_cache' )->defaultValue( true )->end()
                    ->booleanNode( 'ttl_cache' )->defaultValue( true )->end()
                    ->scalarNode( 'default_ttl' )->info( 'Default value for TTL cache, in seconds' )->defaultValue( 60 )->end()
                    ->arrayNode( 'tree_root' )
                        ->canBeUnset()
                        ->children()
                            ->integerNode( 'location_id' )
                                ->info( "Root locationId for routing and link generation.\nUseful for multisite apps with one repository." )
                                ->isRequired()
                            ->end()
                            ->arrayNode( 'excluded_uri_prefixes' )
                                ->info( "URI prefixes that are allowed to be outside the content tree\n(useful for content sharing between multiple sites).\nPrefixes are not case sensitive" )
                                ->example( array( '/media/images', '/products' ) )
                                ->prototype( 'scalar' )->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
            ->arrayNode( 'fieldtypes' )
                ->children()
                    ->arrayNode( 'ezxml' )
                        ->children()
                            ->arrayNode( 'custom_tags' )
                                ->info( 'Custom XSL stylesheets to use for XmlText transformation to HTML5. Useful for "custom tags".' )
                                ->example(
                                    array(
                                        'path' => '%kernel.root_dir%/../src/Acme/TestBundle/Resources/myTag.xsl',
                                        'priority' => 10
                                    )
                                )
                                ->prototype( 'array' )
                                    ->children()
                                        ->scalarNode( 'path' )
                                            ->info( 'Path of the XSL stylesheet to load.' )
                                            ->isRequired()
                                        ->end()
                                        ->integerNode( 'priority' )
                                            ->info( 'Priority in the loading order. A high value will have higher precedence in overriding XSL templates.' )
                                            ->defaultValue( 0 )
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                    ->arrayNode( 'ezrichtext' )
                        ->children()
                            ->arrayNode( 'output_custom_tags' )
                                ->info( 'Custom XSL stylesheets to use for RichText transformation to HTML5. Useful for "custom tags".' )
                                ->example(
                                    array(
                                        'path' => '%kernel.root_dir%/../src/Acme/TestBundle/Resources/myTag.xsl',
                                        'priority' => 10
                                    )
                                )
                                ->prototype( 'array' )
                                    ->children()
                                        ->scalarNode( 'path' )
                                            ->info( 'Path of the XSL stylesheet to load.' )
                                            ->isRequired()
                                        ->end()
                                        ->integerNode( 'priority' )
                                            ->info( 'Priority in the loading order. A high value will have higher precedence in overriding XSL templates.' )
                                            ->defaultValue( 0 )
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode( 'edit_custom_tags' )
                                ->info( 'Custom XSL stylesheets to use for RichText transformation to HTML5. Useful for "custom tags".' )
                                ->example(
                                    array(
                                        'path' => '%kernel.root_dir%/../src/Acme/TestBundle/Resources/myTag.xsl',
                                        'priority' => 10
                                    )
                                )
                                ->prototype( 'array' )
                                    ->children()
                                        ->scalarNode( 'path' )
                                            ->info( 'Path of the XSL stylesheet to load.' )
                                            ->isRequired()
                                        ->end()
                                        ->integerNode( 'priority' )
                                            ->info( 'Priority in the loading order. A high value will have higher precedence in overriding XSL templates.' )
                                            ->defaultValue( 0 )
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                            ->arrayNode( 'input_custom_tags' )
                                ->info( 'Custom XSL stylesheets to use for RichText transformation to HTML5. Useful for "custom tags".' )
                                ->example(
                                    array(
                                        'path' => '%kernel.root_dir%/../src/Acme/TestBundle/Resources/myTag.xsl',
                                        'priority' => 10
                                    )
                                )
                                ->prototype( 'array' )
                                    ->children()
                                        ->scalarNode( 'path' )
                                            ->info( 'Path of the XSL stylesheet to load.' )
                                            ->isRequired()
                                        ->end()
                                        ->integerNode( 'priority' )
                                            ->info( 'Priority in the loading order. A high value will have higher precedence in overriding XSL templates.' )
                                            ->defaultValue( 0 )
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    public function mapConfig( array &$scopeSettings, $currentScope, ContextualizerInterface $contextualizer )
    {
        if ( !empty( $scopeSettings['content'] ) )
        {
            $contextualizer->setContextualParameter( 'content.view_cache', $currentScope, $scopeSettings['content']['view_cache'] );
            $contextualizer->setContextualParameter( 'content.ttl_cache', $currentScope, $scopeSettings['content']['ttl_cache'] );
            $contextualizer->setContextualParameter( 'content.default_ttl', $currentScope, $scopeSettings['content']['default_ttl'] );

            if ( isset( $scopeSettings['content']['tree_root'] ) )
            {
                $contextualizer->setContextualParameter(
                    'content.tree_root.location_id',
                    $currentScope,
                    $scopeSettings['content']['tree_root']['location_id']
                );
                if ( isset( $scopeSettings['content']['tree_root']['excluded_uri_prefixes'] ) )
                {
                    $contextualizer->setContextualParameter(
                        'content.tree_root.excluded_uri_prefixes',
                        $currentScope,
                        $scopeSettings['content']['tree_root']['excluded_uri_prefixes']
                    );
                }
            }
        }

        if ( !empty( $scopeSettings['fieldtypes'] ) )
        {
            // Workaround to be able to use registerInternalConfigArray() which only supports first level entries.
            if ( isset( $scopeSettings['fieldtypes']['ezxml']['custom_tags'] ) )
            {
                $scopeSettings['fieldtypes.ezxml.custom_xsl'] = $scopeSettings['fieldtypes']['ezxml']['custom_tags'];
                unset( $scopeSettings['fieldtypes']['ezxml']['custom_tags'] );
            }
            if ( isset( $scopeSettings['fieldtypes']['ezrichtext']['output_custom_tags'] ) )
            {
                $scopeSettings['fieldtypes.ezrichtext.output_custom_xsl'] = $scopeSettings['fieldtypes']['ezrichtext']['output_custom_tags'];
                unset( $scopeSettings['fieldtypes']['ezrichtext']['output_custom_tags'] );
            }
            if ( isset( $scopeSettings['fieldtypes']['ezrichtext']['edit_custom_tags'] ) )
            {
                $scopeSettings['fieldtypes.ezrichtext.edit_custom_xsl'] = $scopeSettings['fieldtypes']['ezrichtext']['edit_custom_tags'];
                unset( $scopeSettings['fieldtypes']['ezrichtext']['edit_custom_tags'] );
            }
            if ( isset( $scopeSettings['fieldtypes']['ezrichtext']['input_custom_tags'] ) )
            {
                $scopeSettings['fieldtypes.ezrichtext.input_custom_xsl'] = $scopeSettings['fieldtypes']['ezrichtext']['input_custom_tags'];
                unset( $scopeSettings['fieldtypes']['ezrichtext']['input_custom_tags'] );
            }
        }
    }

    public function postMap( array $config, ContextualizerInterface $contextualizer )
    {
        $contextualizer->mapConfigArray( 'fieldtypes.ezxml.custom_xsl', $config );
        $contextualizer->mapConfigArray( 'fieldtypes.ezrichtext.output_custom_xsl', $config );
        $contextualizer->mapConfigArray( 'fieldtypes.ezrichtext.edit_custom_xsl', $config );
        $contextualizer->mapConfigArray( 'fieldtypes.ezrichtext.input_custom_xsl', $config );
    }
}
