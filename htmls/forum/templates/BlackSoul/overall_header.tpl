<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html dir="{S_CONTENT_DIRECTION}">
<head>
<meta http-equiv="Content-Type" content="text/html; charset={S_CONTENT_ENCODING}">
<meta http-equiv="Content-Style-Type" content="text/css">
{META}
<!-- commento BRAIN  [graffa]NAV_LINKS[graffa] -->
<title>{SITENAME} :: {PAGE_TITLE}</title>
<link rel="stylesheet" href="templates/BlackSoul/{T_HEAD_STYLESHEET}" type="text/css">
<!-- BEGIN switch_enable_pm_popup -->
<script language="Javascript" type="text/javascript">
<!--
	if ( {PRIVATE_MESSAGE_NEW_FLAG} )
	{
		window.open('{U_PRIVATEMSGS_POPUP}', '_phpbbprivmsg', 'HEIGHT=225,resizable=yes,WIDTH=400');;
	}
//-->
</script>
<!-- END switch_enable_pm_popup -->
</head>
<body bgcolor="{T_BODY_BGCOLOR}" text="{T_BODY_TEXT}" link="{T_BODY_LINK}" vlink="{T_BODY_VLINK}">

<a name="top"></a>

<table width="100%" cellspacing="0" cellpadding="10" border="0" align="center"> 
	<tr> 
		<td class="bodyline"><table width="100%" cellspacing="0" cellpadding="0" border="0">
			<tr> 
				<td><a href="{U_INDEX}"><img src="templates/BlackSoul/images/logo_phpBB.gif" border="0" alt="{L_INDEX}" vspace="1" /></a></td>
				<td align="right" width="100%" valign="middle"><span class="gen"><br />&nbsp; </span> 
				<table cellspacing="0" cellpadding="0" border="0">
					<tr> 
						<td align="center" valign="top" nowrap="nowrap"><span class="mainmenu">&nbsp;</span><span class="maintitle"><a href="../">{SITENAME}</a><br>
                        </span><br /></td>
					</tr>
					<tr>
						<td align="center" valign="center" nowrap="nowrap" class="menu">						
              <span class="mainmenu"><a href="{U_PROFILE}" class="mainmenu"><img src="templates/BlackSoul/images/profile.gif" width="17" height="20" border="0" alt="{L_PROFILE}" hspace="0" />{L_PROFILE}</a>&nbsp;&nbsp;</span><span class="mainmenu"><a href="{U_REGISTER}" class="mainmenu"><img src="templates/BlackSoul/images/register.gif" width="19" height="20" border="0" alt="{L_REGISTER}" hspace="0" />{L_REGISTER}</a>&nbsp;&nbsp;<a href="{U_FAQ}" class="mainmenu"><img src="templates/BlackSoul/images/faq.gif" width="21" height="20" border="0" alt="{L_FAQ}" hspace="0" />{L_FAQ}</a>&nbsp;&nbsp;<a href="{U_INDEX}" class="mainmenu"><img src="templates/BlackSoul/images/bbhome.gif" width="19" height="20" border="0" alt="{L_INDEX}" hspace="0" />{L_INDEX}</a>&nbsp;&nbsp;<a href="{U_SEARCH}" class="mainmenu"><img src="templates/BlackSoul/images/search.gif" width="17" height="20" border="0" alt="{L_SEARCH}" hspace="0" />{L_SEARCH}</a></span>&nbsp;
						</td>
					</tr>
					<tr>
					 <td align="center" class="menu">
					 </td>
					</tr>
					<tr>
						<td height="25" align="center" valign="top" nowrap="nowrap" class="menu"><span class="mainmenu">&nbsp;<a href="{U_MEMBERLIST}" class="mainmenu"><img src="templates/BlackSoul/images/members.gif" width="9" height="20" border="0" alt="{L_MEMBERLIST}" hspace="0" />{L_MEMBERLIST}</a>&nbsp;&nbsp;<a href="{U_GROUP_CP}" class="mainmenu"><img src="templates/BlackSoul/images/usergroups.gif" width="18" height="20" border="0" alt="{L_USERGROUPS}" hspace="0" />{L_USERGROUPS}</a>&nbsp;&nbsp;
						  <!-- BEGIN switch_user_logged_in -->
<!--							  <a href="{U_LOGIN_LOGOUT}" class="mainmenu"><img src="templates/BlackSoul/images/login_out.gif" width="17" height="20" border="0" alt="{L_LOGIN_LOGOUT}" hspace="0" />{L_LOGIN_LOGOUT}</a>&nbsp;&nbsp;
-->								<form action="{U_ACTION}" name="f2" id="f2" method="{METHOD}" class="mainmenu"><img src="templates/BlackSoul/images/login_out.gif" width="17" height="20" border="0" alt="{L_LOGIN_LOGOUT}" hspace="0" /><input class="submit" name="f2_submit" value="{L_LOGIN_LOGOUT}" type="submit" /></form>
							<!-- END switch_user_logged_in -->
							</span></td>
					</tr>
					<tr>
					 <td align="center">


<!-- BEGIN switch_user_logged_out -->
<form method="post" action="{S_LOGIN_ACTION}">
  <table width="350" cellpadding="3" cellspacing="1" border="0" class="forumline">
	<tr> 
	  <td class="catHead" height="28"><a name="login"></a><span class="cattitle">{L_LOGIN_LOGOUT}</span></td>
	</tr>
	<tr> 
	  <td class="row1" align="center" valign="middle"> <!--height="28"--><span class="gensmall">{L_USERNAME}: 
		<input class="post" type="text" name="username" size="10" />
		&nbsp;&nbsp;&nbsp;{L_PASSWORD}: 
		<input class="post" type="password" name="password" size="10" /><br />
<!-- height="28"--><!--	
		<input class="text" type="checkbox" name="autologin" value="ON" /> {L_AUTO_LOGIN} 
		&nbsp;&nbsp;&nbsp; -->
		<input type="submit" class="mainoption" name="login" value="{L_LOGIN}" />
		</span> </td>
	</tr>
  </table>
</form>
<!-- END switch_user_logged_out -->					

					 </td>
					</tr>
				</table></td>
				
			</tr>
		</table>

		<br />