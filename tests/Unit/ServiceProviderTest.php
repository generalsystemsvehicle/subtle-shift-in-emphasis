<?php

namespace GeneralSystemsVehicle\LearnUpon\Tests\Unit;

use GeneralSystemsVehicle\LearnUpon\Tests\Stubs\StubbedContract;
use GeneralSystemsVehicle\LearnUpon\Tests\Stubs\StubbedEvent;
use GeneralSystemsVehicle\LearnUpon\Tests\Stubs\StubbedImplementation;
use GeneralSystemsVehicle\LearnUpon\Tests\Stubs\StubbedListener;
use GeneralSystemsVehicle\LearnUpon\Tests\TestCase;
use GeneralSystemsVehicle\LearnUpon\LearnUponServiceProvider;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Events\Dispatcher;

class ServiceProviderTest extends TestCase
{
    function test_it_sets_up_a_listener()
    {
        $dispatcher = $this->app->make(Dispatcher::class);

        $dispatcher->forget(StubbedEvent::class);

        $this->assertFalse($dispatcher->hasListeners(StubbedEvent::class));

        $provider = new LearnUponServiceProvider($this->app);

        $this->setProperty($provider, 'events', [
            StubbedEvent::class => [
                StubbedListener::class,
            ],
        ]);

        $this->invokeMethod($provider, 'bootEvents', [ ]);

        $this->assertTrue($dispatcher->hasListeners(StubbedEvent::class));
    }

    function test_it_cannot_bind_a_contract_without_an_implementation()
    {
        $this->expectException(BindingResolutionException::class);

        $this->app->make(StubbedContract::class);
    }

    function test_it_binds_a_contract_to_an_implementation()
    {
        $provider = new LearnUponServiceProvider($this->app);

        $this->setProperty($provider, 'serviceBindings', [
            StubbedContract::class => StubbedImplementation::class,
        ]);

        $this->invokeMethod($provider, 'registerServices');

        $contract = $this->app->make(StubbedContract::class);

        $this->assertTrue($contract instanceof StubbedImplementation);
    }
}
