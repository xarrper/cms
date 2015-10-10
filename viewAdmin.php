<html>
<head>
<!--style>
.div_block { text-align: center;	 display:inline-block; cursor: pointer; padding-top: 10px; padding-bottom: 10px; width:25%; float:left;}
</style-->
</head>
<body>

<h1>Панель Администрирования</h1>

<div style='display: inline-block; width: 25%; float: left;'>
<?=$data['menu'];?>
</div>
<div style='display: inline-block; width: 50%; float: left;'>

<form name="test" method="post" action="admin.php?action=act&section=<?=$data['id'];?>">
  <table>
  <tr>
  <td>  
	<p><b>Название раздела</b><br>
	<input type="text" size="40" value="<?=$data['name'];?>">
	</p>
  </td>
  <td>  
	<p><b>Родитель раздела</b><br>
	<input type="text" size="10" value="<?=$data['parent_id'];?>">
	</p>
  </td>
  <tr>
  </table>
  <p><b>Содержание раздела</b><Br>
   <textarea name="comment" cols="40" rows="3"><?=$data['text'];?></textarea></p>
  <p><input type="submit" name="edit" value="Изменить">
   <input type="submit" name="delete" value="Удалить"></p>
 </form>
 
</div>
<div style='width:100%; height:1px; clear:both;'></div>
</body>
</html>

