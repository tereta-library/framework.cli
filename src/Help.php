<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use Framework\Cli\Abstract\Command as AbstractCommand;
use Framework\Helper\PhpDoc;
use ReflectionClass;
use ReflectionException;

/**
 * ···························WWW.TERETA.DEV······························
 * ·······································································
 * : _____                        _                     _                :
 * :|_   _|   ___   _ __    ___  | |_    __ _        __| |   ___  __   __:
 * :  | |    / _ \ | '__|  / _ \ | __|  / _` |      / _` |  / _ \ \ \ / /:
 * :  | |   |  __/ | |    |  __/ | |_  | (_| |  _  | (_| | |  __/  \ V / :
 * :  |_|    \___| |_|     \___|  \__|  \__,_| (_)  \__,_|  \___|   \_/  :
 * ·······································································
 * ·······································································
 *
 * @class Framework\Cli\Help
 * @package Framework\Cli
 * @link https://tereta.dev
 * @author Tereta Alexander <tereta.alexander@gmail.com>
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

    /**
     * @cli help
     * @cliDescription Show available commands and their descriptions
     * @return void
     * @throws ReflectionException
     */
    public function execute(): void
    {
        echo "Usage: php cli.php [command] [arguments]\n";
        echo "Available commands:\n";

        $maxKeyLength = 0;
        foreach ($this->map as $key => $class) {
            if (strlen($key) > $maxKeyLength) {
                $maxKeyLength = strlen($key);
            }
        }

        foreach ($this->map as $key => $routeItem) {
            $routeItem = explode('->', $routeItem);
            $class = $routeItem[0];
            $method = $routeItem[1];
            $reflectionClass = new ReflectionClass($class);
            !$reflectionClass->isSubclassOf(AbstractCommand::class) && throw new Exception(
                "The command should be extended from " . AbstractCommand::class . " class."
            );

            $variables = PhpDoc::getMethodVariables($class, $method);
            $description = $variables['cliDescription'] ?? '';
            $description = explode("\n", $description);
            foreach ($description as $descriptionKey => $line) {
                $description[$descriptionKey] = str_repeat(" ", $maxKeyLength + 5) . trim($line);
            }

            $description[0] = trim($description[0]);
            $description = implode("\n", $description);

            $key = str_pad($key, $maxKeyLength + 1, ' ');
            echo "  \033[32m{$key}:\033[0m {$description}\n";
        }
    }
}
