# Theme Manifest assets

loads a JSON manifest file from {theme}/dist/assets.json, looks up a given path and outputs the hashed filename

## Example

### Folder structure
dist/
 - *subfolders*
 - assets.json

### assets.json
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
