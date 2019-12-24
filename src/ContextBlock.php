<?php
namespace Test\TestHelper\TestContext;

class ContextBlock
{
    public string $name;

    /**
     * @var callable[]
     */
    public array $befores = [];

    /**
     * @var callable[]
     */
    public array $afters = [];

    public function __construct(string $name)
    {
        $this->name = $name;
    }
}
