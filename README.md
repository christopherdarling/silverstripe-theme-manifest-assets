# Theme Manifest assets

loads a JSON manifest file (default: themes/default/mainifest.json), looks up a given path and outputs the hashed filename

## Example

### Folder structure
dist/
 - *assets*.js
 - manifest.json

### manifest.json
```
{
  'img/logo.png': 'img/logo_HASH.png'
}
```

### .ss template
```
<img src="{$ThemeManifestAsset(img/logo.png)}" alt="Logo">
```
Will output
```
<img src="themes/default/dist/img/logo_HASH.png" alt="Logo">
```
