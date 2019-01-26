<?php

/**
 * Static class that converts internal notations to HTML. Works with any
 * object that has an internalRep field. Collects errors and warnings
 * encountered in the process.
 *
 * Easier to implement as a static class since it is unclear how to
 * instantiate and reuse a converter.
 **/

class HtmlConverter {
  private static $errors = [];
  private static $warnings = [];

  static function convert($obj) {
    if (!$obj) {
      return null;
    }

    $sourceId = $obj->sourceId ?? 0;
    list($html, $footnotes)
      = Str::htmlize($obj->internalRep, $sourceId, self::$errors, self::$warnings);

    if ($obj instanceof Definition) {
      $obj->setFootnotes($footnotes);
      $html = self::highlightRareGlyphs($html, $obj->rareGlyphs);
    }
    return $html;
  }

  // Export errors and warnings as flash messages
  static function exportMessages() {
    FlashMessage::bulkAdd(self::$warnings, 'warning');
    FlashMessage::bulkAdd(self::$errors);
  }

  static function highlightRareGlyphs($s, $rareGlyphs) {
    if (User::can(User::PRIV_ANY)) {
      foreach (Str::unicodeExplode($rareGlyphs) as $glyph) {
        $s = str_replace($glyph,  "<span class=\"rareGlyph\">$glyph</span>", $s);
      }
    }
    return $s;
  }

}
