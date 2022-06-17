<?php

/*
 * This file is part of Flarum.
 *
 * For detailed copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Flarum\Notification;

use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Notification\Blueprint\DiscussionRenamedBlueprint;
use Illuminate\Contracts\Container\Container;

class NotificationServiceProvider extends AbstractServiceProvider
{
    /**
     * {@inheritdoc}
     */
    public function register(): void
    {
        $this->container->singleton('flarum.notification.drivers', function () {
            return [
                'alert' => Driver\AlertNotificationDriver::class,
                'email' => Driver\EmailNotificationDriver::class,
            ];
        });

        $this->container->singleton('flarum.notification.blueprints', function () {
            return [
                DiscussionRenamedBlueprint::class => ['alert']
            ];
        });
    }

    /**
     * {@inheritdoc}
     */
    public function boot(Container $container): void
    {
        $this->setNotificationDrivers($container);
        $this->setNotificationTypes($container);
    }

    /**
     * Register notification drivers.
     */
    protected function setNotificationDrivers(Container $container): void
    {
        foreach ($container->make('flarum.notification.drivers') as $driverName => $driver) {
            NotificationSyncer::addNotificationDriver($driverName, $container->make($driver));
        }
    }

    /**
     * Register notification types.
     */
    protected function setNotificationTypes(Container $container): void
    {
        $blueprints = $container->make('flarum.notification.blueprints');

        foreach ($blueprints as $blueprint => $driversEnabledByDefault) {
            $this->addType($blueprint, $driversEnabledByDefault);
        }
    }

    protected function addType(string $blueprint, array $driversEnabledByDefault): void
    {
        Notification::setSubjectModel(
            $type = $blueprint::getType(),
            $blueprint::getSubjectModel()
        );

        foreach (NotificationSyncer::getNotificationDrivers() as $driverName => $driver) {
            $driver->registerType(
                $blueprint,
                $driversEnabledByDefault
            );
        }
    }
}
