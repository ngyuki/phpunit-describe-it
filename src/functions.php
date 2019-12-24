<?php
namespace Test\TestHelper\TestContext;

function runContext(object $instance, callable $func, array $blocks): void
{
    TestContext::instance()->run($instance, $func, $blocks);
}

function context(string $name, callable $func): array
{
    return TestContext::instance()->context($name, $func);
}

function it(string $name, callable $func): void
{
    TestContext::instance()->it($name, $func);
}

function beforeAll(callable $func): void
{
    TestContext::instance()->before(function () use (&$func) {
        try {
            if ($func) {
                $func(...)->call($this);
            }
        } finally {
            $func = null;
        }
    });
}

function beforeEach(callable $func): void
{
    TestContext::instance()->before($func);
}

function afterEach(callable $func): void
{
    TestContext::instance()->after($func);
}
