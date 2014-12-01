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

namespace Vegas\ApiDoc;

/**
 * Interface RendererInterface
 *
 * Each output renderer must implements this interface
 *
 * @package Vegas\ApiDoc
 */
interface RendererInterface
{
    /**
     * Renders output content
     *
     * @return string
     */
    public function render();
}
 