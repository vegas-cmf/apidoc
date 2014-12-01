<?php
/**
 * Module.php
 * 
 * @author Uladzislau Zayats <uladzislau.zayats@amsterdam-standard.pl>
 */

namespace ApiBug;

class Module extends \Vegas\Mvc\ModuleAbstract
{
    public function __construct() {
        $this->namespace = __NAMESPACE__;
        $this->dir = __DIR__;
    }
}