<?php

namespace BraveRats;

use BraveRats\RoundResolver;
use BraveRats\RoundResolvers\CapacityResolver;
use BraveRats\RoundResolvers\ValueResolver;
use Onyx\Providers;
use Silex\Provider\SessionServiceProvider;

class Application extends \Onyx\Application
{
    protected function registerProviders(): void
    {
        $this->register(new SessionServiceProvider());
        $this->register(new Providers\Monolog([
            // insert your loggers here
        ]));
        $this->register(new Providers\Twig());
        $this->register(new Providers\Webpack());

        // Uncomment this line if you're using a RDBMS
        // $this->register(new Providers\DBAL());
    }

    protected function initializeServices(): void
    {
        $this['game'] = function($c) {
            return new Game($c['gameResolver']);
        };

        $this['gameResolver'] = function($c) {
            return new GameResolver($c['roundResolver']);
        };

        $this['roundResolver'] = function($c) {
            return new RoundResolver(new ValueResolver(), new CapacityResolver());
        };

        $this->configureTwig();
    }

    private function configureTwig(): void
    {
        $this['view.manager']->addPath(array(
            $this['root.path'] . 'views/',
        ));
    }

    protected function mountControllerProviders(): void
    {
        $this->mount('/', new Controllers\Home\Provider());
    }
}
