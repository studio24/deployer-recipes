<?php

namespace Studio24\Deployer;

class Check
{

    /**
     * Are we using an installation of Deployer local to your project
     * @param array|null $includedFilePaths
     * @return bool True if local, False if global installation
     */
    public static function isLocalDeployer(?array $includedFilePaths = null): bool
    {
        if (null === $includedFilePaths) {
            $includedFilePaths = get_included_files();
        }
        if (strpos($includedFilePaths[0], '/vendor/deployer/deployer/bin/dep') !== false) {
            return true;
        }
        return false;
    }

}