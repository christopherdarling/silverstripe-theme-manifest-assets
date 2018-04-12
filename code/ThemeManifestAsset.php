<?php

namespace ChristopherDarling\ThemeManifestAssets;

use \Config;
use \Director;
use \SSViewer;

class ThemeManifestAssets implements \TemplateGlobalProvider
{
    /**
     * @config
     * @var string
     */
    private static $manifest_filename = 'assets.json';

    public static function get_template_global_variables() {
        return array(
            'ThemeManifestAsset' => 'getPath',
        );
    }

    private static $manifest_files_cache = null;

    private static function getManifestFilename()
    {
        return Config::inst()->get(__CLASS__, 'manifest_filename');
    }

    private static function getManifestFiles()
    {
        if (null === self::$manifest_files_cache) {
            $manifest = SSViewer::get_theme_folder() . '/dist/' . self::getManifestFilename();
            $absPath = Director::getAbsFile($manifest);

            if (file_exists($absPath)) {
                $contents = json_decode(file_get_contents($absPath), true);

                self::$manifest_files_cache[] = $contents;
            }
        }

        return self::$manifest_files_cache;
    }

    public static function getPath($path) {
        if ($manifests = self::getManifestFiles()):
            foreach ($manifests as $manifest => $map):
                if (isset($map[$path])) {
                    return SSViewer::get_theme_folder() . '/dist/' . $map[$path];
                }
            endforeach;
        endif;

        return false;
    }
}
