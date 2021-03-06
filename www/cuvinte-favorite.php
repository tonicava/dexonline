<?php
require_once '../lib/Core.php';

$user = User::getActive();
if (!$user) {
  Util::redirectToRoute('auth/login');
}
$definitions = Model::factory('Definition')
  ->table_alias('d')
  ->select('d.*')
  ->join('UserWordBookmark', ['d.id', '=', 'uwb.definitionId'], 'uwb')
  ->where('uwb.userId', $user->id)
  ->order_by_asc('d.lexicon')
  ->find_many();
$results = SearchResult::mapDefinitionArray($definitions);

Smart::assign('results', $results);
Smart::display('cuvinte-favorite.tpl');
