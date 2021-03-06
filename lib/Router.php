<?php

/**
 * Two-way routing:
 * (1) Resolve URLs like path1/path2/arg1/arg2 to PHP files + GET arguments;
 * (2) Resolve links like path/to/file to localized URLs.
 **/

class Router {

  // Reverse routes definitions, mapping file names to localized URLs. We
  // prefer this format in order to group all information about one file. We
  // compute the forward routes upon initialization. Files have an implicit
  // .php extension.
  const ROUTES = [
    // accuracy
    'accuracy/projects' => [
      'en_US.utf8' => 'accuracy-projects',
      'ro_RO.utf8' => 'proiecte-acuratete',
    ],
    'accuracy/eval' => [
      'en_US.utf8' => 'accuracy-eval',
      'ro_RO.utf8' => 'evaluare-acuratete',
    ],

    // articles
    'article/list' => [
      'en_US.utf8' => 'articles',
      'ro_RO.utf8' => 'articole',
    ],
    'article/rss' => [
      'en_US.utf8' => 'rss-articles',
      'ro_RO.utf8' => 'rss-articole',
    ],
    'article/view' => [
      'en_US.utf8' => 'article',
      'ro_RO.utf8' => 'articol',
    ],

    // auth
    'auth/login' => [
      'en_US.utf8' => 'login',
      'ro_RO.utf8' => 'autentificare',
    ],
    'auth/logout' => [
      'en_US.utf8' => 'logout',
      'ro_RO.utf8' => 'deconectare',
    ],
    'auth/lostPassword' => [
      'en_US.utf8' => 'lost-password',
      'ro_RO.utf8' => 'parola-uitata',
    ],
    'auth/passwordRecovery' => [
      'en_US.utf8' => 'password-recovery',
      'ro_RO.utf8' => 'recuperare-parola',
    ],
    'auth/register' => [
      'en_US.utf8' => 'register',
      'ro_RO.utf8' => 'inregistrare',
    ],

    // WotD artists
    'artist/assign' => [
      'en_US.utf8' => 'assign-artists',
      'ro_RO.utf8' => 'alocare-autori',
    ],
    'artist/edit' => [
      'en_US.utf8' => 'edit-artist',
      'ro_RO.utf8' => 'editare-autor',
    ],
    'artist/list' => [
      'en_US.utf8' => 'artists',
      'ro_RO.utf8' => 'autori-imagini',
    ],

    // donations
    'donation/donate' => [
      'en_US.utf8' => 'donate',
      'ro_RO.utf8' => 'doneaza',
    ],

    'donation/donateEP' => [
      'en_US.utf8' => 'donate-ep',
      'ro_RO.utf8' => 'doneaza-ep',
    ],

    'donation/process' => [
      'en_US.utf8' => 'process-donations',
      'ro_RO.utf8' => 'proceseaza-donatii',
    ],

    // trees
    'entry/edit' => [
      'en_US.utf8' => 'edit-entry',
      'ro_RO.utf8' => 'editare-intrare',
    ],

    // games
    'games/hangman' => [
      'en_US.utf8' => 'hangman',
      'ro_RO.utf8' => 'spanzuratoarea',
    ],
    'games/mill' => [
      'en_US.utf8' => 'mill',
      'ro_RO.utf8' => 'moara',
    ],
    'games/scrabble' => [
      'en_US.utf8' => 'scrabble',
      'ro_RO.utf8' => 'scrabble',
    ],
    'games/scrabbleLocDifferences' => [
      'en_US.utf8' => 'scrabble-loc-differences',
      'ro_RO.utf8' => 'scrabble-diferente-loc',
    ],
    'games/scramble' => [
      'en_US.utf8' => 'scramble',
      'ro_RO.utf8' => 'omleta',
    ],

    // inflections
    'inflection/list' => [
      'en_US.utf8' => 'inflections',
      'ro_RO.utf8' => 'flexiuni',
    ],

    // sources
    'source/edit' => [
      'en_US.utf8' => 'edit-source',
      'ro_RO.utf8' => 'editare-sursa',
    ],
    'source/list' => [
      'en_US.utf8' => 'sources',
      'ro_RO.utf8' => 'surse',
    ],

    // tags
    'tag/definitionVersion' => [
      'en_US.utf8' => 'definition-version-tags',
      'ro_RO.utf8' => 'etichete-istorie',
    ],
    'tag/edit' => [
      'en_US.utf8' => 'edit-tag',
      'ro_RO.utf8' => 'editare-eticheta',
    ],
    'tag/list' => [
      'en_US.utf8' => 'tags',
      'ro_RO.utf8' => 'etichete',
    ],

    // trees
    'tree/edit' => [
      'en_US.utf8' => 'edit-tree',
      'ro_RO.utf8' => 'editare-arbore',
    ],

    // visuals
    'visual/elfinder' => [ 'en_US.utf8' => 'visual-elfinder' ],
    'visual/list' => [ 'en_US.utf8' => 'visuals' ],
    'visual/tagger' => [ 'en_US.utf8' => 'visual-tagger' ],

    // word of the day
    'wotd/add' => [ 'en_US.utf8' => 'wotd-add' ],
    'wotd/archive' => [
      'en_US.utf8' => 'word-of-the-day-archive',
      'ro_RO.utf8' => 'arhiva-cuvantul-zilei',
    ],
    'wotd/assistant' => [
      'en_US.utf8' => 'wotd-assistant',
      'ro_RO.utf8' => 'asistent-cz',
    ],
    'wotd/elfinder' => [ 'en_US.utf8' => 'wotd-elfinder' ],
    'wotd/images' => [
      'en_US.utf8' => 'wotd-images',
      'ro_RO.utf8' => 'imagini-cz',
    ],
    'wotd/rss' => [
      'en_US.utf8' => 'rss-word-of-the-day',
      'ro_RO.utf8' => 'rss-cuvantul-zilei',
    ],
    'wotd/table' => [
      'en_US.utf8' => 'wotd-table',
      'ro_RO.utf8' => 'tabel-cz',
    ],
    'wotd/view' => [
      'en_US.utf8' => 'word-of-the-day',
      'ro_RO.utf8' => 'cuvantul-zilei',
    ],

    // word of the month
    'wotm/view' => [
      'en_US.utf8' => 'word-of-the-month',
      'ro_RO.utf8' => 'cuvantul-lunii',
    ],
  ];

  // file => list of parameters expected in the URL (none by default)
  const PARAMS = [
    'article/view' => [ 'title' ],
    'wotd/archive' => [ 'year', 'month' ],
    'wotd/view' => [ 'year', 'month', 'day' ],
    'wotm/view' => [ 'year', 'month' ],
  ];

  private static $fwdRoutes = [];
  private static $relAlternate = [];

  static function init() {
    // compute the forward routes, mapping localized URLs to PHP files
    foreach (self::ROUTES as $file => $locales) {
      foreach ($locales as $url) {
        self::$fwdRoutes[$url] = $file;
      }
    }
  }

  // Executes the corresponding PHP file for this request, then exits.
  // Returns null on routing errors.
  static function route($uri) {
    // strip the GET parameters
    $path = parse_url($uri, PHP_URL_PATH);

    $parts = explode('/', $path);
    $route = array_shift($parts);

    // the route may contain slashes, so try increasingly long segments
    while (!isset(self::$fwdRoutes[$route]) && !empty($parts)) {
      $route .= '/' . array_shift($parts);
    }

    if (!isset(self::$fwdRoutes[$route])) {
      Log::debug('no route found for %s', $path);
      return null;
    }

    // get the PHP file
    $rec = self::$fwdRoutes[$route];
    $file = $rec . '.php';
    Log::debug('routing %s to %s', $path, $file);

    // save any alternate versions in case we need to print them in header tags
    self::setRelAlternate($route, $uri);

    // set additional params if the file expects them and the URL has them
    $params = self::PARAMS[$rec] ?? [];
    for ($i = 0; $i < min(count($params), count($parts)); $i++) {
      $_REQUEST[$params[$i]] = urldecode($parts[$i]);
    }

    require_once $file;
    exit;
  }

  // Returns a human-readable URL for this file.
  static function link($file, $absolute = false) {
    $routes = self::ROUTES[$file];
    $rel = $routes[LocaleUtil::getCurrent()]     // current locale
      ?? $routes[Config::DEFAULT_ROUTING_LOCALE] // or default locale
      ?? '';                                     // or home page

    $url = ($absolute ? Config::URL_HOST : '') . Config::URL_PREFIX . $rel;
    return $url;
  }

  // Collect URLs for localized versions of this page.
  // See https://support.google.com/webmasters/answer/189077
  static function setRelAlternate($route, $uri) {
    $routes = self::ROUTES[self::$fwdRoutes[$route]];

    if (count($routes) > 1) {
      foreach ($routes as $locale => $langRoute) {
        $langCode = explode('_', $locale)[0];
        $langUri = substr_replace($uri, $langRoute, 0, strlen($route));
        $langUrl = Config::URL_HOST . Config::URL_PREFIX . $langUri;
        self::$relAlternate[$langCode] = $langUrl;
      }
    }
  }

  static function getRelAlternate() {
    return self::$relAlternate;
  }

}
