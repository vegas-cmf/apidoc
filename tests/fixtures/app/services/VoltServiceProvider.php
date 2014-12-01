<?php

class VoltServiceProvider implements \Vegas\DI\ServiceProviderInterface {

    const SERVICE_NAME = 'voltService';


    /**
     * {@inheritdoc}
     */
    public function register(\Phalcon\DiInterface $di)
    {
        //Set the views cache service
        $di->set(self::SERVICE_NAME, function($view, $di) {

            $volt = new \Vegas\Mvc\View\Engine\Volt($view, $di);

            $volt->setOptions([
                "compiledPath" => "../app/compiled-templates/",
                "compiledExtension" => ".compiled"
            ]);

            $compiler = $volt->getCompiler();
            $compiler->addFilter('hash', 'md5');

            return $volt;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [];
    }
}
 