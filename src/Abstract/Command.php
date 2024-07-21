<?php declare(strict_types=1);

namespace Framework\Cli\Abstract;

use InvalidArgumentException;

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
 * @class Framework\Cli\Abstract\Command
 * @package Framework\Cli\Abstract
 * @link https://tereta.dev
 * @author Tereta Alexander <tereta.alexander@gmail.com>
 */
abstract class Command
{
    const string SYMBOL_COLOR_RED = "\033[0;31m";
    const string SYMBOL_COLOR_GREEN = "\033[0;32m";
    const string SYMBOL_COLOR_YELLOW = "\033[0;33m";
    const string SYMBOL_COLOR_BLUE = "\033[0;34m";
    const string SYMBOL_COLOR_PURPLE = "\033[0;35m";
    const string SYMBOL_COLOR_CYAN = "\033[0;36m";
    const string SYMBOL_COLOR_WHITE = "\033[0;37m";

    const string SYMBOL_COLOR_BRIGHT_RED = "\033[1;31m";
    const string SYMBOL_COLOR_BRIGHT_GREEN = "\033[1;32m";
    const string SYMBOL_COLOR_BRIGHT_YELLOW = "\033[1;33m";
    const string SYMBOL_COLOR_BRIGHT_BLUE = "\033[1;34m";
    const string SYMBOL_COLOR_BRIGHT_PURPLE = "\033[1;35m";
    const string SYMBOL_COLOR_BRIGHT_CYAN = "\033[1;36m";
    const string SYMBOL_COLOR_BRIGHT_WHITE = "\033[1;37m";

    const string SYMBOL_BG_COLOR_RED = "\033[41m";
    const string SYMBOL_BG_COLOR_GREEN = "\033[42m";
    const string SYMBOL_BG_COLOR_YELLOW = "\033[43m";
    const string SYMBOL_BG_COLOR_BLUE = "\033[44m";
    const string SYMBOL_BG_COLOR_PURPLE = "\033[45m";
    const string SYMBOL_BG_COLOR_CYAN = "\033[46m";
    const string SYMBOL_BG_COLOR_WHITE = "\033[47m";

    const string SYMBOL_BG_COLOR_BRIGHT_RED = "\033[101m";
    const string SYMBOL_BG_COLOR_BRIGHT_GREEN = "\033[102m";
    const string SYMBOL_BG_COLOR_BRIGHT_YELLOW = "\033[103m";
    const string SYMBOL_BG_COLOR_BRIGHT_BLUE = "\033[104m";
    const string SYMBOL_BG_COLOR_BRIGHT_PURPLE = "\033[105m";
    const string SYMBOL_BG_COLOR_BRIGHT_CYAN = "\033[106m";
    const string SYMBOL_BG_COLOR_BRIGHT_WHITE = "\033[107m";

    const string SYMBOL_STYLE_BOLD = "\033[1m";
    const string SYMBOL_STYLE_UNDERLINE = "\033[4m";
    const string SYMBOL_STYLE_RESET = "\033[0m";

    const string SYMBOL_COLOR_RESET = "\033[0m";

    /**
     * @var array $arguments
     */
    protected array $arguments = [];

    /**
     * @param array $argumentValues
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
}