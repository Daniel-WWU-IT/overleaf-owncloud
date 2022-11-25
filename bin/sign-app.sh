#!/usr/bin/env bash
cd /proj/Overleaf/overleaf-owncloud/
cp -r . /tmp/overleaf-owncloud/
cd /tmp/overleaf-owncloud/
rm -rf .idea/
rm -rf .git/
chmod 0777 ./appinfo

sudo rm -f ./appinfo/signature.json
sudo -u www-data /var/www/owncloud/occ integrity:sign-app \
    --privateKey=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.key \
    --certificate=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.crt \
    --path=/tmp/overleaf-owncloud/
sudo chmod 0555 ./appinfo/signature.json

cd ..
mv overleaf-owncloud overleaf_owncloud
tar -czf overleaf_owncloud.tar.gz overleaf_owncloud
mv overleaf_owncloud.tar.gz /proj/Overleaf/overleaf-owncloud/
rm -rf /tmp/overleaf_owncloud/

