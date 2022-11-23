#!/usr/bin/env bash
cd /proj/Overleaf/overleaf-owncloud/
chmod 0777 ./appinfo

sudo rm -f ./appinfo/signature.json
sudo -u www-data /var/www/owncloud/occ integrity:sign-app \
    --privateKey=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.key \
    --certificate=/proj/Overleaf/overleaf-owncloud/certs/overleaf_owncloud.crt \
    --path=/proj/Overleaf/overleaf-owncloud/
sudo chmod 0555 ./appinfo/signature.json

