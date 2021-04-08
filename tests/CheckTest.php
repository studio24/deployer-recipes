<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Studio24\Deployer\Check;

class CheckTest extends TestCase
{
    public function testIsLocalDeployer()
    {
        $includePaths = ["/Users/sjones/Sites/client/project/vendor/deployer/deployer/bin/dep"];
        $this->assertTrue(Check::isLocalDeployer($includePaths));

        $includePaths = ["/usr/local/bin/dep"];
        $this->assertFalse(Check::isLocalDeployer($includePaths));
    }
}