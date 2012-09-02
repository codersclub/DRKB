<h1>Проверить, есть ли значение в таблице</h1>
<div class="date">01.01.2007</div>


<pre>
If Exists (Select * From MyTable Where Field1=1)
  Begin
     Update MyTable
     Set Field2=666
     Where Field1=1
  End
Else
  Begin
     Insert into MyTable (Field1, Field2)
     Values (1, 666)
  End
</pre>

Соответственно отсутствие значения проверяется:</p>
<pre>
If not Exists (Select * From MyTable Where Field1=1)
  Begin
     Insert into MyTable (Field1, Field2)
     Values (1, 666)
  End
Else
  Begin
     Update MyTable
     Set Field2=666
     Where Field1=1
  End 
</pre>

<p class="author">Автор: Vit</p>

