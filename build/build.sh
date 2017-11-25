#!/usr/bin/env bash

set -o errexit;
set -o nounset;
set -o pipefail;

rootDir="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)";

name="sort-sequel-pro-favourites.phar";

rm -f ${rootDir}/${name};
php -d phar.readonly=0 ${rootDir}/build/build.php;
chmod u+x ${rootDir}/${name};
