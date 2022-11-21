#!/usr/bin/env bash
wget -O overleaf-owncloud-sciebo.zip "https://github.com/Daniel-WWU-IT/overleaf-owncloud/archive/refs/heads/sciebo.zip"
unzip overleaf-owncloud-sciebo.zip
mv overleaf-owncloud-sciebo overleaf_owncloud
cd overleaf_owncloud
chmod 0777 ./appinfo

sudo -u www-data /var/www/owncloud/occ integrity:sign-app \
    --privateKey=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.key \
    --certificate=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.crt \
    --path=/proj/Overleaf/overleaf-owncloud/bin/overleaf_owncloud

cd ..
tar -czf overleaf_owncloud.tar.gz overleaf_owncloud
rm -rf ./overleaf_owncloud
rm -f overleaf-owncloud-sciebo.zip
mv overleaf_owncloud.tar.gz ../overleaf_owncloud.tar.gz

