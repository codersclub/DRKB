<h1>Ошибка создания дескриптора курсора</h1>
<div class="date">01.01.2007</div>


<p>Вы должны использовать ExecSql вместо Open. К примеру, если имя вашего запроса UpdateStudent, то при необходимости обновления STUDENT.DB вы должны использовать следующий код:</p>

<pre>
Begin
.....
UpdateStudent.ExecSql;
.....
End;
</pre>

<p>Ваш запрос является Passtrough-запросом, который не может возвратить установленный результат, так что это не может быть открыто, а должно быть 'ВЫПОЛНЕНО'.</p>
<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
