<?php

class Lock {
  const LOCK_PREFIX = '/lock_';

  const FULL_TEXT_INDEX = 'full_text_index';

  static function exists($name) {
    return file_exists(Config::TEMP_DIR . self::LOCK_PREFIX . $name);
  }

  // returns false if the lock already exists
  static function acquire($name) {
    if (self::exists($name)) {
      return false;
    }
    touch(Config::TEMP_DIR . self::LOCK_PREFIX . $name);
    return true;
  }

  // returns false if the lock does not exist
  static function release($name) {
    if (!self::exists($name)) {
      return false;
    }
    unlink(Config::TEMP_DIR . self::LOCK_PREFIX . $name);
    return true;
  }
}
