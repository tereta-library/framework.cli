<?php declare(strict_types=1);

namespace Framework\Cli\Cli;

use Framework\Application\Manager as ApplicationManager;
use Framework\Cli\Interface\Controller;
use Framework\Cli\Symbol;
use Exception;

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
 * @class Framework\Cli\Cli\Make
 * @package Framework\Cli\Cli
 * @link https://tereta.dev
 * @since 2020-2024
 * @license   http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 * @author Tereta Alexander <tereta.alexander@gmail.com>
 * @copyright 2020-2024 Tereta Alexander
 */
class Make implements Controller
{
    /**
     * @var string
     */
    private string $rootDirectory;

    /**
     * @method __construct
     */
    public function __construct()
    {
        $this->rootDirectory = ApplicationManager::getRootDirectory();
    }

    /**
     * @cli make:cli
     * @cliDescription Make CLI class: sample `php cli.php make:cli "Vendor/Module/Cli/Command" "sample:execute" "executeId, filterName, filterValue"`
     * @param string $cliName Full class name like "Vendor/Module/Cli/Name" or "Vendor/Module/Cli/Space/Name"
     * @param string $cliCommand CLI command like "sample:execute" or "sample:group:execute"
     * @param string $functionParameters Function parameters like "executeId, filterName, filterValue"
     * @return void
     * @throws Exception
     */
    public function make(string $cliName, string $cliCommand, string $functionParameters = ''): void
    {
        $fullClassName = ltrim($cliName, '/');
        $fullClassName = ltrim($fullClassName, '\\');
        $fullClassName = str_replace('\\', '/', $fullClassName);
        if (!preg_match('/^([A-Z]{1}[a-z]+)\/([A-Z]{1}[a-z]+)\/Cli(\/[A-Z]{1}[a-z]+)+$/', $fullClassName)) {
            throw new Exception('Invalid CLI class name, should be in the format of "Vendor/Module/Cli/Name" or "Vendor/Module/Cli/Space/Name"');
        }

        if (!preg_match('/^([a-zA-Z0-9]+)(:[a-zA-Z0-9]+)*$/', $cliCommand)) {
            throw new Exception('Invalid CLI command, should be in the format of "sample:execute" or "sample:group:execute"');
        }

        if ($functionParameters && !preg_match('/^([a-zA-Z0-9]+)(,\s*[a-zA-Z0-9]+)*$/', $functionParameters)) {
            throw new Exception('Invalid function parameters, should be in the format of "executeId, filterName, filterValue"');
        }

        $fullClassName = str_replace('/', '\\', $fullClassName);

        $modelFile = "{$this->rootDirectory}/app/module/{$fullClassName}.php";
        $modelFile = str_replace('\\', '/', $modelFile);
        if (is_file($modelFile)) {
            throw new Exception("The {$modelFile} file already exists");
        }

        $dirName = dirname($modelFile);
        if (!is_dir($dirName)) {
            mkdir($dirName, 0755, true);
        }

        $cliCommandExploded = explode(":", $cliCommand);
        $functionName = array_pop($cliCommandExploded);

        $parametersString = '';
        $parametersCommentArray = [];
        $parameters = $functionParameters ? explode(',', $functionParameters) : [];
        foreach ($parameters as $parameter) {
            $parameter = trim($parameter);
            $parametersString .= ($parametersString ? ', ' : '') . 'string $' . $parameter;
            $parametersCommentArray[] = " * @param string \${$parameter} Parameter of CLI command\n";
        }
        if ($functionParameters) {
            $parametersString = 'string $' . implode(', string $', array_map("trim", $parameters));
        }
        $classExploded = explode('\\', $fullClassName);
        $cliName = array_pop($classExploded);
        $namespace = implode('\\', $classExploded);
        $dateTime = date('Y-m-d H:i:s');
        $content = "<?php declare(strict_types=1);\n\n" .
            "namespace {$namespace};\n\n" .
            "use Framework\Cli\Interface\Controller;\n" .
            "use Framework\Cli\Symbol;\n" .
            "use Exception;\n" .
            "\n" .
            "/**\n" .
            " * Generated by www.Tereta.dev on {$dateTime}\n" .
            " *\n" .
            " * @class {$fullClassName}\n" .
            " * @package {$namespace}\n" .
            " */\n" .
            "class {$cliName} implements Controller\n" .
            "{\n" .
            "    /**\n" .
            "     * @cli {$cliCommand}\n" .
            "     * @cliDescription Sample CLI command\n" .
            ($parametersCommentArray ? "    " : '') . implode('    ', $parametersCommentArray) .
            "     * @return void\n" .
            "     * @throws Exception\n" .
            "     */\n" .
            "    public function {$functionName}({$parametersString}): void\n" .
            "    {\n" .
            "        /* @todo Change the cli command for your needs */\n" .
            "        \n" .
            "        echo Symbol::COLOR_GREEN . \"The sample script successfully performed\\n\" . Symbol::COLOR_RESET;\n" .
            "    }\n" .
            "}";

        file_put_contents($modelFile, $content);

        echo Symbol::COLOR_GREEN . "The \"{$fullClassName}\" model successfully created at the {$modelFile} file\n" . Symbol::COLOR_RESET;
    }
}