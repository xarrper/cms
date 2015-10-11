<?php include "view/header.php" ?>
<?php include "view/menu.php" ?>

	<a href="/admin.php?section=<?=$data['idAct'];?>"><?=$data['nameAct'];?></a><br>
	<a href="/admin.php?action=exit">Выход</a>
	</div>
	</div>
		<div style='display: inline-block; width: 50%; float: left;'>
		<form name="test" method="post" action="admin.php?action=act&section=<?=$data['id'];?>" class="paddingMenu">
			<table>
				<tr>
					<td>  
						<h2 class="sizeMedium">Название раздела<br>
						<input type="text" name="name" size="40" value="<?=$data['name'];?>">
						</h2>
					</td>
					<td>  
						<h2 class="sizeMedium">Родитель раздела<br>
						<input type="text" name="parent_id" size="10" value="<?=$data['parent_id'];?>">
						</h2>
					</td>
				<tr>
			</table>
			<h2 class="sizeMedium">Содержание раздела<Br>
			<textarea name="text" cols="40" rows="3"><?=$data['text'];?></textarea></p>
			</h2>
			<input type="submit" name="<?=$data['nameB'];?>" value="<?=$data['valueB'];?>">
			<?=$data['buttonDelet'];?>
		</form>
	</div>
	<div class="divClear"></div>
</body>
</html>

