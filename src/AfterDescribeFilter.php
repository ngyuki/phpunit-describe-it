<?php
namespace ngyuki\PHPUnitDescribeIt;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\TestSuite;

class AfterDescribeFilter
{
    /**
     * @param TestCase $test
     * @param DescribeBlock[] $blocks
     *
     * @return DescribeBlock[]
     */
    public static function filter(TestCase $test, array $blocks): array
    {
        $next = self::getNextTextCase($test);
        if ($next) {
            list (, $nextBlocks) = $next->getProvidedData();
        } else {
            $nextBlocks = [];
        }
        $exitBlocks = [];
        foreach ($blocks as $block) {
            if (!in_array($block, $nextBlocks, true)) {
                $exitBlocks[] = $block;
            }
        }
        return $exitBlocks;
    }

    private static function getNextTextCase(TestCase $test): ?TestCase
    {
        $result = $test->getTestResultObject();
        if ($result === null) {
            return null;
        }
        assert($result instanceof TestResult);
        $suite = self::getParentSuite($test, $result->topTestSuite());
        assert($suite instanceof TestSuite);

        $next = false;
        foreach ($suite as $t) {
            if ($t === $test) {
                $next = true;
            } elseif ($next) {
                if ($t instanceof TestCase) {
                    return $t;
                }
                return null;
            }
        }
        return null;
    }

    private static function getParentSuite(TestCase $test, TestSuite $suite): ?TestSuite
    {
        foreach ($suite as $t) {
            if ($t === $test) {
                return $suite;
            }
            if ($t instanceof TestSuite) {
                $ret = self::getParentSuite($test, $t);
                if ($ret) {
                    return $ret;
                }
            }
        }
        return null;
    }
}
