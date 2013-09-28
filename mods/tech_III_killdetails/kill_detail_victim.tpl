{cycle reset=true print=false name=ccl values="kb-table-row-even,kb-table-row-odd"}
<table class="kb-table" width="360" cellpadding="0" cellspacing="1" border="0">
	<tr class="{cycle name=ccl}">
		<td rowspan="3" width="64"><img src="{$victimPortrait}" border="0" width="64" height="64" alt="victim" /></td>
		<td rowspan="3" width="64"><img src="{$victimShipImg}" border="0" width="64" height="64" alt="victim" /></td>
		<td class="kb-table-cell" width="64"><b>Victim:</b></td>
		<td class="kb-table-cell"><b><a href="{$victimURL}">{$victimName}</a></b></td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td class="kb-table-cell" width="64"><b>Corp:</b></td>
		<td class="kb-table-cell"><b><a href="{$victimCorpURL}">{$victimCorpName}</a></b></td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td class="kb-table-cell" width="64"><b>Alliance:</b></td>
		<td class="kb-table-cell"><b><a href="{$victimAllianceURL}">{$victimAllianceName}</a></b></td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td colspan="2" class="kb-table-cell" width="128" align="right"><b>Ship:</b></td>
		<td colspan="2" class="kb-table-cell"><b><a href="?a=invtype&amp;id={$victimShipID}">{$victimShipName}</a></b> ({$victimShipClassName})</td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td colspan="2" class="kb-table-cell" width="128" align="right"><b>Location:</b></td>
		<td colspan="2" class="kb-table-cell"><b><a href="{$systemURL}">{$system}</a></b> ({$systemSecurity})</td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td colspan="2" class="kb-table-cell" width="128" align="right"><b>Date:</b></td>
		<td colspan="2" class="kb-table-cell">{$timeStamp}</td>
	</tr>
	{if $showiskd}
	<tr class="{cycle name=ccl}">
		<td colspan="2" class="kb-table-cell" width="128" align="right"><b>Total ISK Loss:</b></td>
		<td colspan="2" class="kb-table-cell">{$totalLoss}</td>
	</tr>
	<tr class="{cycle name=ccl}">
		<td colspan="2" class="kb-table-cell" width="128" align="right"><b>Total Damage Taken:</b></td>
		<td colspan="2" class="kb-table-cell">{$victimDamageTaken|number_format}</td>
	</tr>
	{/if}
</table>