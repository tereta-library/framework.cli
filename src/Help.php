<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use Framework\Helper\PhpDoc;
use ReflectionClass;
use ReflectionException;
use Framework\Cli\Interface\Controller;

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
 * @since 2020-2024
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author Tereta Alexander <tereta.alexander@gmail.com>
 * @copyright 2020-2024 Tereta Alexander
 */
class Help implements Controller
{
    /**
     * @param $map
     */
    public function __construct(
        private array $map = []
    ) {
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
            !$reflectionClass->implementsInterface(Controller::class) && throw new Exception(
                "The command should implement the " . Controller::class . " interface."
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
