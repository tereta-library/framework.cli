<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use Framework\Cli\Abstract\Command as AbstractCommand;
use ReflectionClass;

/**
 * Framework\Cli\Router
 */
class Router {
    /**
     * @var array
     */
    private array $map = [
        'help' => 'Framework\Cli\Help'
    ];

    /**
     * @param array $map
     */
    public function __construct(array $map) {
        $this->map = array_merge($this->map, $map);
    }

    /**
     * @param array $arguments
     * @return void
     * @throws Exception
     */
    public function run(array $arguments): void {
        array_shift($arguments);
        $command = array_shift($arguments);

        !$command && $command = 'help';
        !isset($this->map[$command]) && throw new Exception('Command not found');

        $reflectionClass = new ReflectionClass($this->map[$command]);
        !$reflectionClass->isSubclassOf(AbstractCommand::class) && throw new Exception(
            "The command should be extended from " . AbstractCommand::class . " class."
        );

        switch ($command) {
            case('help'):
                $instance = $reflectionClass->newInstanceArgs([$arguments, $this->map]);
                break;
            default:
                $instance = $reflectionClass->newInstanceArgs([$arguments]);
        }

        $instance->execute();
    }
}