<?php
/**
 * $Date$
 * $Revision$
 * $HeadURL$
 * @package EDK
 */


/**
 * Creates a new Pilot or fetches an existing one from the database.
 * @package EDK
 */
class Pilot extends Entity
{
	private $executed = false;
	private $id = 0;
	private $externalid = 0;
	private $corpid = null;
	private $valid = false;
	private $corp = null;
	private $name = null;
	private $updated = null;


	/**
	 * Create a new Pilot object from the given ID.
	 *
     * @param integer $id The pilot ID.
	 * @param integer $externalID The external pilot ID.
	 * @param string $name The pilot name.
	 * @param integer|Corporation The pilot's corporation.
     */
	function Pilot($id = 0, $externalID = 0, $name = null, $corp = null)
	{
		$this->id = intval($id);
		$this->externalid = intval($externalID);
		if(isset($name)) {
			$this->name = $name;
		}
		if(isset($corp)) {
			if(is_numeric($corp)) {
				$this->corpid = $corp;
			} else {
				$this->corp = $corp;
				$this->corpid = $corp->getID();
			}
		}
	}
	/**
	 * Return the pilot ID.
	 *
	 * @return integer
	 */
	function getID()
	{
		if($this->id) {
			return $this->id;
		} else if($this->externalid) {
			$this->execQuery();
			return $this->id;
		} else {
			return 0;
		}
	}
	/**
	 * Return the pilot's CCP ID.
	 * When populateList is true, the lookup will return 0 in favour of getting the
	 *  external ID from CCP. This helps the kill_detail page load times.
	 *
	 * @param boolean $populateList
	 * @return integer
	 */
	public function getExternalID($populateList = false)
	{
		if($this->externalid) {
			return $this->externalid;
		}
		if(!$populateList) {
			$this->execQuery();
			if($this->externalid) {
				return $this->externalid;
			}

			$pqry = new DBPreparedQuery();
			$sql = "SELECT typeID FROM kb3_invtypes, kb3_pilots WHERE typeName = plt_name AND plt_id = ?";
			$id = "";
			$pqry->prepare($sql);
			$pqry->bind_param('i', $this->id);
			$pqry->bind_result($id);
			if($pqry->execute()) {
				if($pqry->recordCount())
				{
					$pqry->fetch();
					$this->setCharacterID($id);
					return $this->externalid;
				}
			}
			$myID = new API_NametoID();
			$myID->setNames($this->getName());
			$myID->fetchXML();
			$myNames = $myID->getNameData();

			if($this->setCharacterID($myNames[0]['characterID'])) {
				return $this->externalid;
			} else {
				return 0;
			}
		}
		else return 0;
	}
	/**
	 * Return the pilot name.
	 *
	 * @return string
	 */
	public function getName()
	{
		if(!$this->name) {
			$this->execQuery();
		}
		$pos = strpos($this->name, "#");
		if ($pos === false) {
			// Hacky, hacky, hack hack
			// TODO: Fix this and change old kills to suit.
			$pos = strpos($this->name, "- ");
			if ($pos === false) return $this->name;
			else if(strpos($this->name, "Moon")==false)
				return substr($this->name, $pos + 2);
			else return $this->name;
		} else {
			$name = explode("#", $this->name);
			return $name[3];
		}
	}

	/**
	 * Return the URL for the pilot's portrait.
	 *
     * @param integer $size The desired portrait size.
	 * @return string URL for a portrait.
     */
	public function getPortraitURL($size = 64)
	{
		if(!$this->externalid) {
			$this->execQuery();
		}
		if (!$this->externalid) {
			return KB_HOST."/thumb.php?type=pilot&amp;id=".$this->id."&amp;size=$size&amp;int=1";
		} else {
			return imageURL::getURL('Pilot', $this->externalid, $size);
		}
	}
	/**
	 * Return the file path for the pilot's portrait.
	 *
	 * The portrait is not generated by this function. If the portrait does
	 * not exist then the path it would use is returned.
	 * @param integer $size The desired portrait size.
	 * @param integer $id The pilot ID to use. If not given and this is instantiated
	 * use the ID for this pilot.
	 * @return string path for a portrait.
     */
	public function getPortraitPath($size = 64, $id = 0)
	{
		$size = intval($size);
		$id = intval($id);
		if (!$id) {
			$id = $this->getExternalID();
		}
		return CacheHandler::getInternal($id."_".$size.".jpg", "img");
	}
	/**
	 * Fetch the pilot details from the database using the id given on construction.
	 */
	private function execQuery()
	{
		if (!$this->executed) {
			if(!$this->externalid && !$this->id) {
				$this->valid = false;
				return;
			}
			if ($this->id && $this->isCached()) {
				$cache = $this->getCache();
				$this->valid = $cache->valid;
				$this->id = $cache->id;
				$this->name = $cache->name;
				$this->corpid = $cache->corpid;
				$this->externalid = $cache->externalid;

				$this->executed = true;
				return;
			}
			$qry = DBFactory::getDBQuery();
			$sql = 'select * from kb3_pilots plt, kb3_corps crp, kb3_alliances ali
            	  	       where crp.crp_id = plt.plt_crp_id
            		       and ali.all_id = crp.crp_all_id ';
			if($this->externalid) {
				$sql .= 'and plt.plt_externalid = '.$this->externalid;
			} else {
				$sql .= 'and plt.plt_id = '.$this->id;
			}
			$qry->execute($sql) or die($qry->getErrorMsg());
			if($this->externalid && !$qry->recordCount()) {
				$this->fetchPilot();
				$this->valid = false;
			} else if (!$qry->recordCount()) {
				$this->valid = false;
			} else {
				$row = $qry->getRow();
				$this->valid = true;
				$this->id = $row['plt_id'];
				$this->name = $row['plt_name'];
				$this->corpid = $row['plt_crp_id'];
				$this->externalid = intval($row['plt_externalid']);
				$this->putCache();

			}
			$this->executed = true;
		}
	}
	/**
	 * Return the most recently recorded Corporation this pilot is a member of.
	 *
	 * @return Corporation Corporation object
     */
	public function getCorp()
	{
		if(isset($this->corp)) {
			return $this->corp;
		}
		if(!isset($this->corpid)) {
			$this->execQuery();
		}

		$this->corp = new Corporation($this->corpid);
		return $this->corp;
	}
	/**
	 * Check if the id given on construction is valid.
	 *
	 * @return boolean true if this pilot exists.
     */
	public function exists()
	{
		$this->execQuery();
		return $this->valid;
	}
	/**
	 * Add a new pilot to the database or update the details of an existing one.
	 *
     * @param string $name Pilot name
	 * @param Corporation $corp Corporation object for this pilot's corporation
	 * @param string $timestamp time this pilot's corp was updated
	 * @param integer $externalID CCP external id
     */
	public function add($name, $corp, $timestamp, $externalID = 0, $loadExternals = true)
	{
	// Check if pilot exists with a non-cached query.
		$qry = DBFactory::getDBQuery(true);
		$name = $qry->escape(stripslashes($name));
		// Insert or update a pilot with a cached query to update cache.
		$qryI = DBFactory::getDBQuery(true);
		$qry->execute("select *
                        from kb3_pilots
                       where plt_name = '".$name."'");

		if ($qry->recordCount() == 0)
		{
			$externalID = intval($externalID);
			// If no external id is given then look it up.
			if(!$externalID && $loadExternals)
			{
				$pilotname = str_replace(" ", "%20", $name );
				$myID = new API_NametoID();
				$myID->setNames($pilotname);
				$myID->fetchXML();
				$myNames = $myID->getNameData();
				$externalID = intval($myNames[0]['characterID']);
			}
			// If we have an external id then check it isn't already in use.
			// If we find it then update the old corp with the new name and
			// return.
			if($externalID)
			{
				$qry->execute("SELECT * FROM kb3_pilots WHERE plt_externalid = ".$externalID);
				if ($qry->recordCount() > 0)
				{
					$row = $qry->getRow();
					$qryI->execute("UPDATE kb3_pilots SET plt_name = '".$name."' WHERE plt_externalid = ".$externalID);

					$this->id = $row['plt_id'];
					$this->name = $name;
					$this->externalid = $row['plt_externalid'];
					$this->corpid = $row['plt_crp_id'];
					if(!is_null($row['plt_updated'])) $this->updated = strtotime($row['plt_updated']." UTC");
					else $this->updated = null;

					// Now check if the corp needs to be updated.
					if ($row['plt_crp_id'] != $corp->getID() && $this->isUpdatable($timestamp))
					{
						$qryI->execute("update kb3_pilots
									 set plt_crp_id = ".$corp->getID().",
										 plt_updated = date_format( '".$timestamp."', '%Y.%m.%d %H:%i:%s') WHERE plt_externalid = ".$externalID);
					}
					$this->putCache();
					return $this->id;
				}
			}
			$qry->execute("insert into kb3_pilots (plt_name, plt_crp_id, plt_externalid, plt_updated) values (
                                                        '".$name."',
                                                        ".$corp->getID().",
                                                        ".$externalID.",
                                                        date_format( '".$timestamp."', '%Y.%m.%d %H:%i:%s'))
														ON DUPLICATE KEY UPDATE plt_crp_id=".$corp->getID().",
                                                        plt_externalid=".$externalID.",
                                                        plt_updated=date_format( '".$timestamp."', '%Y.%m.%d %H:%i:%s')");
			$this->id = $qry->getInsertID();
			$this->name = $name;
			$this->corpid = $corp->getID();
			$this->updated = strtotime(preg_replace("/\./","-",$timestamp)." UTC");
		}
		else
		{
			$row = $qry->getRow();
			$this->id = $row['plt_id'];
			if(!is_null($row['plt_updated'])) {
				$this->updated = strtotime($row['plt_updated']." UTC");
			} else {
				$this->updated = null;
			}
			if ($this->isUpdatable($timestamp) && $row['plt_crp_id'] != $corp->getID()) {
				$qryI->execute("update kb3_pilots
                             set plt_crp_id = ".$corp->getID().",
                                 plt_updated = date_format( '".$timestamp."', '%Y.%m.%d %H:%i:%s') where plt_id = ".$this->id);
			}
			if (!$row['plt_externalid'] && $externalID) {
				$this->setCharacterID($externalID);
			}
			$this->corp = $corp;
			$this->name = $name;
			$this->corpid = $corp->getID();
		}
		$this->putCache();
		return $this->id;
	}
	/**
	 * Return whether this pilot was updated before the given timestamp.
	 *
     * @param string $timestamp A timestamp to compare this pilot's details with.
	 * @return boolean - true if update time was before the given timestamp.
     */
	public function isUpdatable($timestamp)
	{
		$timestamp = preg_replace("/\./","-",$timestamp);
		if(isset($this->updated)) {
			if(is_null($this->updated)
					|| strtotime($timestamp." UTC") > $this->updated) {
				return true;
			} else {
				return false;
			}
		}
		$qry = DBFactory::getDBQuery();
		$qry->execute("select plt_id
                        from kb3_pilots
                       where plt_id = ".$this->id."
                         and ( plt_updated < date_format( '".$timestamp."', '%Y-%m-%d %H:%i')
                               or plt_updated is null )");

		return $qry->recordCount() == 1;
	}
	/**
	 * Set the CCP external ID for this pilot.
	 *
	 * If a character already exists with this id then a name change is assumed
	 * and the old pilot is updated.
     * @param integer $externalID CCP external ID for this pilot.
     */
	public function setCharacterID($externalID)
	{
		if (!intval($externalID)) {
			return false;
		}
		$this->externalid = intval($externalID);
		$qry = DBFactory::getDBQuery(true);
		$qry->execute("SELECT plt_id FROM kb3_pilots WHERE plt_externalid = ".$this->externalid." AND plt_id <> ".$this->id);
		if($qry->recordCount()) {
			$result = $qry->getRow();
			$qry->autocommit(false);
			$old_id = $result['plt_id'];
			$qry->execute("UPDATE kb3_kills SET kll_victim_id = ".$old_id." WHERE kll_victim_id = ".$this->id);
			$qry->execute("UPDATE kb3_kills SET kll_fb_plt_id = ".$old_id." WHERE kll_fb_plt_id = ".$this->id);
			$qry->execute("UPDATE kb3_inv_detail SET ind_plt_id = ".$old_id." WHERE ind_plt_id = ".$this->id);
			$qry->execute("DELETE FROM kb3_sum_pilot WHERE psm_plt_id = ".$this->id);
			$qry->execute("DELETE FROM kb3_sum_pilot WHERE psm_plt_id = ".$old_id);
			$qry->execute("DELETE FROM kb3_pilots WHERE plt_id = ".$this->id);
			$qry->execute("UPDATE kb3_pilots SET plt_name = '".$qry->escape($this->name)."' where plt_id = ".$old_id);
			$this->id = $old_id;
			$qry->autocommit(true);

			$this->putCache();
			return true;
		}
		$qry->execute("update kb3_pilots set plt_externalid = ".$this->externalid."
                       where plt_id = ".$this->id);
		$this->putCache();
		return true;
	}
    /**
     * Lookup a pilot name and set this object to use the details found.
     *
     * @param string $name The pilot name to look up.
     */
    public function lookup($name)
    {
        $qry = DBFactory::getDBQuery();
        $qry->execute("select * from kb3_pilots
                       where plt_name = '".$qry->escape(stripslashes($name))."'");
        $row = $qry->getRow();
        if ($row['plt_id']) {
			$this->id = $row['plt_id'];
		}
		$this->name = $row['plt_name'];
		$this->externalid = intval($row['plt_externalid']);
		$this->corpid = $row['plt_crp_id'];
		$this->updated = strtotime($row['plt_updated']." UTC");

}
	
	/**
	 * Fetch the pilot name from CCP using the stored external ID.
	 *
	 * Corporation will be set to Unknown.
	 */
	private function fetchPilot()
	{
		if(!$this->externalid) return false;

		$myID = new API_IDtoName();
		$myID->setIDs($this->externalid);
		$myID->fetchXML();
		$myNames = $myID->getIDData();
		
		$alliance = new Alliance();
		$alliance->add("Unknown");
		
		$corp = new Corporation();
		$corp->add("Unknown", $alliance, '2000-01-01 00:00:00');

		$this->add($myNames[0]['name'], $corp,
			$myID->getCurrentTime(), intval($myNames[0]['characterID']));
	}
}
