<?php
namespace Tests;

use ArrayObject;
use PHPUnit\Framework\TestCase;
use function Test\TestHelper\TestContext\afterEach;
use function Test\TestHelper\TestContext\beforeAll;
use function Test\TestHelper\TestContext\beforeEach;
use function Test\TestHelper\TestContext\context;
use function Test\TestHelper\TestContext\it;
use function Test\TestHelper\TestContext\runContext;

class ContextTest extends TestCase
{
    private array $actual = [];
    private array $expect = [];

    /**
     * @dataProvider describe
     */
    public function test()
    {
        runContext($this, ...func_get_args());

        $expected = [



        ];
        $this->assertEquals($this->expect, $this->actual);
    }

    public function describe(): array
    {
        return context('Sample test', function () {

            beforeAll(function () {
                $this->actual[] = 'before 10';
            });

            beforeEach(function () {
                $this->actual[] = 'beforeEach 10';
            });

            afterEach(function () {
                $this->actual[] = 'afterEach 10';
            });

            beforeEach(function () {
                $this->actual[] = 'beforeEach 11';
            });

            afterEach(function () {
                $this->actual[] = 'afterEach 11';
            });

            beforeAll(function () {
                $this->actual[] = 'before 11';
            });

            it('AAA', function () {
                $this->assertTrue(true);
                $this->actual[] = 'AAA';
                $this->expect = [
                    'before 10',
                    'beforeEach 10',
                    'beforeEach 11',
                    'before 11',
                    'AAA',
                    'afterEach 10',
                    'afterEach 11',
                ];
            });

            it('BBB', function () {
                $this->assertTrue(true);
                $this->actual[] = 'BBB';
                $this->expect = [
                    'beforeEach 10',
                    'beforeEach 11',
                    'BBB',
                    'afterEach 10',
                    'afterEach 11',
                ];
            });

            context('CCC', function () {

                beforeAll(function () {
                    $this->actual[] = 'before 20';
                });

                beforeEach(function () {
                    $this->actual[] = 'beforeEach 20';
                });

                afterEach(function () {
                    $this->actual[] = 'afterEach 20';
                });

                it('DDD', function () {
                    $this->assertTrue(true);
                    $this->actual[] = 'DDD';
                    $this->expect = [
                        'beforeEach 10',
                        'beforeEach 11',
                        'before 20',
                        'beforeEach 20',
                        'DDD',
                        'afterEach 10',
                        'afterEach 11',
                        'afterEach 20',
                    ];
                });

                it('EEE', function () {
                    $this->assertTrue(true);
                    $this->actual[] = 'EEE';
                    $this->expect = [
                        'beforeEach 10',
                        'beforeEach 11',
                        'beforeEach 20',
                        'EEE',
                        'afterEach 10',
                        'afterEach 11',
                        'afterEach 20',
                    ];
                });
            });
        });
    }
}
