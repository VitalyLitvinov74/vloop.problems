<?php


namespace vloop\problems\entities\report;


use vloop\problems\entities\interfaces\Problem;
use vloop\problems\entities\interfaces\Report;

class NullReport implements Report
{
    private $self;

    public function __construct(array $self) {
        $this->self = $self;
    }

    public function id(): int
    {
        return 0;
    }

    public function printYourself(): array
    {
        return $this->self;
    }

    public function attachToProblem(Problem $problem): bool
    {
        return false;
    }

    public function changeDescription(string $newDescription): bool
    {
        return false;
    }
}