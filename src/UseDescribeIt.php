<?php
namespace ngyuki\PHPUnitDescribeIt;

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/functions.php';

trait UseDescribeIt
{
    public function dataProvider(): array
    {
        $t = TestDescribe::instance();
        $this->declare();
        return $t->getAndReset();
    }

    abstract public function declare(): void;

    /**
     * @test
     * @dataProvider dataProvider
     * @param callable $func
     * @param DescribeBlock[] $blocks
     */
    public function t(callable $func, array $blocks): void
    {
        $self = $this;
        assert($self instanceof TestCase);

        foreach ($blocks as $block) {
            foreach ($block->befores as $before) {
                $before();
            }
        }

        try {
            $func();
        } finally {
            $exitBlocks = AfterDescribeFilter::filter($self, $blocks);
            foreach ($blocks as $block) {
                foreach ($block->afters as $after) {
                    if ($after instanceof OneCall) {
                        if (in_array($block, $exitBlocks, true)) {
                            $after();
                        }
                    } else {
                        $after();
                    }
                }
            }
        }
    }
}
