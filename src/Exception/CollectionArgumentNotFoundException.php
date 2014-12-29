<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawek@amsterdam-standard.pl>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Vegas\ApiDoc\Exception;

use Vegas\ApiDoc\Exception;

/**
 * Class CollectionArgumentNotFoundException
 * @package Vegas\ApiDoc\Exception
 */
class CollectionArgumentNotFoundException extends Exception
{
    protected $message = 'Argument \'%s\' was not found in collection \'%s\'';

    /**
     * @param string $collection
     * @param int $argument
     */
    public function __construct($collection, $argument)
    {
        $this->message = sprintf($this->message, $argument, $collection);
    }
}
