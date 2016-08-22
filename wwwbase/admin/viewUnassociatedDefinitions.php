<?php

require_once("../../phplib/util.php");
util_assertModerator(PRIV_EDIT);
util_assertNotMirror();
RecentLink::createOrUpdate('Definiții neasociate');

$defs = Model::factory('Definition')
      ->table_alias('d')
      ->select('d.*')
      ->left_outer_join('EntryDefinition', ['d.id', '=', 'ed.definitionId'], 'ed')
      ->where_not_equal('d.status', Definition::ST_DELETED)
      ->where_null('ed.id')
      ->find_many();

SmartyWrap::assign('searchResults', SearchResult::mapDefinitionArray($defs));
SmartyWrap::assign('recentLinks', RecentLink::loadForUser());
SmartyWrap::displayAdminPage('admin/viewUnassociatedDefinitions.tpl');

?>
