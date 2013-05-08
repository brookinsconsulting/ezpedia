#!/bin/bash

. ./bin/shell/common.sh
. ./bin/shell/packagescommon.sh

if ! which php &>/dev/null; then
    echo "No PHP executable found, please add it to the path"
    exit 1
fi

TMPDIR="/tmp/ez-$USER/packages"

[ -d $TMPDIR ] && rm -rf "$TMPDIR"
mkdir -p $TMPDIR || exit 1

PMBIN="./ezpm.php"

SITE_PACKAGES="$TMPDIR/extra.tmp"
SITE_PACKAGES_EXPORT="$TMPDIR/extra"
OUTPUT_REPOSITORY="$TMPDIR/sites"
EXPORT_PATH="packages/styles"

# Check parameters
for arg in $*; do
    case $arg in
	--help|-h)
	    echo "Usage: $0 [options]"
	    echo
	    echo "Options: -h"
	    echo "         --help                     This message"
	    echo "         --export-path=DIR          Where to export the packages, default is 'packages/styles'"
	    echo
	    exit 1
	    ;;
	-q)
	    QUIET="-q"
	    ;;
	--export-path*)
	    if echo $arg | grep -e "--export-path=" >/dev/null; then
		EXPORT_PATH=`echo $arg | sed 's/--export-path=//'`
	    fi
	    ;;
	*)
	    echo "$arg: unkown option specified"
            $0 -h
	    exit 1
	    ;;
    esac;
done

[ -d $EXPORT_PATH ] || { echo "The export path $EXPORT_PATH does not exist"; exit 1; }

[ -z $QUIET ] && echo "Placing packages in $SITE_PACKAGES"

## Common initialization

rm -rf "$OUTPUT_REPOSITORY"
mkdir -p "$OUTPUT_REPOSITORY" || exit 1

rm -rf "$SITE_PACKAGES"
mkdir -p "$SITE_PACKAGES" || exit 1

rm -rf "$SITE_PACKAGES_EXPORT"
mkdir -p "$SITE_PACKAGES_EXPORT" || exit 1


    ./ezpm.php -r "$SITE_PACKAGES" $QUIET \
	create wiki_t01 "Wiki Theme 01" "$VERSION" import  -- \
	set wiki_t01 type sitestyle -- \
	add wiki_t01 file -n sitecssfile design/wiki/stylesheets/wiki_t1/site-colors.css -- \
	add wiki_t01 file -n classescssfile design/wiki/stylesheets/wiki_t1/classes-colors.css -- \
	add wiki_t01 thumbnail -n thumbnail design/wiki/images/wiki_t1.png -- \
	add wiki_t01 file -n image design/wiki/images/wiki_t1/comp025.jpg -- \
	export wiki_t01 -d "$EXPORT_PATH" || exit 1s
