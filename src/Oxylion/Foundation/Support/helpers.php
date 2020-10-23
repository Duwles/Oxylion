<?php declare(strict_types=1);
/*
 * This file is part of the Oxylion package.
 *
 * (c) Bartosz Zwski <duwless@outlook.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Oxylion\Foundation\Support { }

namespace
{
    use Oxylion\Component\Application\Application;

    if (!function_exists('app')) {
        /**
         * @return Application
         */
        function app(): Application {
            return Application::make();
        }
    }

    if (!function_exists('config')) {

        function config($id = null, $default = null) {

        }
    }

    if (!function_exists('env')) {

        function env($id = null, $default = null) {
            $value = getenv($id);
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
}