<?php
/**
 * This file is part of Vegas package
 *
 * @author Slawomir Zytko <slawomir.zytko@gmail.com>
 * @copyright Amsterdam Standard Sp. Z o.o.
 * @homepage http://vegas-cmf.github.io
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
 

namespace Vegas\ApiDoc;

/**
 * Class Benchmark
 * @package Vegas\ApiDoc
 */
class Benchmark 
{
    /**
     * @var int
     */
    private $startedAt = null;

    /**
     * @var int
     */
    private $finishedAt = null;

    /**
     * Starts generation
     */
    public function start()
    {
        $this->startedAt = microtime();
    }

    /**
     * Finished generation
     */
    public function finish()
    {
        $this->finishedAt = microtime();
    }

    /**
     * Returns generation times
     *
     * @return int
     */
    public function getGenerationTime()
    {
        return $this->finishedAt - $this->startedAt;
    }
} 