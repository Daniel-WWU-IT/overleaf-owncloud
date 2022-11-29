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

cp -f ./appinfo/signature.json /proj/Overleaf/overleaf-owncloud/appinfo/
rm -rf /tmp/overleaf_owncloud/

