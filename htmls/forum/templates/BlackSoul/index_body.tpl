
<span class="nav"><a href="{U_INDEX}" class="nav">{L_INDEX}</a></span>
&nbsp;<br />
<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline" align="center">
  <tr> 
    <td align="left" valign="bottom">
        <!-- BEGIN switch_user_logged_in -->	
        <span class="mainmenu"><a href="{U_SEARCH_NEW}" class="mainmenu">&gt;&gt;{L_SEARCH_NEW}&lt;&lt;</a><br /></span>
		<span class="mainmenu"><a href="{U_SEARCH_SELF}" class="mainmenu">{L_SEARCH_SELF}</a></span></td>
		<td align="right"><span class="mainmenu">
		<a href="{U_SEARCH_UNANSWERED}" class="mainmenu">{L_SEARCH_UNANSWERED}</a></span><br>
        <span class="mainmenu">
        <a href="{U_MARK_READ}" class="mainmenu">{L_MARK_FORUMS_READ}</a></span>
		<!-- END switch_user_logged_in --></td>
  </tr>
</table>
<table width="100%" cellpadding="2" cellspacing="1" border="0" class="forumline">

	<tr> 
<td class="catLeft" colspan="2" height="28"><span class="cattitle"><a href="{U_PRIVATEMSGS}" class="cattitle">Private 
    Messages</a></span></td>
	<td class="rowpic" colspan="4" align="right">&nbsp;</td>
  </tr>
  <tr> 
      	<td class="row1" align="center" valign="middle"><img src="templates/BlackSoul/images/mailbox.gif" alt="Private Messages" /></td>
      	<td class="row1" align="center" colspan="5"><span class="gensmall"><a href="{U_PRIVATEMSGS}">{PRIVATE_MESSAGE_INFO}</span></td>
  </tr>

  <tr> 
	<th colspan="2" class="thCornerL" height="25" nowrap="nowrap">&nbsp;{L_FORUM}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_TOPICS}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;{L_POSTS}&nbsp;</th>
	<th class="thCornerR" nowrap="nowrap">&nbsp;{L_LASTPOST}&nbsp;</th>
	<th width="50" class="thTop" nowrap="nowrap">&nbsp;Moderators&nbsp;</th>
  </tr>
  <!-- BEGIN catrow -->
  <tr> 
	<td class="catLeft" colspan="2" height="25"><span class="cattitle"><a href="{catrow.U_VIEWCAT}" class="cattitle">{catrow.CAT_DESC}</a></span></td>
	<td class="rowpic" colspan="4" align="right">&nbsp;</td>
  </tr>
  <!-- BEGIN forumrow -->
  <tr> 
	<td class="row1" align="center" valign="middle" height="40"><img src="{catrow.forumrow.FORUM_FOLDER_IMG}" alt="{catrow.forumrow.L_FORUM_FOLDER_ALT}" title="{catrow.forumrow.L_FORUM_FOLDER_ALT}" /></td>
	<td class="row1" width="100%" height="40"><span class="forumlink"> <a href="{catrow.forumrow.U_VIEWFORUM}" class="forumlink">{catrow.forumrow.FORUM_NAME}</a><br />
	  </span> <span class="genmed">{catrow.forumrow.FORUM_DESC}<br />
	  </span></td>
	<td class="row2" align="center" valign="middle" height="40"><span class="gensmall">{catrow.forumrow.TOPICS}</span></td>
	<td class="row2" align="center" valign="middle" height="40"><span class="gensmall">{catrow.forumrow.POSTS}</span></td>
	<td class="row2" align="center" valign="middle" height="40" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.LAST_POST}</span></td>
	<td class="row2" align="center" valign="middle" height="40" nowrap="nowrap"> <span class="gensmall">{catrow.forumrow.MODERATORS}</span></td>
  </tr>
  <!-- END forumrow -->
  <!-- END catrow -->
</table>
<!-- BRAIN <table width="100%" cellspacing="0" border="0" align="center" cellpadding="2">
  <tr> 
	<td align="left"><span class="gensmall"><a href="{U_MARK_READ}" class="gensmall">{L_MARK_FORUMS_READ}</a></span></td>
	<td align="right"><span class="gensmall">{S_TIMEZONE}</span></td>
  </tr>
</table> -->

<table cellspacing="3" border="0" align="center" cellpadding="0">
  <tr> 
	<td><span class="gensmall">Legenda:&nbsp;&nbsp;&nbsp;&nbsp;</span></td>
	<td width="20" align="center"><img src="templates/BlackSoul/images/folder_new.gif" alt="{L_NEW_POSTS}"/></td>
	<td><span class="gensmall">{L_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/BlackSoul/images/folder.gif" alt="{L_NO_NEW_POSTS}" /></td>
	<td><span class="gensmall">{L_NO_NEW_POSTS}</span></td>
	<td>&nbsp;&nbsp;</td>
	<td width="20" align="center"><img src="templates/BlackSoul/images/folder_lock.gif" alt="{L_FORUM_LOCKED}" /></td>
	<td><span class="gensmall">{L_FORUM_LOCKED}</span></td>
  </tr>
</table>

&nbsp;<br />
&nbsp;<br />
<table width="100%" cellpadding="3" cellspacing="1" border="0" class="forumline">
  <tr> 
	<td class="catHead" colspan="2" height="28"><span class="cattitle"><a href="{U_VIEWONLINE}" class="cattitle">{L_WHO_IS_ONLINE}</a></span></td>
  </tr>
  <tr> 
	<td class="row1" align="center" valign="middle" rowspan="2"><img src="templates/BlackSoul/images/whosonline.gif" width="16" height="16" alt="{L_WHO_IS_ONLINE}" /></td>
  	<td class="row1" align="left"><span class="gensmall">{TOTAL_USERS_ONLINE} &nbsp; [ {L_WHOSONLINE_ADMIN} ] &nbsp; [ {L_WHOSONLINE_MOD} ]<br />{RECORD_USERS}<br />{LOGGED_IN_USER_LIST}<br /></td>
  </tr>
</table>
<!-- COMMETO BRAIN<table width="100%" cellpadding="1" cellspacing="1" border="0">
	<td align="left" valign="top"><span class="gensmall">{L_ONLINE_EXPLAIN}</span></td>
</table>-->
<table width="100%" cellspacing="1" cellpadding="2" border="0" class="forumline" align="center">
  <tr> 
    <td class="row1" align="left" valign="bottom"><span class="gensmall">
    <!-- BEGIN switch_user_logged_in -->
	{LAST_VISIT_DATE}<br />
    <!-- END switch_user_logged_in -->	
	{CURRENT_TIME}<br>
    </span></td>
	<td class="row1" align="right" valign="bottom" class="gensmall">
		<span class="gensmall">{TOTAL_USERS}</span><br /><span class="gensmall">{NEWEST_USER}<br>
        {TOTAL_POSTS}</span></td>
  </tr>
</table>

<br clear="all" />
