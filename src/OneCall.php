<?php
namespace ngyuki\PHPUnitDescribeIt;

class OneCall
{
    /**
     * @var callable
     */
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __invoke()
    {
        if ($this->callback) {
            ($this->callback)();
            $this->callback = null;
        }
    }
}
