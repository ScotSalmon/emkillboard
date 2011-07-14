<?php
/**
 * $Date$
 * $Revision$
 * $HeadURL$
 * @package EDK
 */

class TopTable_Ship
{
	function TopTable_Ship($TopList)
	{
		$this->toplist = $TopList;
	}

	function generate()
	{
		global $smarty;
		$this->toplist->generate();

		while ($row = $this->toplist->getRow())
		{
			$ship = new Ship($row['shp_id']);
			$shipclass = $ship->getClass();
			$shipclass->getName();

			$rows[] = array(
				'rank' => false,
				'name' => $ship->getName(),
				'subname' => $shipclass->getName(),
				'uri' => "?a=invtype&amp;id=".$ship->getExternalID(),
				'portrait' => $ship->getImage(32),
				'count' => $row['cnt']);
		}

		$smarty->assign('tl_name', Language::get('ship'));
		$smarty->assign('tl_type', Language::get('kills'));
		$smarty->assignByRef('tl_rows', $rows);

		return $smarty->fetch(get_tpl('toplisttable'));
	}
}

