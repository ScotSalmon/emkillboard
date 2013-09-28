{cycle reset=true print=false name=ccl values="kb-table-row-even,kb-table-row-odd"}
<div id="fitting" style="position:relative; height:397px; width:398px;" title="fitting">
	<div id="mask" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img border="0" style="position:absolute; height:397px; width:398px;" src="{$kb_host}/mods/tech_III_killdetails/img/panel/{$panel_colour}.png" /></div>
	<div id="high0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/{$ssc->attrib.hiSlots.value}h_T3.gif" border="0" /></div>
	<div id="mid0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/{$ssc->attrib.medSlots.value}m_T3.gif" border="0" /></div>
	<div id="low0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/{$ssc->attrib.lowSlots.value}l_T3.gif" border="0" /></div>
	<div id="rig0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/{$ssc->attrib.rigSlots.value}r_T3.gif" border="0" /></div>
	{if $victimShipClassName == ('Strategic Cruiser')} <!--- Show All Slots --->

	<div id="sub0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/5s_T3.gif" border="0" /></div>
	<div id="high0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/8h_T3.gif" border="0" /></div>
	<div id="med0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/8m_T3.gif" border="0" /></div>
	<div id="low0" style="position:absolute; left:0px; top:0px; width:398px; height:397px; z-index:1;">
		<img src="{$kb_host}/mods/tech_III_killdetails/img/panel/8l_T3.gif" border="0" /></div>
	{/if}

	<div id="high1" style="position:absolute; left:061px; top:069px; width:32px; height:32px; z-index:2;">{$fitting_high.0.Icon}</div>
	<div id="high2" style="position:absolute; left:091px; top:043px; width:32px; height:32px; z-index:2;">{$fitting_high.1.Icon}</div>
	<div id="high3" style="position:absolute; left:126px; top:027px; width:32px; height:32px; z-index:2;">{$fitting_high.2.Icon}</div>
	<div id="high4" style="position:absolute; left:164px; top:018px; width:32px; height:32px; z-index:2;">{$fitting_high.3.Icon}</div>
	<div id="high5" style="position:absolute; left:203px; top:018px; width:32px; height:32px; z-index:2;">{$fitting_high.4.Icon}</div>
	<div id="high6" style="position:absolute; left:241px; top:027px; width:32px; height:32px; z-index:2;">{$fitting_high.5.Icon}</div>
	<div id="high7" style="position:absolute; left:275px; top:043px; width:32px; height:32px; z-index:2;">{$fitting_high.6.Icon}</div>
	<div id="high8" style="position:absolute; left:306px; top:069px; width:32px; height:32px; z-index:2;">{$fitting_high.7.Icon}</div>

	<div id="mid1" style="position:absolute; left:343px; top:135px; width:32px; height:32px; z-index:2;">{$fitting_med.0.Icon}</div>
	<div id="mid2" style="position:absolute; left:350px; top:174px; width:32px; height:32px; z-index:2;">{$fitting_med.1.Icon}</div>
	<div id="mid3" style="position:absolute; left:348px; top:213px; width:32px; height:32px; z-index:2;">{$fitting_med.2.Icon}</div>
	<div id="mid4" style="position:absolute; left:337px; top:249px; width:32px; height:32px; z-index:2;">{$fitting_med.3.Icon}</div>
	<div id="mid5" style="position:absolute; left:317px; top:283px; width:32px; height:32px; z-index:2;">{$fitting_med.4.Icon}</div>
	<div id="mid6" style="position:absolute; left:291px; top:312px; width:32px; height:32px; z-index:2;">{$fitting_med.5.Icon}</div>
	<div id="mid7" style="position:absolute; left:258px; top:333px; width:32px; height:32px; z-index:2;">{$fitting_med.6.Icon}</div>
	<div id="mid8" style="position:absolute; left:222px; top:346px; width:32px; height:32px; z-index:2;">{$fitting_med.7.Icon}</div>

	<div id="low1" style="position:absolute; left:145px; top:346px; width:32px; height:32px; z-index:2;">{$fitting_low.0.Icon}</div>
	<div id="low2" style="position:absolute; left:109px; top:333px; width:32px; height:32px; z-index:2;">{$fitting_low.1.Icon}</div>
	<div id="low3" style="position:absolute; left:076px; top:312px; width:32px; height:32px; z-index:2;">{$fitting_low.2.Icon}</div>
	<div id="low4" style="position:absolute; left:050px; top:283px; width:32px; height:32px; z-index:2;">{$fitting_low.3.Icon}</div>
	<div id="low5" style="position:absolute; left:030px; top:249px; width:32px; height:32px; z-index:2;">{$fitting_low.4.Icon}</div>
	<div id="low6" style="position:absolute; left:019px; top:213px; width:32px; height:32px; z-index:2;">{$fitting_low.5.Icon}</div>
	<div id="low7" style="position:absolute; left:017px; top:174px; width:32px; height:32px; z-index:2;">{$fitting_low.6.Icon}</div>
	<div id="low8" style="position:absolute; left:023px; top:135px; width:32px; height:32px; z-index:2;">{$fitting_low.7.Icon}</div>

	<div id="rig1" style="position:absolute; left:060px; top:146px; width:32px; height:32px; z-index:2;">{$fitting_rig.0.Icon}</div>
	<div id="rig2" style="position:absolute; left:055px; top:176px; width:32px; height:32px; z-index:2;">{$fitting_rig.1.Icon}</div>
	<div id="rig3" style="position:absolute; left:057px; top:205px; width:32px; height:32px; z-index:2;">{$fitting_rig.2.Icon}</div>

	<div id="sub1" style="position:absolute; left:065px; top:233px; width:24px; height:24px; z-index:2;">{$fitting_sub.0.Icon}</div>
	<div id="sub2" style="position:absolute; left:080px; top:260px; width:24px; height:24px; z-index:2;">{$fitting_sub.1.Icon}</div>
	<div id="sub3" style="position:absolute; left:100px; top:281px; width:24px; height:24px; z-index:2;">{$fitting_sub.2.Icon}</div>
	<div id="sub4" style="position:absolute; left:125px; top:298px; width:24px; height:24px; z-index:2;">{$fitting_sub.3.Icon}</div>
	<div id="sub5" style="position:absolute; left:154px; top:308px; width:24px; height:24px; z-index:2;">{$fitting_sub.4.Icon}</div>


	{if $showship == 1}
	<div id="bigship" style="position:absolute; left:72px; top:71px; width256px; height:256px; z-index:0;"><img src="{$victimShipImgBig}" /></div>
	{else}
	<div id="bigship" style="position:absolute; left:72px; top:71px; width256px; height:256px; z-index:0;"><img src="{$kb_host}/mods/tech_III_killdetails/img/panel/wreck.png" /></div>
	{/if}

	{if $showcustom == 1}
	<div id="custom" style="position:absolute; left:118px; top:134px; width182px; height:126px; z-index:1;"><img src="{$kb_host}/mods/tech_III_killdetails/img/panel/custom.png" border="0" /></div>
	{/if}

	{if $showammo}
	<div id="high1l" style="position:absolute; left:086px; top:090px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.0.type}</div>
	<div id="high2l" style="position:absolute; left:110px; top:070px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.1.type}</div>
	<div id="high3l" style="position:absolute; left:140px; top:055px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.2.type}</div>
	<div id="high4l" style="position:absolute; left:172px; top:048px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.3.type}</div>
	<div id="high5l" style="position:absolute; left:204px; top:048px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.4.type}</div>
	<div id="high6l" style="position:absolute; left:236px; top:055px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.5.type}</div>
	<div id="high7l" style="position:absolute; left:264px; top:070px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.6.type}</div>
	<div id="high8l" style="position:absolute; left:289px; top:090px; width:24px; height:24px; z-index:2;">{$fitting_ammo_high.7.type}</div>

	<div id="mid1l" style="position:absolute; left:321px; top:146px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.0.type}</div>
	<div id="mid2l" style="position:absolute; left:327px; top:178px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.1.type}</div>
	<div id="mid3l" style="position:absolute; left:325px; top:210px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.2.type}</div>
	<div id="mid4l" style="position:absolute; left:316px; top:241px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.3.type}</div>
	<div id="mid5l" style="position:absolute; left:300px; top:269px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.4.type}</div>
	<div id="mid6l" style="position:absolute; left:278px; top:293px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.5.type}</div>
	<div id="mid7l" style="position:absolute; left:250px; top:311px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.6.type}</div>
	<div id="mid8l" style="position:absolute; left:221px; top:322px; width:24px; height:24px; z-index:2;">{$fitting_ammo_mid.7.type}</div>
	{/if}
</div>