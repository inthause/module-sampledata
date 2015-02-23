#!/bin/sh
php bin/change.phar rbs_elasticsearch:client front --delete-all
php bin/change.phar rbs_sampledata:set-defaults --webStore=first --billingArea=first --groupAttribute=first --section=first
php bin/change.phar rbs_sampledata:import-sections Plugins/Modules/Rbs/Sampledata/Assets/Data/formatted-categories.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/apparel.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/appliance.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/baby.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/beauty.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/electronics.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/jewelry.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/luggage.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/shoes.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/toys.json
php bin/change.phar rbs_sampledata:import-products Plugins/Modules/Rbs/Sampledata/Assets/Data/products/watches.json