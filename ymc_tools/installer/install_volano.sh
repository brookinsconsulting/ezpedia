#!/bin/bash


param_count=$#
pathToTheCodeDir="$(dirname $1)/ezp"
pathToTheVarStorageDir=$2


###Common
function scriptHelp
{
    echo "This script installs eZp into the current dir"
    echo ""
    echo "Usage: install_volano.sh pathToTheCodeDir pathToTheVarStorageDir"
    echo "====="
    echo ""
    echo "pathToTheCodeDir: Where the eZ publish code is found on the local drive (needs to end with ezp)..."
    echo ""
    echo "pathToTheVarStorageDir: The local path to a directory where the binary-files are stored. Fell free to use a relative one..."
    echo ""
    exit 1
}


function volanoInstallerParamChecks
{
  if [ "$pathToTheVarStorageDir" = "" ]; then
      scriptHelp
  fi

  if [ $param_count -ne 2 ]; then
    scriptHelp
  fi
}

function volanoInstallerLinkVarStorage
{
  echo "-> Replacing downloaded var/storage dir"
  rm -rf var/storage
  if [ $(echo $pathToTheVarStorageDir | grep -c -E -e '^/') -le 0 ]; then
    ln -s ../$pathToTheVarStorageDir var/storage
  else
    ln -s $pathToTheVarStorageDir var/storage
  fi
}


function fixupDirPerms
{
  DIR_MODE=777
  FILE_MODE=666

  if [ ! -f "index.php" -a \
       ! -f "access.php" -a \
       ! -f "pre_check.php" -a \
       ! -d "bin" -a \
       ! -d "lib" -a \
       ! -d "kernel" ] ; then
       echo "Function '$0' called from a wrong directory"
       return 1
  fi

  if [ ! -d extension ]; then
      mkdir extension
      echo "Created extension"
  fi

  if [ ! -d var/autoload ]; then
      mkdir var/autoload
      echo "Created var/autoload"
  fi

  if [ ! -d var/webdav ]; then
      mkdir var/webdav
      echo "Created var/webdav"
  fi

  if [ ! -d var/cache/ini ]; then
      mkdir var/cache/ini
      echo "Created var/cache/ini"
  fi

  if [ ! -d var/cache/texttoimage ]; then
      mkdir var/cache/texttoimage
      echo "Created var/cache/texttoimage"
  fi

  if [ ! -d var/cache/codepages ]; then
      mkdir var/cache/codepages
      echo "Created var/cache/codepages"
  fi

  if [ ! -d var/cache/translation ]; then
      mkdir var/cache/translation
      echo "Created var/cache/translation"
  fi

  if [ ! -d var/storage/packages ]; then
      mkdir var/storage/packages
      echo "Created var/storage/packages"
  fi

  if [ ! -d var/cache/template/tree ]; then
      mkdir -p var/cache/template/tree
      echo "Created var/cache/template/tree"
  fi

  if [ ! -d var/cache/template/process ]; then
      mkdir -p var/cache/template/process
      echo "Created var/cache/template/process"
  fi

  if [ ! -d var/log ]; then
      mkdir var/log
      echo "Created var/log"
  fi

  LOGFILES="error.log warning.log notice.log debug.log"
  for LOGFILE in $LOGFILES; do
      LOGPATH="var/log/$LOGFILE"
      if [ -f $LOGPATH ]; then
      chmod $FILE_MODE $LOGPATH
      fi
  done

  chmod $DIR_MODE var
  chmod $DIR_MODE design
  chmod $DIR_MODE var/log
  chmod $DIR_MODE var/cache/
  chmod $DIR_MODE var/cache/ini
  chmod $DIR_MODE var/cache/codepages
  chmod $DIR_MODE var/cache/translation
  chmod $DIR_MODE var/cache/texttoimage
  chmod $DIR_MODE var/storage/packages

  chmod -R $DIR_MODE var/autoload
  chmod $DIR_MODE var/webdav
  chmod -R $DIR_MODE var/cache/template

  return 0
}


volanoInstallerParamChecks

current_dir=$(basename $(pwd))

if [ ! -d "$pathToTheCodeDir" ]; then
  echo "No such directory '$pathToTheCodeDir'" 1>&2
  exit 1
fi

if [ ! -f "$pathToTheCodeDir/index.php" ]; then
  echo "Missing file '$pathToTheCodeDir/index.php'" 1>&2
  exit 1
fi

cd .. || exit 1
rm -r $current_dir || exit 1
ln -s $pathToTheCodeDir $current_dir || exit 1
cd $current_dir || exit 1

if [ ! -d "var" ]; then
  mkdir var || exit 1
fi

if [ ! -d "var/cache" ]; then
  mkdir var/cache || exit 1
fi

volanoInstallerLinkVarStorage
fixupDirPerms

echo "-----------"
echo "All done..."
echo "-----------"

