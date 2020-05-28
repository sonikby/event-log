<?php

declare(strict_types=1);

namespace Otcstores\EventLog\Doctrine\Driver;

use Doctrine\ORM\Configuration;
use Doctrine\ORM\Mapping\Driver\XmlDriver;
use SplFileInfo;

class MappingDriver
{
    /**
     * @var Configuration $config
     */
    private $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
        $driver = new XmlDriver($this->getFiles());
        $config->setMetadataDriverImpl($driver);
        $a = $config->getEntityNamespaces();
        return $a;
    }

    private function getFiles(): array
    {
        $dir = __DIR__.'/../Mapping';
        $files = array_map(function ($val) use ($dir){
            return $dir.'/'.$val;
        }, scandir($dir));

        return  array_filter($files, function ($val){
            $info = new SplFileInfo($val);
            return $info->getExtension() === 'xml';
        });
    }
}