<?php
namespace Test\TestHelper\TestContext;

use PHPUnit\Framework\TestCase;

class TestContext
{
    private array $tests = [];

    /**
     * @var ContextBlock[]
     */
    private array $blocks = [];

    public static function instance(): self
    {
        static $instance;
        if (!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    /**
     * @param object $instance
     * @param callable $func
     * @param ContextBlock[] $blocks
     */
    public function run(object $instance, callable $func, array $blocks): void
    {
        assert($instance instanceof TestCase);

        foreach ($blocks as $block) {
            foreach ($block->befores as $before) {
                $before(...)->call($instance);
            }
        }

        try {
            $func(...)->call($instance);
        } finally {
            foreach ($blocks as $block) {
                foreach ($block->afters as $after) {
                    $after(...)->call($instance);
                }
            }
        }
    }

    public function context(string $name, callable $func): array
    {
        $this->blocks[] = new ContextBlock($name);
        try {
            $func();
        } finally {
            array_pop($this->blocks);
        }

        $tests = $this->tests;
        if (count($this->blocks) === 0) {
            $this->tests = [];
            $this->blocks = [];
        }

        return $tests;
    }

    public function it(string $name, callable $func): void
    {
        assert($this->blocks);
        $names = array_map(fn (ContextBlock $block) => $block->name, $this->blocks);
        $name = implode(' ', array_merge($names, [$name]));
        for (;;) {
            if (!array_key_exists($name, $this->tests)) {
                break;
            }
            $name .= ' ';
        }
        $this->tests[$name] = [$func, $this->blocks];
    }

    private function top(): ContextBlock
    {
        return end($this->blocks);
    }

    public function before(callable $func): void
    {
        $this->top()->befores[] = $func;
    }

    public function after(callable $func): void
    {
        $this->top()->afters[] = $func;
    }
}
