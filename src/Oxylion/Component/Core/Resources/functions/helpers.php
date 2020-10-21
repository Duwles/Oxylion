<?php declare(strict_types=1);
/*
 * This file is part of the Atlax package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
if (!function_exists('app')) {
    function app() {
        return \Atlax\Component\Application\Application::make();
    }
}

if (!function_exists("config")) {
    function config() {
        print "hello";
    }
}

if (!function_exists('env')) {
    /**
     * Gets the value of an environment variable. Supports boolean, empty and null.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     *
     * @throws InvalidArgumentException
     * @throws ErrorException
     */
    function env(string $key, $default = null) {
        $value = getenv($key);
        if (isset($value)) {
            if (!empty($value)) {
                return $value;
            } elseif (empty($value)) {
                if ($default !== null) return $default;
                else throw new InvalidArgumentException("Invalid Argument \$default set in function env()");
            } else {
                throw new ErrorException("Undefined error in function env();");
            }
        } else {
            throw new ErrorException("function env(); send Undefined fatal error.");
        }
    }
}

if (!function_exists('escape')) {
    /**
     * Escapes all the quotes/special characters
     *
     * @param string $value String to clean all the quotes, break lines and special chars
     *
     * @return string
     */
    function escape(string $value): string
    {
        return str_replace(array("\\", "\0", "\n", "\r", "\x1a", "'", '"'), array("\\\\", "\\0", "\\n", "\\r", "\Z", "\'", '\"'), $value);
    }
}

if (!function_exists("generateSimpleToken")) {
    /**
     * Generates an simple random token with an specified length
     *
     * @param int $length length of the token to generate
     *
     * @return string
     * @throws Exception
     */
    function generateSimpleToken($length = 9): string
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet);

        for ($i = 0; $i < $length; $i++) {
            $token .= $codeAlphabet[random_int(0, $max - 1)];
        }

        return $token;
    }
}

if (!function_exists('generateCSRFToken')) {
    /**
     * Generates a random token for use in the CSRF token (this is used to check the POST forms integrity)
     *
     * @return string
     * @throws Exception
     */
    function generateCSRFToken(): string
    {
        return bin2hex(random_bytes(32));
    }
}

if (!function_exists('checkPostCSRFToken')) {
    /**
     * Checks wether the CSRF token used in the POST form, matches with the CSRF token stored in the session
     *
     * @return void
     * @throws Exception
     */
    function checkPostCSRFToken()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            if (isset($_POST["csrf_token"])) {
                if (!hash_equals($_SESSION["csrf_token"], $_POST["csrf_token"])) {
                    throw new Exception("The CSRF token doesn't match!");
                }
            } else {
                throw new Exception("The CSRF token was not defined");
            }
        }
    }
}

if (!function_exists('ipAddress')) {
    /**
     * Get client's IP address - if proxy lets get the REAL IP address
     *
     * @return string
     */
    function ipAddress(): string
    {
        if (!empty($_SERVER['REMOTE_ADDR']) and !empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = '0.0.0.0';
        }
        return $ip;
    }
}

if (!function_exists('preventXSS')) {
    /**
     * Deletes special characters
     *
     * @param string $value text to clean special characters
     *
     * @return string
     */
    function preventXSS(string $value): string
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('array_walk_recursive_referential')) {
    /**
     * This function acts exactly like array_walk_recursive, except that it pretends that the function
     * its calling replaces the value with its result.
     *
     * @param array     $array The first value of the array will be passed into $function as the primary argument
     * @param callable  $function The function to be called on each element in the array, recursively
     * @param array     $parameters An optional array of the additional parameters to be appended to the function
     *
     * @example Example usage to alter $array to get the second, third and fourth character from each value
     *     array_walk_recursive_referential($array, "substr", array("1","3"));
     */
    function array_walk_recursive_referential(array &$array, callable $function, $parameters = array())
    {
        $reference_function = function (&$value, $key, $userdata) {
            $parameters = array_merge(array($value), $userdata[1]);
            $value = call_user_func_array($userdata[0], $parameters);
        };
        array_walk_recursive($array, $reference_function, array($function, $parameters));
    }
}