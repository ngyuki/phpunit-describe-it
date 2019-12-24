<?php
namespace ngyuki\PHPUnitDescribeIt;

class TestDescribe
{
    /**
     * @var array
     */
    private $tests = [];

    /**
     * @var array
     */
    private $names = [];

    /**
     * @var array
     */
    private $blocks = [];

    public static function instance(): self
    {
        static $instance;
        if (!$instance) {
            $instance = new static();
        }
        return $instance;
    }

    public function getAndReset(): array
    {
        $tests = $this->tests;

        $this->tests = [];
        $this->names = [];
        $this->blocks = [];

        return $tests;
    }

    public function describe(string $name, callable $func): void
    {
        $this->names[] = $name;
        $this->blocks[] = new DescribeBlock();

        $func();

        array_pop($this->names);
        array_pop($this->blocks);
    }

    public function it(string $name, callable $func): void
    {
        assert($this->names);

        $name = implode(' ', array_merge($this->names, [$name]));
        for (;;) {
            if (!array_key_exists($name, $this->tests)) {
                break;
            }
            $name .= ' ';
        }

        $this->tests[$name] = [$func, $this->blocks];
    }

    private function top(): DescribeBlock
    {
        return end($this->blocks);
    }

    public function before(callable $func)
    {
        $this->top()->befores[] = $func;
    }

    public function after(callable $func)
    {
        $this->top()->afters[] = $func;
    }
}
