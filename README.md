# Pods Multisite
Supercharge Pods for your multisites  
Version: 0.1 (dev)

## Sync Pods

Sync your Pods accross your network of sites  
Before using the sync options, please keep the following notes in mind:

- Sync is not bi-directional by default. If you want to sync both ways you need to check the current site as well
- This plugin should be enabled on every site that you want to sync FROM. The sites you sync TO don't require this plugin to be active (unless you also want to sync FROM those sites as well..) See **Sync Logic** for some config examples.
- If you use bi-directional relationship field, please make sure the relationship fields are available in the remote site.

### Sync logic

#### Config 1: "Master site" > Sync only from 1 site to the others.

Make one of your sites your "master" site and sync to your other sites.

1. Activate Pods on all sites
2. Activate Pods Multisite on you site you want to sync from (most likely your primary site)
3. Enable synchronisation on your Pods. This needs to be set for every Pod.
4. Every time you save a Pod **on your master site** the options and configuration will be synced to the sites you have enabled for synchronisation.

#### Config 2: "Full sync" > Sync from all sites to all sites

Bi-directional synchronisation.

1. Activate Pods on all sites
2. Activate Pods Multisite on all sites
3. Enable synchronisation on your Pods for all sites. This needs to be set for every Pod. _This configuration will only need to be done on 1 of your sites. Pods Multisite will also sync the sync-configuration (sync-ception yay!)_
4. Every time you save a Pod **on any site** the options and configuration will be synced to the sites you have enabled for synchronisation.

#### Config 3: "Partial sync" > Sync from/to a selection of sites

Bi-directional synchronisation between some sites in your network.
Basically works exactly the same als "Full sync" but you only select the sites you want to sync and leave the others unchecked ;).
