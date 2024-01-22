# Reset The SEO Framework - Extension Manager

This is a helper plugin when your activation data gets corrupted.

## What is removed?

1. Your activation data for Extension Manager.
2. Your activated extensions are now deactivated.

## What isn't removed?

1. All post metadata from Extension Manager remain unchanged.
2. All Extension settings remain unchanged.

Monitor will not have its data removed, but it will request you to reconnect after activating. This is because your site's secret keys have changed.

## Usage instructions

1. [Download ZIP](https://github.com/sybrew/reset-extension-manager-activation/archive/master.zip)
2. Log in to your WordPress Dashboard.
3. Go to Plugins > Add New.
4. Click "Upload Plugin" at the top.
5. Upload the `reset-extension-manager-activation.zip` file you just downloaded.
6. Either network-activate this plugin or activate it on a single site.
	- If you **network activated** the plugin, Extension Manager will be reset for **ALL SITES in the network**.
	- If you activate the plugin on a **single site**, Extension Manager will be reset for the **current site**.
7. That's it! You can now delete this plugin from your site.
