<?php
namespace Dok123\FileTypeDetector;

class TerminalInfo {
    const WIDTH = 1;
    const HEIGHT = 2;
    public static function isInteractive() {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            // windows has no test for that
            return true;
        } else {
            if (function_exists('posix_isatty'))
                return posix_isatty(STDOUT);

            // test with fstat()
            $mode = fstat(STDIN);
            return ($mode['mode'] & 0170000) == 0020000; // charater flag (input iteractive)
        }
    }

    public static function getWidth() {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            return self::getWindowsTerminalSize(self::WIDTH);
        } else {
            return self::getUnixTerminalSize(self::WIDTH);
        }
    }

    public static function getHeight() {
        if (strncasecmp(PHP_OS, 'win', 3) === 0) {
            return self::getWindowsTerminalSize(self::HEIGHT);
        } else {
            return self::getUnixTerminalSize(self::HEIGHT);
        }
    }

    protected static function getWindowsTerminalSize($param) {
        $output = explode("\n", shell_exec('mode'));
        $line = explode(':', trim($param == self::WIDTH ? $output[4] : $output[3]));
        return trim($line[1]);
    }

    protected static function getUnixTerminalSize($param) {
        return trim(shell_exec('tput '.($param == self::WIDTH ? 'cols' : 'linus')));
    }
}
