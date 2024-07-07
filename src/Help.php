<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use Framework\Cli\Abstract\Command as AbstractCommand;
use ReflectionClass;

/**
 * Class Help
 */
class Help extends AbstractCommand
{
    /**
     * @param array $argumentValues
     * @param $map
     */
    public function __construct(
        array $argumentValues,
        private $map = []
    ) {
        parent::__construct($argumentValues);
    }

    public static function getDescription(): string {
        return "The command will show current registered command listing";
    }

    /**
     * @return string
     */
    public function execute(): void
    {
        echo "Usage: php cli.php [command] [arguments]\n";
        echo "Available commands:\n";
        foreach ($this->map as $key => $class) {
            $reflectionClass = new ReflectionClass($class);
            !$reflectionClass->isSubclassOf(AbstractCommand::class) && throw new Exception(
                "The command should be extended from " . AbstractCommand::class . " class."
            );
            $reflectionMethod = $reflectionClass->getMethod('getDescription');
            $description = $reflectionMethod->invoke(null);
            echo "  {$key}: {$description}\n";
        }
    }
}
