<?php
$rezultatas=0;
if(isset($_POST['Skaicius'])) $infolaukas=$_POST['Skaicius'];
else $infolaukas='1 skaicius';
if(isset($_POST['Veiksmas'])) $infolaukas2=$_POST['Veiksmas'];
else $infolaukas2='Zenklas';
if(isset($_POST['Skaicius2'])) $infolaukas3=$_POST['Skaicius2'];
else $infolaukas3='2 skaicius';
echo '
<form name="calc" method="POST" action="skaiciuotuvas.php">
<input name="Skaicius" onFocus="if(this.value ==\''.$infolaukas.'\' ) this.value=\'\'" onBlur="if(this.value==\'\') this.value=\''.$infolaukas.'\'" value="'.$infolaukas.'" type="text"><br />
<input name="Veiksmas" onFocus="if(this.value ==\''.$infolaukas2.'\' ) this.value=\'\'" onBlur="if(this.value==\'\') this.value=\''.$infolaukas2.'\'" value="'.$infolaukas2.'" type="text"><br />
<input name="Jau"  value="skaiciuojam" type="hidden">
<input name="Skaicius2" onFocus="if(this.value ==\''.$infolaukas3.'\' ) this.value=\'\'" onBlur="if(this.value==\'\') this.value=\''.$infolaukas3.'\'" value="'.$infolaukas3.'" type="text"><br />
<input name="login" type="submit" value="Skaiciuoti"/>
</form>
<br>';
$veiksmai = array("*", "+", "-", "/");
if(!isset($_POST['Jau'])) return 1; 
if($_POST['Skaicius']!='' && $_POST['Skaicius']!='1 skaicius' && $_POST['Skaicius2']!='' && $_POST['Skaicius2']!='2 skaicius' && $_POST['Veiksmas']!='' && $_POST['Veiksmas']!='Zenklas')
{
	if(is_numeric($_POST['Skaicius']))
	{
		if(is_numeric($_POST['Skaicius2']))
		{
			if(in_array($_POST['Veiksmas'], $veiksmai))
			{
				if($_POST['Veiksmas']=='*'){ $rezultatas=$_POST['Skaicius']*$_POST['Skaicius2'];}
				if($_POST['Veiksmas']=='+'){ $rezultatas=$_POST['Skaicius']+$_POST['Skaicius2'];}
				if($_POST['Veiksmas']=='-'){ $rezultatas=$_POST['Skaicius']-$_POST['Skaicius2'];}
				if($_POST['Veiksmas']=='/'){ $rezultatas=$_POST['Skaicius']/$_POST['Skaicius2'];}
			}
			else
			{
				echo '<font color="red">Tokio veiksmo šis skaičiuotuvas neatlieka!</font><br />';
			}
		}
		else if(!is_numeric($_POST['Skaicius2']))
  		{
			echo '<font color="red">Klaidingas 2 skaičius</font><br />';
			return 1; 
		}
	}
	else if(!is_numeric($_POST['Skaicius']))
	{
		echo '<font color="red">Klaidingas 1 skaičius</font><br />';
	}
}
else
{
	echo '<font color="red">Kažko neįvedėte</font><br />';
	return 1; 
}
echo 'Rezultatas: <div id="gskaicius">'.$rezultatas.'</div>';
?>