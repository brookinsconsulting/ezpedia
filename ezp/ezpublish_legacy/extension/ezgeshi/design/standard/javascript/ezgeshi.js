/**
 * Utilities for usage with the ezgeshi extension:
 * . patch the debug output report to add links to source of files mentioned
 *
 * Requires JQuery
 */

(function( $ )
{
    $(document).ready(
        function()
        {
            // avoid slowing down production sites
            if ( $('#debug').length == 0 )
            {
                return;
            }

            // complement all links to visual/edit with links to geshi template view
            // (added on the column showing "template loaded"
            $('#debug #templateusage td:nth-child(4)').each(
                function( index )
                {
                    $(this).html( '<a href="' + $(this).parent().parent().find( 'a[href*="/visual/templateedit/"]' ).attr( "href" ).replace( '/visual/templateedit/', '/geshi/highlight/' ) + '" title="View template">' + $(this).html() + '</a>' );
                }
            )

            // since this js is not passed the correct path from template, we have
            // to find out what the prefix is to build eZ urls from scratch
            // And it has to work in all possible configs)
            var prefix = '';
            if ( $('#debug #clearcache').length > 0 )
            {
                prefix = $('#debug #clearcache').attr( "action" ).replace( '/setup/cachetoolbar', '' );
            }
            else if ( $('#debug #templateusage' ).length > 0 )
            {
                prefix = $('#debug #templateusage tr:nth-child(2) td:nth-child(2) a').attr( "href" ).replace( /\/visual\/templateview\/.*/, '' );
            }
            else
            {
                // @bug will not work if in non-vhost mode but with no index.php in path
                // @bug does not work with default (hidden) siteaccess
                if ( document.location.pathname.indexOf( 'index.php' ) != -1 )
                {
                    var pos = document.location.pathname.indexOf( '/', document.location.pathname.indexOf( 'index.php' ) + 10 );
                    if ( pos == -1 )
                    {
                        // no sa
                        prefix = document.location.pathname.substr( 0, document.location.pathname.indexOf( 'index.php' ) + 9 );
                    }
                    else
                    {
                        // with sa
                        prefix = document.location.pathname.substr( 0, pos );
                    }
                }
            }

            // add links to included php files list (from ez 2012.3 / 4.7)
            // @todo (!important) we should remove to remove path to eZ from the link
            $('#debug_includes td').each(
                function( index )
                {

                    if ( $(this).html().substring( 0, 3 ) != '<b>' )
                    {
                        $(this).html( '<a href="' + prefix + '/geshi/highlight/' + $(this).html().replace( /\\/g, '/' ) + '">'  + $(this).html() + '</a>' );
                    }
                }
            )

            // add links to css/js files included by ezjscore
            $('#ezjscpackerusage td:last-child').each(
                function( index )
                {
                    var list = $(this).html().split( /<br>/g );
                    //alert ( typeof list );
                    for ( var i = 0; i < list.length; i++ )
                    {
                        list[i] = '<a href="' + prefix + '/geshi/highlight/' + list[i].replace( /\\/g, '/' ) + '">'  + list[i] + '</a>'
                    }
                    //alert(alist);
                    $(this).html( list.join( '<br/>' ) );
                }
            )

            // last but not least, in error messages that mention tpl files
            $('#debug table[title="Table for actual debug output, shows notices, warnings and errors"] tr[class="error"]').each(
                function( index )
                {
                    var file = $(this).next().find( 'pre' ).html().match( /@ .+(\\|:[0-9]+)\[[0-9]+\]/ );
                    if ( file != null )
                    {
                        var msg = $(this).next().find( 'pre' );
                        if ( file[0].indexOf( ':' ) > 0 )
                        {
                            file = file[0].substr( 2, file[0].indexOf( ':' ) -2 );
                        }
                        else
                        {
                            file = file[0].substr( 2, file[0].indexOf( '\\' ) -2 );
                        }
                        msg.html( msg.html().replace( file, '<a href="' + prefix + '/geshi/highlight/' + file + '">' + file + '</a>' ) );
                    }
                }
            )

            // and warning messages that mention php files
            $('#debug table[title="Table for actual debug output, shows notices, warnings and errors"] tr[class="warning"]').each(
            function( index )
            {
                var file = $(this).next().find( 'pre' ).html().match( / in .+\.php on line/ );
                if ( file != null )
                {
                    var msg = $(this).next().find( 'pre' );
                    /// @todo take care about urls that contain both /index.php and file.php at the end
                    file = file[0].substr( 4, file[0].length -12 );
                    msg.html( msg.html().replace( file, '<a href="' + prefix + '/geshi/highlight/' + file + '">' + file + '</a>' ) );
                }
            }
            )
        }
    );

})(jQuery);
