<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use Framework\Helper\PhpDoc;
use ReflectionClass;
use ReflectionException;
use Framework\Cli\Interface\Controller;
use Framework\Cli\Symbol as CliSymbol;

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

        $listing = [];
        foreach ($this->map as $key => $routeItem) {
            $routeItemString = $routeItem;
            $routeItem = explode('->', $routeItem);
            $class = $routeItem[0];
            $method = $routeItem[1];
            $reflectionClass = new ReflectionClass($class);
            !$reflectionClass->implementsInterface(Controller::class) && throw new Exception(
                "The {$routeItemString} command should implement the " . Controller::class . " interface."
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
            $listing[$key] = $description;
        }

        ksort($listing);
        $sort = [[], []];
        foreach ($listing as $key => $description) {
            if (count(explode(":", $key)) == 1) {
                $sort[0][$key] = $description;
                continue;
            }

            $sort[1][$key] = $description;
        }
        ksort($sort);

        $listing = array_merge($sort[0], $sort[1]);
        $explodedHeader = '';

        foreach ($listing as $key => $description) {
            $exploded = explode(":", $key);
            if (count($exploded) == 1 && $explodedHeader != 'general') {
                $explodedHeader = 'general';
                echo CliSymbol::COLOR_BRIGHT_GREEN . "General\n" . CliSymbol::COLOR_RESET;
            }
            if (count($exploded) > 1 && $explodedHeader != $exploded[0]) {
                $explodedHeader = $exploded[0];
                echo CliSymbol::COLOR_BRIGHT_GREEN . "\n" . ucfirst($explodedHeader) . "\n" . CliSymbol::COLOR_RESET;
            }

            echo CliSymbol::COLOR_GREEN . "  {$key}:" . CliSymbol::COLOR_RESET . " {$description}\n";
        }
    }
}
