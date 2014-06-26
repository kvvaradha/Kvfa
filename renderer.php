<?php
/**********************************************************************
    Copyright (C) FrontAccounting, LLC.
	Released under the terms of the GNU General Public License, GPL, 
	as published by the Free Software Foundation, either version 3 
	of the License, or (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
    See the License here <http://www.gnu.org/licenses/gpl-3.0.html>.
***********************************************************************/

	class renderer
	{
		function get_icon($category)
		{
			global  $path_to_root, $show_menu_category_icons;

			if ($show_menu_category_icons)
				$img = $category == '' ? 'right.gif' : $category.'.png';
			else	
				$img = 'right.gif';
			return "<img src='$path_to_root/themes/". user_theme()."/images/$img' style='vertical-align:middle;' border='0'>&nbsp;&nbsp;";
		}

		function wa_header()
		{
			page(_($help_context = "Main Menu"), false, true);
		}

		function wa_footer()
		{
			end_page(false, true);
		}

		function menu_header($title, $no_menu, $is_index)
		{
			global $path_to_root, $help_base_url, $db_connections;
			$img = "<img src='$path_to_root/themes/".user_theme()."/images/login.gif' width='14' height='14' border='0' alt='"._('Logout')."'>&nbsp;&nbsp;";
			$himg = "<img src='$path_to_root/themes/".user_theme()."/images/help.gif' width='14' height='14' border='0' alt='"._('Help')."'>&nbsp;&nbsp;";
				
			echo "<table class='callout_main' border='0' cellpadding='0' cellspacing='0'>\n";
						
			echo "<tr> <td colspan='2' style='padding: 0 0 0 0 ; '>" ;
				echo "<table class=logoutBar>";
				echo "<tr> <td  colspan='3' align='left'><a target='_blank' href='$power_url'><img src='$path_to_root/themes/". user_theme()."/images/logo_frontaccounting.png' alt='FrontAccounting' onload='fixPNG(this)' border='0' /></a> </td> </tr> ";

				echo "<tr><td class=headingtext3> <span style='font-size: 16px;' > " . $db_connections[$_SESSION["wa_current_user"]->company]["name"] . " </span>| " . $_SERVER['SERVER_NAME'] . " | Hi, Welcome !,  " . $_SESSION["wa_current_user"]->name . "</td>";
				$indicator = "$path_to_root/themes/".user_theme(). "/images/ajax-loader.gif";
				echo "<td class='logoutBarRight'><img id='ajaxmark' src='$indicator' align='center' style='visibility:hidden;'></td>";
				echo "  <td class='logoutBarRight'><a class='shortcut' href='$path_to_root/admin/display_prefs.php?'>" . _("Preferences") . "</a>&nbsp;&nbsp;&nbsp;\n";
				echo "  <a class='shortcut' href='$path_to_root/admin/change_current_user_password.php?selected_id=" . $_SESSION["wa_current_user"]->username . "'>" . _("Change password") . "</a>&nbsp;&nbsp;&nbsp;\n";

				if ($help_base_url != null)	{
					echo "$himg<a target = '_blank' onclick=" .'"'."javascript:openWindow(this.href,this.target); return false;".'" '. "href='". help_url()."'>" . _("Help") . "</a>&nbsp;&nbsp;&nbsp;";
				}
				echo "$img<a class='shortcut' href='$path_to_root/access/logout.php?'>" . _("Logout") . "</a>&nbsp;&nbsp;&nbsp;";
				//echo "</td></tr><tr><td colspan=3>";
				echo "</td></tr></table>";
				
				if (!$no_menu){
				$applications = $_SESSION['App']->applications;
				$local_path_to_root = $path_to_root;
				$sel_app = $_SESSION['sel_app'];
	
				
				//echo "<table cellpadding=0 cellspacing=0 width='100%'><tr><td >";
				echo "<div class=tabs>";
				foreach($applications as $app)
				{
                    if ($_SESSION["wa_current_user"]->check_application_access($app))
                    {
						$img_icon="<img src='$path_to_root/themes/".user_theme()."/images/".$app->id.".png' width='16' height='16' border='0' alt='"._($app->id)."'>&nbsp;&nbsp;";
                        $acc = access_string($app->name);
                        echo "<a class='".($sel_app == $app->id ? 'selected' : 'menu_tab')
                            ."' href='$local_path_to_root/index.php?application=".$app->id
                            ."'$acc[1]>" .$img_icon.$acc[0] . "</a>";
                    }
				}
				echo "</div>";
			//	echo "</td></tr></table>";

				// top status bar
				
			}
			
			echo " </td> </tr> " ; 
			echo "<tr>\n";
			echo "<td colspan='2' rowspan='2'>\n";

			//echo "<table class='main_page' border='0' cellpadding='0' cellspacing='0'>\n";
			//echo "<tr>\n";
			//echo "<td>\n";
			//echo "<table width='100%' border='0' cellpadding='0' cellspacing='0'>\n";
			//echo "<tr>\n";
			//echo "<td class='quick_menu'>\n"; // tabs
			
			//echo "</td></tr></table>";

			if ($no_menu)
				echo "<br>";
			elseif ($title && !$is_index)
			{
				echo "<center><table id='title'><tr><td width='100%' class='titletext'>$title</td>"
				."<td align=right>"
				.(user_hints() ? "<span id='hints'></span>" : '')
				."</td>"
				."</tr></table></center>";
			}
		}

		function menu_footer($no_menu, $is_index)
		{
			global $version, $allow_demo_mode, $app_title, $power_url, 
				$power_by, $path_to_root, $Pagehelp, $Ajax;
			include_once($path_to_root . "/includes/date_functions.inc");

			//echo "</td></tr></table>\n"; // 'main_page'
			
			echo "</td></tr> </table>\n"; // 'callout_main'
			echo "</table>\n";
			if ($no_menu == false)
			{
				echo "<table class='footer'>\n";
	echo "<tr>\n";
	echo "<td style='text-align: left; ' ><a target='_blank' href='$power_url' tabindex='-1'>$app_title $version  </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href='http://kvcodes.com/' target='blank'>" . _("Theme:") . " " . user_theme() . "</a>\n";
	//echo "</tr>\n";
	//echo "<tr>\n";
	//echo "<td><a target='_blank' href='$power_url' tabindex='-1'>$power_by</a>";

		//echo "<table class='bottomBar'>\n";
	//echo "<tr>";
	if (isset($_SESSION['wa_current_user'])) 
		$date = Today() . " | " . Now();
	else	
		$date = date("m/d/Y") . " | " . date("h.i am");
	echo "<span class='bottomBar'>$date</span>\n";
	//echo "</tr></table>\n";
	
	echo " </td>\n";
	echo "</tr>\n";
	echo "</table>\n";
			}
		}

		function display_applications(&$waapp)
		{
			global $path_to_root;

			$selected_app = $waapp->get_selected_application();
			if (!$_SESSION["wa_current_user"]->check_application_access($selected_app))
				return;

			if (method_exists($selected_app, 'render_index'))
			{
				$selected_app->render_index();
				return;
			}

			echo "<table width=100% cellpadding='0' cellspacing='0'>";
			foreach ($selected_app->modules as $module)
			{
        		if (!$_SESSION["wa_current_user"]->check_module_access($module))
        			continue;
				// image
				echo "<tr>";
				// values
				echo "<td valign='top' class='menu_group'>";
				echo "<table border=0 width='100%'>";
				echo "<tr><td colspan='2' id='menu_group' >";
				echo $module->name;
				echo "</td></tr><tr>";
				echo "<td class='menu_group_items'>";

				foreach ($module->lappfunctions as $appfunction)
				{
					$img = $this->get_icon($appfunction->category);
					if ($appfunction->label == "")
						echo "&nbsp;<br>";
					elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access)) 
					{
							echo $img.menu_link($appfunction->link, $appfunction->label)."<br>\n";
					}
					elseif (!$_SESSION["wa_current_user"]->hide_inaccessible_menu_items())
					{
							echo $img.'<span class="inactive">'
								.access_string($appfunction->label, true)
								."</span><br>\n";
					}
				}
				echo "</td>";
				if (sizeof($module->rappfunctions) > 0)
				{
					echo "<td width='50%' class='menu_group_items'>";
					foreach ($module->rappfunctions as $appfunction)
					{
						$img = $this->get_icon($appfunction->category);
						if ($appfunction->label == "")
							echo "&nbsp;<br>";
						elseif ($_SESSION["wa_current_user"]->can_access_page($appfunction->access)) 
						{
								echo $img.menu_link($appfunction->link, $appfunction->label)."<br>\n";
						}
						elseif (!$_SESSION["wa_current_user"]->hide_inaccessible_menu_items())
						{
								echo $img.'<span class="inactive">'
									.access_string($appfunction->label, true)
									."</span><br>\n";
						}
					}
					echo "</td>";
				}

				echo "</tr></table></td></tr>";
			}
			echo "</table>";
  	}
}
?>