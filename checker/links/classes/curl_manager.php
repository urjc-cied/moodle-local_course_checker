<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

namespace coursechecker_links;

use local_course_checker\config;
use local_course_checker\db\model\check;
use local_course_checker\translation_manager;

/**
 * Fetch an url and return true if the code is between 200 and 400.
 *
 * @package    coursechecker_links
 * @copyright  2025 Simon Gisler, Fernfachhochschule Schweiz (FFHS) <simon.gisler@ffhs.ch>
 * @copyright  2025 Stefan Dani, Fernfachhochschule Schweiz (FFHS) <stefan.dani@ffhs.ch>
 * @copyright  based on work by 2019 Liip SA <elearning@liip.ch>
 * @copyright  based on work by 2020 Christoph Karlen, Fernfachhochschule Schweiz (FFHS) <christoph.karlen@ffhs.ch>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class curl_manager {
    /** @var string Configuration path for the URL request timeout. */
    const TIMEOUT_SETTING = 'coursechecker_links/timeout';
    /** @var int Default value for total CURL request timeout in seconds. */
    const TIMEOUT_DEFAULT = 13;
    /** @var string Configuration path for the CURL connection timeout. */
    const CONNECT_TIMEOUT_SETTING = 'coursechecker_links/connect_timeout';
    /** @var int Default value for CURL connection timeout in seconds. */
    const CONNECT_TIMEOUT_DEFAULT = 5;
    /** @var string Configuration path for the URL whitelist setting. */
    const URL_WHITELIST_SETTING = 'coursechecker_links/url_whitelist';
    /** @var string Default value for URL whitelist (newline-separated). */
    const URL_WHITELIST_DEFAULT = '';
    /** @var string Configuration path for the domain whitelist setting. */
    const DOMAIN_WHITELIST_SETTING = 'coursechecker_links/domain_whitelist';
    /** @var string Default value for domain whitelist */
    const DOMAIN_WHITELIST_DEFAULT = 'www.w3.org';
    /** @var string Configuration path for the CURL user agent string. */
    const USERAGENT_SETTING = 'coursechecker_links/useragent';
    /** @var string Default user agent string for CURL requests. */
    const USERAGENT_DEFAULT = 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/131.0.0.0 Safari/537.36';
    /** @var string Configuration path for the html page regex. */
    public const HTML_ERROR_REGEX_SETTING = 'coursechecker_links/html_error_regex';
    /** @var string Default regex pattern for HTML error pages. */
    public const HTML_ERROR_REGEX_DEFAULT = '/(page not found)/i';
    /** @var string Configuration path for the HTTP codes that are reported as broken links. */
    public const ERROR_CODES_SETTING = 'coursechecker_links/error_codes';
    /** @var string Default HTTP codes that are reported as broken links: the page does not exist or the server fails. */
    public const ERROR_CODES_DEFAULT = '404, 410, 500, 502, 504';
    /** @var string Configuration path for the connection errors that are reported as broken links. */
    public const CURL_ERRORS_SETTING = 'coursechecker_links/curl_errors';
    /** @var string Default connection errors that are reported as broken links: the domain does not exist. */
    public const CURL_ERRORS_DEFAULT = '6';
    /** @var int[] HTTP codes that are reported as broken links. Other errors are warnings, because they are often false. */
    protected array $errorcodes;
    /** @var int[] Connection errors of cURL that are reported as broken links. Others are warnings. */
    protected array $curlerrors;
    /** @var string Configuration path for the number of links requested at the same time. */
    public const CONCURRENCY_SETTING = 'coursechecker_links/concurrency';
    /** @var int Default number of links requested at the same time. */
    public const CONCURRENCY_DEFAULT = 10;
    /** @var int Maximum number of redirects followed for a link. */
    protected const MAX_REDIRECTS = 10;
    /** @var array Results already obtained in this run, indexed by URL: [status, message, customdata]. */
    protected array $results = [];
    /** @var array Links waiting to be requested, in order: [url, parsed url, title, link]. */
    protected array $pending = [];
    /** @var array List of domain names that should be ignored during link checking. */
    protected array $ignoreddomains;
    /** @var array List of full URLs that should be ignored during link checking. */
    protected array $ignoredurls;
    /** @var check Instance of the check model to report results to. */
    protected check $check;
    /** @var string User agent string used for CURL requests. */
    protected string $htmlerrorregex;
    /** @var array Array of CURL options. */
    private array $curloptions;

    /**
     * Constructor. Loads checker configuration and initializes CURL-related settings.
     *
     * @param check $check The check instance to log results into.
     */
    public function __construct(check $check) {
        $whitelist = (string) config::get(self::URL_WHITELIST_SETTING, self::URL_WHITELIST_DEFAULT);
        $this->ignoredurls = array_filter(array_map('trim', explode("\n", $whitelist)));
        $whitelist = (string) config::get(self::DOMAIN_WHITELIST_SETTING, self::DOMAIN_WHITELIST_DEFAULT);
        $this->ignoreddomains = array_filter(array_map('trim', explode("\n", $whitelist)));
        $this->htmlerrorregex = (string) config::get(self::HTML_ERROR_REGEX_SETTING, self::HTML_ERROR_REGEX_DEFAULT);
        $this->errorcodes = self::parse_codes((string) config::get(self::ERROR_CODES_SETTING, self::ERROR_CODES_DEFAULT));
        $this->curlerrors = self::parse_codes((string) config::get(self::CURL_ERRORS_SETTING, self::CURL_ERRORS_DEFAULT));
        $this->curloptions = [
            "CURLOPT_CONNECTTIMEOUT" => (int) config::get(self::CONNECT_TIMEOUT_SETTING, self::CONNECT_TIMEOUT_DEFAULT),
            "CURLOPT_TIMEOUT" => (int) config::get(self::TIMEOUT_SETTING, self::TIMEOUT_DEFAULT),
            "CURLOPT_FOLLOWLOCATION" => 1, // Follow redirects.
            "CURLOPT_MAXREDIRS" => 3, // Maximal number of redirects 301, 302.
            "CURLOPT_USERAGENT" => (string) config::get(self::USERAGENT_SETTING, self::USERAGENT_DEFAULT),
            "CURLOPT_SSL_VERIFYHOST" => 2,
            "CURLOPT_SSL_VERIFYPEER" => 1,
            "CURLOPT_ENCODING" => "gzip",
        ];
        $this->check = $check;
    }

    /**
     * Checks a given URL using CURL and fallback mechanisms.
     * Logs results to the provided check object.
     *
     * @param string $url The URL to check.
     * @param string $title The title of the resource being checked.
     * @param string $link The link to the Moodle resource.
     */
    public function check_url(string $url, string $title, string $link): void {
        $parseurl = parse_url($url);
        if (!array_key_exists("host", $parseurl) || $parseurl["host"] == null) {
            $this->check->add_failed($title, $link, translation_manager::generate("error_undefined", "coursechecker_links"));
            return;
        }
        // Check URL against Moodle HTTP security settings.
        $curlhelper = new \core\files\curl_security_helper();
        if ($curlhelper->url_is_blocked($url)) {
            $this->check->add_info(
                $title,
                $link,
                translation_manager::generate("error_httpsecurity", "coursechecker_links", $url),
                ['external_link' => $url]
            );
            return;
        }
        // Skip whitelisted domain.
        if ($this->is_ignored_domain($parseurl["host"])) {
            $this->check->add_info(
                $title,
                $link,
                translation_manager::generate("domain_is_whitelisted", "coursechecker_links", $parseurl + ["url" => $url]),
                ['external_link' => $url]
            );
            return;
        }
        // Skip whitelisted URL.
        if ($this->is_ignored_url($url)) {
            $this->check->add_info(
                $title,
                $link,
                translation_manager::generate("url_is_whitelisted", "coursechecker_links", $parseurl + ["url" => $url]),
                ['external_link' => $url]
            );
            return;
        }
        // The links are requested later, all together, so that they can be requested in parallel.
        $this->pending[] = [$url, $parseurl, $title, $link];
    }

    /**
     * Request the pending links in parallel and report their results in the order they were found.
     *
     * The same link is often used several times in a course, so it is only requested once.
     */
    public function flush(): void {
        $urls = [];
        foreach ($this->pending as [$url, $parseurl]) {
            if (!isset($this->results[$url])) {
                $urls[$url] = $parseurl;
            }
        }
        $this->results += $this->request_urls($urls);
        foreach ($this->pending as [$url, , $title, $link]) {
            [$status, $message, $customdata] = $this->results[$url];
            $this->check->{'add_' . $status}($title, $link, $message, $customdata);
        }
        $this->pending = [];
    }

    /**
     * Get a list of numeric codes from a text separated by commas, spaces or lines.
     *
     * @param string $text
     * @return int[]
     */
    public static function parse_codes(string $text): array {
        return array_map('intval', preg_split('/[^0-9]+/', $text, -1, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * Request several URLs and get the result of the check of each one.
     *
     * Only the configured HTTP codes and connection errors are failures. Other errors are warnings: many sites answer
     * 401, 403, 429 or 999 to automatic requests, or ask to log in, but work in a browser.
     *
     * @param array $urls Parsed URLs indexed by URL.
     * @return array Results indexed by URL: [status, message, customdata].
     */
    protected function request_urls(array $urls): array {
        $heads = $this->request_all(array_keys($urls), 'head');
        // Some servers reject HEAD requests, so a GET request is tried before reporting an error.
        // A page that works is also downloaded to look for the configured error text.
        $gets = array_filter(array_keys($urls), fn($url) => !$this->is_valid_code($heads[$url]['http_code']) ||
            (!empty($this->htmlerrorregex) && str_contains(strtolower($heads[$url]['content_type']), 'text/html')));
        $gets = $this->request_all(array_values($gets), 'get');

        $results = [];
        foreach ($urls as $url => $parseurl) {
            $results[$url] = $this->get_result($url, $parseurl, $heads[$url], $gets[$url] ?? null);
        }
        return $results;
    }

    /**
     * Get the result of the check of a URL from its requests.
     *
     * @param string $url
     * @param array $parseurl
     * @param array $head Response to the HEAD request.
     * @param array|null $get Response to the GET request, if there was one.
     * @return array [status, message, customdata]
     */
    protected function get_result(string $url, array $parseurl, array $head, ?array $get): array {
        $customdata = ['external_link' => $url];
        $curlinfo = $this->is_valid_code($head['http_code']) || $get === null ? $head : $get;

        $code = $curlinfo['http_code'];
        if ($code === 0) {
            $context = $parseurl + ["url" => $url, "curl_errno" => $curlinfo['errno'], "curl_error" => $curlinfo['error']];
            $failed = in_array($curlinfo['errno'], $this->curlerrors, true);
            $identifier = $failed ? 'error_curl' : 'unverifiable_curl';
            return [$failed ? 'failed' : 'warning', translation_manager::generate($identifier, 'coursechecker_links', $context),
                $customdata];
        }

        $context = $parseurl + ["url" => $url, "http_code" => $code];
        if (!$this->is_valid_code($code)) {
            $failed = in_array($code, $this->errorcodes, true);
            $identifier = $failed ? 'error_code' : 'unverifiable_code';
            return [$failed ? 'failed' : 'warning', translation_manager::generate($identifier, 'coursechecker_links', $context),
                $customdata];
        }

        $customdata['filetype'] = $this->normalize_content_type($curlinfo['content_type']);
        $content = $get['content'] ?? null;
        if (!empty($this->htmlerrorregex) && $content !== null && preg_match($this->htmlerrorregex, $content)) {
            return ['warning', translation_manager::generate('html_error_detected', 'coursechecker_links', $context), $customdata];
        }
        return ['successful', translation_manager::generate('url_code_valid', 'coursechecker_links', $context), $customdata];
    }

    /**
     * Tells if an HTTP code means that the link works.
     *
     * @param int $code
     * @return bool
     */
    protected function is_valid_code(int $code): bool {
        return $code >= 200 && $code < 400;
    }

    /**
     * Send the same kind of request to several URLs in parallel.
     *
     * Redirects are followed here, not by cURL, so that each new address is checked against the Moodle HTTP security
     * settings before it is requested, as the Moodle cURL class does.
     *
     * @param string[] $urls
     * @param string $method head or get.
     * @return array Responses indexed by URL: HTTP code, content type, cURL error and, for a GET request, the content.
     */
    protected function request_all(array $urls, string $method): array {
        $concurrency = max(1, (int) config::get(self::CONCURRENCY_SETTING, self::CONCURRENCY_DEFAULT));
        $security = new \core\files\curl_security_helper();
        $queue = array_map(fn($url) => [$url, $url, 0], $urls);
        $responses = [];
        $active = [];
        $multi = curl_multi_init();
        // Cookies are shared between the requests, because some sites redirect in a loop until a cookie is set.
        $share = curl_share_init();
        curl_share_setopt($share, CURLSHOPT_SHARE, CURL_LOCK_DATA_COOKIE);

        while ($queue || $active) {
            while ($queue && count($active) < $concurrency) {
                [$url, $target, $redirects] = array_shift($queue);
                $handle = $this->create_handle($target, $method);
                curl_setopt($handle, CURLOPT_SHARE, $share);
                curl_multi_add_handle($multi, $handle);
                $active[spl_object_id($handle)] = [$handle, $url, $redirects];
            }
            curl_multi_exec($multi, $running);
            if (curl_multi_select($multi, 1.0) === -1) {
                usleep(100000);
            }
            while ($done = curl_multi_info_read($multi)) {
                $handle = $done['handle'];
                [, $url, $redirects] = $active[spl_object_id($handle)];
                unset($active[spl_object_id($handle)]);
                $info = curl_getinfo($handle);
                $code = (int) ($info['http_code'] ?? 0);
                $next = (string) ($info['redirect_url'] ?? '');
                $errno = (int) $done['result'];
                $response = [
                    'http_code' => $errno ? 0 : $code,
                    'content_type' => is_string($info['content_type'] ?? null) ? $info['content_type'] : '',
                    'errno' => $errno,
                    'error' => $errno ? (curl_error($handle) ?: curl_strerror($errno)) : '',
                    'content' => $method === 'get' && !$errno && $this->is_valid_code($code) ? curl_multi_getcontent($handle) : null,
                ];
                curl_multi_remove_handle($multi, $handle);
                curl_close($handle);

                if (!$errno && $code >= 300 && $code < 400 && $next !== '') {
                    if ($redirects >= self::MAX_REDIRECTS) {
                        $response['http_code'] = 0;
                        $response['errno'] = CURLE_TOO_MANY_REDIRECTS;
                        $response['error'] = curl_strerror(CURLE_TOO_MANY_REDIRECTS);
                    } else if ($security->url_is_blocked($next)) {
                        $response['http_code'] = 0;
                        $response['errno'] = -1;
                        $response['error'] = $security->get_blocked_url_string();
                    } else {
                        $queue[] = [$url, $next, $redirects + 1];
                        continue;
                    }
                }
                $responses[$url] = $response;
            }
        }
        curl_multi_close($multi);
        curl_share_close($share);
        return $responses;
    }

    /**
     * Create a cURL handle for a request, with the settings of this check and the proxy of the site.
     *
     * @param string $url
     * @param string $method head or get.
     * @return \CurlHandle
     */
    protected function create_handle(string $url, string $method): \CurlHandle {
        global $CFG;

        $accept = $method === 'get' ? 'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8' : '*/*';
        $handle = curl_init($url);
        $options = [
            CURLOPT_NOBODY => $method === 'head',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => false,
            CURLOPT_PROTOCOLS => CURLPROTO_HTTP | CURLPROTO_HTTPS,
            CURLOPT_CONNECTTIMEOUT => $this->curloptions['CURLOPT_CONNECTTIMEOUT'],
            CURLOPT_TIMEOUT => $this->curloptions['CURLOPT_TIMEOUT'],
            CURLOPT_USERAGENT => $this->curloptions['CURLOPT_USERAGENT'],
            CURLOPT_SSL_VERIFYHOST => 2,
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_HTTPHEADER => ['Accept: ' . $accept],
            CURLOPT_REFERER => $url,
            CURLOPT_COOKIEFILE => '',
        ];
        if (!empty($CFG->proxyhost) && !is_proxybypass($url)) {
            $options[CURLOPT_PROXY] = $CFG->proxyhost . (empty($CFG->proxyport) ? '' : ':' . $CFG->proxyport);
            if (!empty($CFG->proxyuser)) {
                $options[CURLOPT_PROXYUSERPWD] = $CFG->proxyuser . ':' . ($CFG->proxypassword ?? '');
            }
            if (!empty($CFG->proxytype) && $CFG->proxytype === 'SOCKS5') {
                $options[CURLOPT_PROXYTYPE] = CURLPROXY_SOCKS5;
            }
        }
        curl_setopt_array($handle, $options);
        return $handle;
    }

    /**
     * Tells if a domain should be skipped.
     *
     * @param string $domain
     * @return boolean
     */
    protected function is_ignored_domain(string $domain): bool {
        foreach ($this->ignoreddomains as $entry) {
            $parsed = parse_url($entry, PHP_URL_HOST) ?? $entry;

            // Normalize to lowercase.
            $parsed = strtolower($parsed);
            $domain = strtolower($domain);

            if ($domain === $parsed || str_ends_with($domain, '.' . $parsed)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Tells if a URL should be skipped.
     *
     * @param string $url
     * @return bool
     */
    protected function is_ignored_url(string $url): bool {
        foreach ($this->ignoredurls as $pattern) {
            // Fnmatch erlaubt *, ? und andere Wildcards.
            if (fnmatch($pattern, $url)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Classifies the response content type.
     *
     * @param string $contenttype
     * @return string
     */
    protected function normalize_content_type(string $contenttype): string {
        $contenttype = strtolower(trim($contenttype));

        if ($contenttype === '') {
            return 'unknown';
        }
        if (str_contains($contenttype, 'text/html') || str_contains($contenttype, 'application/xhtml+xml')) {
            return 'html';
        }
        if (str_contains($contenttype, 'application/pdf')) {
            return 'pdf';
        }
        if (str_contains($contenttype, 'application/zip')) {
            return 'zip';
        }
        if (str_starts_with($contenttype, 'image/')) {
            return 'image';
        }

        return 'other';
    }
}
