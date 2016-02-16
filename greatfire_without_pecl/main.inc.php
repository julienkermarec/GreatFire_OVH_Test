<?php
require 'Conf.inc.php';
require 'filters/DomUrlFilters.inc.php';
require 'filters/TextExternalUrlFilters.inc.php';
require 'filters/TextInternalUrlFilters.inc.php';
require 'Log.inc.php';
require 'ProxyHttpRequest.inc.php';
require 'ProxyHttpResponse.inc.php';
require 'httpClientRequest.php';
require 'simple_html_dom.php';
require 'url.inc.php';
require 'rwb/RedirectWhenBlockedFull.inc.php';
require 'conf-local.inc.php';

function getCacheControlHeader($max_age, $stale_while_revalidate, $stale_if_error)
{
    return 'max-age=' . $max_age . ', stale-while-revalidate=' .
         $stale_while_revalidate . ', stale-if-error=' . $stale_if_error;
}

function getDownstreamOrigin()
{
    static $downstream_origin_verified;
    if (! isset($downstream_origin_verified)) {
        $downstream_origin_verified = NULL;
        
        if (isset($_SERVER['HTTP_ORIGIN'])) {
            $downstream_origin = $_SERVER['HTTP_ORIGIN'];
        } elseif (isset($_SERVER['HTTP_REFERER'])) {
            $downstream_origin = http_build_scheme_host(
                $_SERVER['HTTP_REFERER']);
        }
        
        if (isset($downstream_origin)) {
            foreach (RedirectWhenBlockedFull::getAltBaseUrls() as $alt_url_base) {
                if ($downstream_origin == http_build_scheme_host($alt_url_base)) {
                    $downstream_origin_verified = $downstream_origin;
                    break;
                }
            }
        }
    }
    
    return $downstream_origin_verified;
}

RedirectWhenBlockedFull::addUrlsFromConfDir();

TextExternalUrlFilters::addHost(
    Conf::getDefaultUpstreamBaseUrlComponent('host'));

DomUrlFilters::addAttribute('action');
DomUrlFilters::addAttribute('href');
DomUrlFilters::addAttribute('src');