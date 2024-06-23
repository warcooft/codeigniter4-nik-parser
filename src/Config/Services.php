<?php

namespace Aselsan\Codeigniter4NikParser\Config;

use CodeIgniter\Config\BaseService;
use Aselsan\Codeigniter4NikParser\NikParser;

class Services extends BaseService
{
    /**
     * Return the NikParser Instance.
     *
     * @return NikParser
     */
    public static function nikparser($getShared = true): NikParser
    {
        if ($getShared) {
            return static::getSharedInstance('nikparser');
        }

        return new NikParser();
    }
}
