<?php
namespace Tests;

use ArrayObject;
use PHPUnit\Framework\TestCase;
use ngyuki\PHPUnitDescribeIt\UseDescribeIt;
use function ngyuki\PHPUnitDescribeIt\after;
use function ngyuki\PHPUnitDescribeIt\afterEach;
use function ngyuki\PHPUnitDescribeIt\before;
use function ngyuki\PHPUnitDescribeIt\beforeEach;
use function ngyuki\PHPUnitDescribeIt\describe;
use function ngyuki\PHPUnitDescribeIt\it;

class DescribeItTest extends TestCase
{
    use UseDescribeIt;

    /**
     * @var ArrayObject
     */
    private static $arr;

    public function declare(): void
    {
        self::$arr = new ArrayObject();

        describe('Sample test', function () {

            before(function () {
                self::$arr[] = 'before 10';
            });

            after(function () {
                self::$arr[] = 'after 10';
            });

            beforeEach(function () {
                self::$arr[] = 'beforeEach 10';
            });

            afterEach(function () {
                self::$arr[] = 'afterEach 10';
            });

            beforeEach(function () {
                self::$arr[] = 'beforeEach 11';
            });

            afterEach(function () {
                self::$arr[] = 'afterEach 11';
            });

            after(function () {
                self::$arr[] = 'after 11';
            });

            before(function () {
                self::$arr[] = 'before 11';
            });

            it('AAA', function () {
                $this->assertTrue(true);
                self::$arr[] = 'AAA';
            });

            it('BBB', function () {
                $this->assertTrue(true);
                self::$arr[] = 'BBB';
            });

            describe('CCC', function () {

                before(function () {
                    self::$arr[] = 'before 20';
                });

                after(function () {
                    self::$arr[] = 'after 20';
                });

                beforeEach(function () {
                    self::$arr[] = 'beforeEach 20';
                });

                afterEach(function () {
                    self::$arr[] = 'afterEach 20';
                });

                it('DDD', function () {
                    $this->assertTrue(true);
                    self::$arr[] = 'DDD';
                });

                it('EEE', function () {
                    $this->assertTrue(true);
                    self::$arr[] = 'EEE';
                });
            });

            after(function () {
                $expected = [
                    'before 10',
                    'beforeEach 10',
                    'beforeEach 11',
                    'before 11',
                    'AAA',
                    'afterEach 10',
                    'afterEach 11',

                    'beforeEach 10',
                    'beforeEach 11',
                    'BBB',
                    'afterEach 10',
                    'afterEach 11',

                    'beforeEach 10',
                    'beforeEach 11',
                    'before 20',
                    'beforeEach 20',
                    'DDD',
                    'afterEach 10',
                    'afterEach 11',
                    'afterEach 20',

                    'beforeEach 10',
                    'beforeEach 11',
                    'beforeEach 20',
                    'EEE',
                    'after 10',
                    'afterEach 10',
                    'afterEach 11',
                    'after 11',
                ];
                $this->assertEquals($expected, self::$arr->getArrayCopy());
            });
        });
    }
}
