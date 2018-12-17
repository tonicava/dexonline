<?php
/**
 * Output two lists of words associated with some common dictionaries, once with diacritical
 * marks and once without them.
 **/

require_once __DIR__ . '/../phplib/Core.php';

ini_set('memory_limit', '1G');

define('STATIC_SERVER_DIR', '/download/scrabble');
define('DEX09_ID', 27);
define('MDN_ID', 21);

Log::notice('started');

$tempDir = Core::getTempPath();

Log::info('collecting forms');
$forms = Model::factory('InflectedForm')
  ->table_alias('if')
  ->select('if.formNoAccent')
  ->distinct()
  ->join('Inflection', ['if.inflectionId', '=', 'i.id'], 'i')
  ->join('Lexeme', ['if.lexemeId', '=', 'l.id'], 'l')
  ->join('Definition', ['l.formNoAccent', '=', 'd.lexicon'], 'd')
  ->where('i.animate', false)
  ->where_raw('binary if.formNoAccent rlike "^[a-zăâîșț]+$"') // no caps - chemical symbols etc.
  ->where_raw('char_length(if.formNoAccent) between 3 and 7')
  ->where('d.status', Definition::ST_ACTIVE)
  ->where_in('d.sourceId', [ DEX09_ID, MDN_ID ])
  ->where('if.apheresis', false)
  ->where('if.apocope', false)
  ->order_by_asc('if.formNoAccent')
  ->find_many();
$joined = implode("\n", Util::objectProperty($forms, 'formNoAccent'));

$diaFileName = $tempDir.'/game-word-list-dia.txt';
Log::info('writing forms to %s', $diaFileName);
file_put_contents($diaFileName, $joined);

$tmpFileName = $tempDir.'/game-word-list-tmp.txt';
$noDiaFileName = $tempDir.'/game-word-list.txt';
Log::info('writing Latin forms to %s', $noDiaFileName);
$latin = Str::unicodeToLatin($joined);
file_put_contents($tmpFileName, $latin);
exec("sort $tmpFileName | uniq > $noDiaFileName");

Log::info('uploading files to static server');
$f = new FtpUtil();
$f->staticServerPut($diaFileName, 'download/game-word-list-dia.txt');
$f->staticServerPut($noDiaFileName, 'download/game-word-list.txt');

// cleanup
unlink($diaFileName);
unlink($tmpFileName);
unlink($noDiaFileName);

Log::notice('finished');
