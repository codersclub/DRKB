<h1>Использование case</h1>
<div class="date">01.01.2007</div>


<p>Оператор выбора Case работает немного по другому чем в классических языках. В классических языках Case выбирает какой оператор запускать, а в T-SQL он выбирает выражение которое надо использовать для вычисления чего-то. Case выступает в ввиде функции которая возвращает результат в зависимости от условия. Имеет 2 формы написания:</p>
<p>1.</p>
<pre>
Declare @m int

Set @m=Month(GetDate())
 
Select
  @m as MonthNumber, 
  Case @m
    When  1 Then 'Январь'
    When  2 Then 'Февраль'
    When 12 Then 'Декабрь'
    Else 'Не зима'
  End as MonthName
</pre>

<p> 2.</p>
<pre>
Declare @m int

Set @m=Month(GetDate())
 
Select
  @m as MonthNumber, 
  Case 
    When @m=1 Then 'Январь'
    When @m=2 Then 'Февраль'
    When @m=12 Then 'Декабрь'
    When @m is Null Then 'Неизвестно'
    Else 'Не зима'
  End as MonthName
</pre>

<p>Можно использовать Case для присвоения</p>

<pre>
Set @MyVar=
  Case  
    When @m=1 Then 'Январь'
    When @m=2 Then 'Февраль'
    When @m=12 Then 'Декабрь'
    When @m is Null Then 'Неизвестно'
    Else 'Не зима'
  End
</pre>

<p>Можно использовать в операциях сравнения, сортировки, группировки и функциях:</p>

<pre>
Select 
  dbo.MyFunction( 
    Case  
      When @m=1 Then 'Январь'
      When @m=2 Then 'Февраль'
      When @m=12 Then 'Декабрь'
      When @m is Null Then 'Неизвестно'
      Else 'Не зима'
    End),
  Case When MyField=0 Then 'False' else 'True' End,
  Count(*) 
From MyTable
Where Case When MyField1=0 Then Field2 else Field3 End&gt;1
Group by Case When MyField=0 Then 'False' else 'True' End
Order By Case When MyField=0 Then 'False' else 'True' End 
</pre>

<div class="author">Автор: Vit</div>

