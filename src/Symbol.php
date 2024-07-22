<?php declare(strict_types=1);

namespace Framework\Cli;

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
 * @interface Framework\Cli\Symbol
 * @package Framework\Cli
 * @link https://tereta.dev
 * @author Tereta Alexander <tereta.alexander@gmail.com>
 */
abstract class Symbol
{
    const string COLOR_RED = "\033[0;31m";
    const string COLOR_GREEN = "\033[0;32m";
    const string COLOR_YELLOW = "\033[0;33m";
    const string COLOR_BLUE = "\033[0;34m";
    const string COLOR_PURPLE = "\033[0;35m";
    const string COLOR_CYAN = "\033[0;36m";
    const string COLOR_WHITE = "\033[0;37m";

    const string COLOR_BRIGHT_RED = "\033[1;31m";
    const string COLOR_BRIGHT_GREEN = "\033[1;32m";
    const string COLOR_BRIGHT_YELLOW = "\033[1;33m";
    const string COLOR_BRIGHT_BLUE = "\033[1;34m";
    const string COLOR_BRIGHT_PURPLE = "\033[1;35m";
    const string COLOR_BRIGHT_CYAN = "\033[1;36m";
    const string COLOR_BRIGHT_WHITE = "\033[1;37m";

    const string BG_COLOR_RED = "\033[41m";
    const string BG_COLOR_GREEN = "\033[42m";
    const string BG_COLOR_YELLOW = "\033[43m";
    const string BG_COLOR_BLUE = "\033[44m";
    const string BG_COLOR_PURPLE = "\033[45m";
    const string BG_COLOR_CYAN = "\033[46m";
    const string BG_COLOR_WHITE = "\033[47m";

    const string BG_COLOR_BRIGHT_RED = "\033[101m";
    const string BG_COLOR_BRIGHT_GREEN = "\033[102m";
    const string BG_COLOR_BRIGHT_YELLOW = "\033[103m";
    const string BG_COLOR_BRIGHT_BLUE = "\033[104m";
    const string BG_COLOR_BRIGHT_PURPLE = "\033[105m";
    const string BG_COLOR_BRIGHT_CYAN = "\033[106m";
    const string BG_COLOR_BRIGHT_WHITE = "\033[107m";

    const string STYLE_BOLD = "\033[1m";
    const string STYLE_UNDERLINE = "\033[4m";
    const string STYLE_RESET = "\033[0m";

    const string COLOR_RESET = "\033[0m";

    const string NEW_LINE = "\n";
    const string UP_LINE = "\033[1A";
    const string CLEAR_LINE = "\033[K";
}