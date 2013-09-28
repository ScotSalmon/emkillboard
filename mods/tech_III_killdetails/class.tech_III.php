<?php
require_once('common/includes/class.kill.php');
require_once('common/includes/class.killsummarytable.php');
require_once('common/includes/class.pilot.php');
require_once('common/includes/class.corp.php');
require_once('common/includes/class.alliance.php');

class tech_III
{
	function replace(&$object)
	{
		$object->replace("fitting", "tech_III::fitting");
		$object->replace("victim", "tech_III::victim");
		$object->delete("victimShip");
	}
	function victim($object)
	{
		global $smarty;
		$smarty->assign('killID', $object->kill->getID());
		$plt = new Pilot($object->kill->getVictimID());
		$smarty->assign('victimPortrait', $plt->getPortraitURL(64));
		$smarty->assign('victimURL', "?a=pilot_detail&amp;plt_id=" . $object->kill->getVictimID());
		$smarty->assign('victimExtID', $plt->getExternalID());
		$smarty->assign('victimName', $object->kill->getVictimName());
		$smarty->assign('victimCorpURL', "?a=corp_detail&amp;crp_id=" . $object->kill->getVictimCorpID());
		$smarty->assign('victimCorpName', $object->kill->getVictimCorpName());
		$smarty->assign('victimAllianceURL', "?a=alliance_detail&amp;all_id=" . $object->kill->getVictimAllianceID());
		$smarty->assign('victimAllianceName', $object->kill->getVictimAllianceName());
		$smarty->assign('victimDamageTaken', $object->kill->VictimDamageTaken);

		// Ship details
		$ship=$object->kill->getVictimShip();
		$shipclass=$ship->getClass();

		$smarty->assign('victimShip', $object->kill->getVictimShip());
		$smarty->assign('victimShipClass', $ship->getClass());
		$smarty->assign('victimShipImage', $ship->getImage(64));
		$smarty->assign('victimShipName', $ship->getName());
		$smarty->assign('victimShipID', $ship->externalid_);
		$smarty->assign('victimShipClassName', $shipclass->getName());
		if($object->page->isAdmin()) $smarty->assign('ship', $ship);

		include_once('common/includes/class.dogma.php');

		$ssc=new dogma($ship->externalid_);

		$smarty->assign_by_ref('ssc', $ssc);

		if ($object->kill->isClassified())
		{
		//Admin is able to see classified Systems
			if ($object->page->isAdmin())
			{
				if (config::get('apocfitting_mapmod'))
				{
					$smarty->assign('systemID', $object->system->getID());
				}
				$smarty->assign('system', $object->system->getName() . ' (Classified)');
				$smarty->assign('systemURL', "?a=system_detail&amp;sys_id=" . $object->system->getID());
				$smarty->assign('systemSecurity', $object->system->getSecurity(true));
			}
			else
			{
				$smarty->assign('system', 'Classified');
				$smarty->assign('systemURL', "");
				$smarty->assign('systemSecurity', '0.0');
			}
		}
		else
		{
			if (config::get('apocfitting_mapmod'))
			{
				$smarty->assign('systemID', $object->system->getID());
			}
			$smarty->assign('system', $object->system->getName());
			$smarty->assign('systemURL', "?a=system_detail&amp;sys_id=" . $object->system->getID());
			$smarty->assign('systemSecurity', $object->system->getSecurity(true));
		}

		$smarty->assign('timeStamp', $object->kill->getTimeStamp());
		$smarty->assign('victimShipImg', $ship->getImage(64));
		$smarty->assign('victimShipImgBig', $ship->getImage(256));

		$smarty->assign('totalLoss', number_format($object->kill->getISKLoss()));

		if($object->page->igb()) return $smarty->fetch(getcwd().'/mods/tech_III_killdetails/igb_kill_detail_victim.tpl');
		return $smarty->fetch(getcwd().'/mods/tech_III_killdetails/kill_detail_victim.tpl');
	}
	function fitting($object)
	{
		global $smarty;

		if (is_array($object->fitting_array[1]))
		{
			foreach ($object->fitting_array[1] as $array_rowh)
			{
				$sort_by_nameh["groupID"][]=$array_rowh["groupID"];
			}

			array_multisort($sort_by_nameh["groupID"], SORT_ASC, $object->fitting_array[1]);
		}

		if (is_array($object->fitting_array[2]))
		{
			foreach ($object->fitting_array[2] as $array_rowm)
			{
				$sort_by_namem["groupID"][]=$array_rowm["groupID"];
			}

			array_multisort($sort_by_namem["groupID"], SORT_ASC, $object->fitting_array[2]);
		}

		if (is_array($object->fitting_array[3]))
		{
			foreach ($object->fitting_array[3] as $array_rowl)
			{
				$sort_by_namel["groupID"][]=$array_rowl["Name"];
			}

			array_multisort($sort_by_namel["groupID"], SORT_ASC, $object->fitting_array[3]);
		}

		if (is_array($object->fitting_array[5]))
		{
			foreach ($object->fitting_array[5] as $array_rowr)
			{
				$sort_by_namer["Name"][]=$array_rowr["Name"];
			}

			array_multisort($sort_by_namer["Name"], SORT_ASC, $object->fitting_array[5]);
		}

		if (is_array($object->fitting_array[7]))
		{
			foreach ($object->fitting_array[7] as $array_rowr)
			{
				$sort_by_namer["groupID"][]=$array_rowr["groupID"];
			}

			array_multisort($sort_by_namer["groupID"], SORT_ASC, $object->fitting_array[7]);
		}

		//Fitting - KE, sort the fitted items into name order, so that several of the same item apear next to each other. -end

		$length=count($object->ammo_array[1]);

		$temp=array();

		if (is_array($object->fitting_array[1]))
		{
			$hiammo=array();

			foreach ($object->fitting_array[1] as $highfit)
			{
				$group = $highfit["groupID"];
				$size  =$highfit["chargeSize"];

				if ($group
					== 483                          // Modulated Deep Core Miner II, Modulated Strip Miner II and Modulated Deep Core Strip Miner II
					|| $group == 53                     // Laser Turrets
					|| $group == 55                     // Projectile Turrets
					|| $group == 74                     // Hybrid Turrets
					|| ($group >= 506 && $group <= 511) // Some Missile Lauchers
					|| $group == 481                    // Probe Launchers
					|| $group == 899                    // Warp Disruption Field Generator I
					|| $group == 771                    // Heavy Assault Missile Launchers
					|| $group == 589                    // Interdiction Sphere Lauchers
					|| $group == 524                    // Citadel Torpedo Launchers
				)
				{
					$found=0;

					if ($group == 511)
					{
						$group=509;
					} // Assault Missile Lauchers uses same ammo as Standard Missile Lauchers

					if (is_array($object->ammo_array[1]))
					{
						$i=0;

						while (!($found) && $i < $length)
						{
							$temp = array_shift($object->ammo_array[1]);

							if (($temp["usedgroupID"] == $group) && ($temp["size"] == $size))
							{
								$hiammo[]=array
									(
									'show' => $smarty->fetch(get_tpl('ammo')),
									'type' => $temp["Icon"]
								);

								$found=1;
							}

							array_push($object->ammo_array[1], $temp);
							$i++;
						}
					}

					if (!($found))
					{
						$hiammo[]=array
							(
							'show' => $smarty->fetch(get_tpl('ammo')),
							'type' => $smarty->fetch(get_tpl('noicon'))
						);
					}
				}
				else
				{
					$hiammo[]=array
						(
						'show' => $smarty->fetch(get_tpl('blank')),
						'type' => $smarty->fetch(get_tpl('blank'))
					);
				}
			}
		}

		$length=count($object->ammo_array[2]);

		if (is_array($object->fitting_array[2]))
		{
			$midammo=array();

			foreach ($object->fitting_array[2] as $midfit)
			{
				$group = $midfit["groupID"];

				if ($group == 76 // Capacitor Boosters
					|| $group == 208 // Remote Sensor Dampeners
					|| $group == 212 // Sensor Boosters
					|| $group == 291 // Tracking Disruptors
					|| $group == 213 // Tracking Computers
					|| $group == 209 // Tracking Links
					|| $group == 290 // Remote Sensor Boosters
				)
				{
					$found=0;

					if (is_array($object->ammo_array[2]))
					{
						$i=0;

						while (!($found) && $i < $length)
						{
							$temp = array_shift($object->ammo_array[2]);

							if ($temp["usedgroupID"] == $group)
							{
								$midammo[]=array
									(
									'show' => $smarty->fetch(get_tpl('ammo')),
									'type' => $temp["Icon"]
								);

								$found=1;
							}

							array_push($object->ammo_array[2], $temp);
							$i++;
						}
					}

					if (!($found))
					{
						$midammo[]=array
							(
							'show' => $smarty->fetch(get_tpl('ammo')),
							'type' => $smarty->fetch(get_tpl('noicon'))
						);
					}
				}
				else
				{
					$midammo[]=array
						(
						'show' => $smarty->fetch(get_tpl('blank')),
						'type' => $smarty->fetch(get_tpl('blank'))
					);
				}
			}
		}
		$smarty->assign_by_ref('fitting_high', $object->fitting_array[1]);
		$smarty->assign_by_ref('fitting_med', $object->fitting_array[2]);
		$smarty->assign_by_ref('fitting_low', $object->fitting_array[3]);
		$smarty->assign_by_ref('fitting_rig', $object->fitting_array[5]);
		$smarty->assign_by_ref('fitting_sub', $object->fitting_array[7]);
		$smarty->assign_by_ref('fitting_ammo_high', $hiammo);
		$smarty->assign_by_ref('fitting_ammo_mid', $midammo);
		$smarty->assign('showammo', config::get('apocfitting_showammo'));

		$smarty->assign('panel_colour', config::get('apocfitting_colour'));
		$smarty->assign('showcustom', config::get('apocfitting_showcustom'));
		$smarty->assign('showship', config::get('apocfitting_showship'));

		//if($object->page->igb()) return $smarty->fetch(getcwd().'/mods/tech_III_killdetails/igb_kill_detail_fitting.tpl');

		return $smarty->fetch(getcwd().'/mods/tech_III_killdetails/kill_detail_fitting.tpl');
	}
}