<?php declare(strict_types=1);

namespace Framework\Cli;

use Exception;
use ReflectionClass;
use Framework\Helper\PhpDoc;
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
 * @class Framework\Cli\Router
 * @package Framework\Cli
 * @link https://tereta.dev
 * @author Tereta Alexander <tereta.alexander@gmail.com>
 */
class Router {
    /**
     * @var array
     */
    private array $map = [
        'help' => 'Framework\Cli\Help->execute'
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

        $controllerAction = $this->map[$command];
        $controllerActionExploded = explode('->', $controllerAction);
        $reflectionClass = new ReflectionClass($controllerActionExploded[0]);
        !$reflectionClass->implementsInterface(Controller::class) && throw new Exception(
            "The {$controllerAction} command should implement the " . Controller::class . " interface."
        );

        switch ($command) {
            case('help'):
                $instance = $reflectionClass->newInstanceArgs([$this->map]);
                break;
            default:
                $instance = $reflectionClass->newInstance();
        }

        $reflectionMethod = $reflectionClass->getMethod($controllerActionExploded[1]);
        $requiredParameters = $reflectionMethod->getNumberOfRequiredParameters();

        if ($requiredParameters <= count($arguments)) {
            $reflectionMethod->invokeArgs($instance, $arguments);
            return;
        }

        $phpDoc = PhpDoc::getMethodVariables($controllerActionExploded[0], $controllerActionExploded[1]);

        $params = is_array($phpDoc['param']) ? $phpDoc['param'] : [$phpDoc['param']];
        $paramDescription = [];
        foreach ($params as $paramItem) {
            if (!preg_match('/^\w+\s+\$(\w*)\s+(.*)$/Usi', $paramItem, $matches)) continue;
            if (!isset($matches[1]) || !$matches[1]) continue;
            $paramDescription[$matches[1]] = isset($matches[2]) ? $matches[2] : '';
        }

        $methodParameters = [];
        foreach ($reflectionMethod->getParameters() as $reflectionAttribute) {
            $description = $paramDescription[$reflectionAttribute->getName()] ?? '';
            $methodParameters[] = str_repeat(" ", 4) . $reflectionAttribute->getName() . ' - ' . $description;
        }
        throw new Exception("Not enough arguments, required: \n" . implode("\n", $methodParameters));
    }
}