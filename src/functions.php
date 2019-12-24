<?php
namespace ngyuki\PHPUnitDescribeIt;

function describe(string $name, callable $func): void
{
    TestDescribe::instance()->describe($name, $func);
}

function it(string $name, callable $func): void
{
    TestDescribe::instance()->it($name, $func);
}

function before(callable $func): void
{
    TestDescribe::instance()->before(new OneCall($func));
}

function beforeEach(callable $func): void
{
    TestDescribe::instance()->before($func);
}

function after(callable $func): void
{
    TestDescribe::instance()->after(new OneCall($func));
}

function afterEach(callable $func): void
{
    TestDescribe::instance()->after($func);
}
