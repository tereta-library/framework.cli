<?php declare(strict_types=1);

namespace Framework\Cli\Abstract;

use InvalidArgumentException;

/**
 * Framework\Cli\Abstract\Command
 */
abstract class Command
{
    /**
     * @var array $arguments
     */
    protected array $arguments = [];

    /**
     * @param array $argumentValues
     * @param string|null $script
     */
    public function __construct(
        private readonly array $argumentValues
    ) {
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getArgument(string $name): mixed {
        $arguments = array_flip($this->arguments);
        !isset($arguments[$name]) && throw new InvalidArgumentException("Argument $name not found");
        if (!isset($this->argumentValues[$arguments[$name]])) return null;

        return $this->argumentValues[$arguments[$name]];
    }

    /**
     * @return array
     */
    protected function getArguments(): array {
        return $this->argumentValues;
    }

    /**
     * @return string
     */
    public static function getDescription(): string {
        return "";
    }

    /**
     * @return void
     */
    abstract public function execute(): void;
}