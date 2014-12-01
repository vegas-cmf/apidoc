<?php

class ViewServiceProvider implements \Vegas\DI\ServiceProviderInterface {

    const SERVICE_NAME = 'view';


    /**
     * {@inheritdoc}
     */
    public function register(\Phalcon\DiInterface $di)
    {
        //Set the views cache service
        $di->set(self::SERVICE_NAME, function() {

            $view = new \Vegas\Mvc\View();

            $view->setViewsDir('../app/views/');

            $view->registerEngines([
                ".volt" => 'voltService'
            ]);

            return $view;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getDependencies()
    {
        return [VoltServiceProvider::SERVICE_NAME];
    }
}
 