<?php

namespace ChristopherDarling\ThemeManifestAssets;

use SilverStripe\Core\Config\Config;
use SilverStripe\Control\Director;
use SilverStripe\Core\Path;
use SilverStripe\View\TemplateGlobalProvider;

class ThemeManifestAssets implements TemplateGlobalProvider
{
    /**
     * @config
     * @var string path of the folder that contains self::$manifest_filename
     */
    private static $manifest_base_path = 'themes/default/dist/';

    /**
     * @config
     * @var string
     */
    private static $manifest_filename = 'manifest.json';

    public static function get_template_global_variables()
    {
        return array(
            'ThemeManifestAsset' => 'getPath',
        );
    }

    private static $manifest_cache = null;

    private static function getManifestBasePath()
    {
        return Config::inst()->get(__CLASS__, 'manifest_base_path');
    }

    private static function getManifestFilePath()
    {
        $base_path = self::getManifestBasePath();
        $filename = Config::inst()->get(__CLASS__, 'manifest_filename');

        return Path::join($base_path, $filename);
    }

    private static function getManifest()
    {
        if (self::$manifest_cache !== null) {
            return self::$manifest_cache;
        }

        $manifest = self::getManifestFilePath();
        $absPath = Director::getAbsFile($manifest);

        if (file_exists($absPath)) {
            $contents = json_decode(file_get_contents($absPath), true);

            self::$manifest_cache = $contents;
        } else {
            self::$manifest_cache = false;
        }

        return self::$manifest_cache;
    }

    public static function getPath($path) {
        $manifest = self::getManifest();

        if (isset($manifest[$path])):
            return self::getManifestBasePath() . $manifest[$path];
        endif;

        return false;
    }
}
