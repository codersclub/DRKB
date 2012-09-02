<h1>Как изменить положение таблицы на листе (подвинуть влево, вправо, вверх, вниз)?</h1>
<div class="date">01.01.2007</div>

<p>Координаты таблицы можно изменить, но эти изменения ограничены по своим возможностям:</p>
<div style="text-align: justify; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>две таблицы нельзя выстроить на странице в одну линию, их можно разместить как строки: вторая таблица идет на следующей строке после первой; </td></tr></table></div><div style="text-align: left; text-indent: 0px; padding: 0px 0px 0px 0px; margin: 7px 0px 7px 24px;"><table border="0" cellpadding="0" cellspacing="0" style="line-height: normal;"><tr ><td width="24">1.</td><td>есть возможность менять только левый отступ таблицы от края листа. Вертикальное положение определяется строкой, на которой создается таблица. Поэтому чтобы изменить вертикальное положение таблицы, необходимо добавить или удалить строки, расположенные выше таблицы. Левый отступ определяется значением, записанным в поле LeftIndent коллекции Rows таблицы:<br>
W.ActiveDocument.Tables.Item (tab_).Rows.LeftIndent=Left;<br>
<p>где Tab_ - номер таблицы, Left - левый отступ таблицы. </td></tr></table></div>
