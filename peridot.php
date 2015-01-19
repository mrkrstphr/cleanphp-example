<?php

use Evenement\EventEmitterInterface;
use Peridot\Plugin\Prophecy\ProphecyPlugin;
use Peridot\Plugin\Watcher\WatcherPlugin;

return function(EventEmitterInterface $emitter) {
    $watcher = new WatcherPlugin($emitter);
    $watcher->track(__DIR__ . '/src');
    $watcher->track(__DIR__ . '/module');

    new ProphecyPlugin($emitter);
};
