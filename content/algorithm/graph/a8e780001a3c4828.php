<h1>Проверка пересечения двух прямоугольников (TRect)</h1>
<div class="date">01.01.2007</div>


<pre>
 
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Проверка пересечения двух прямоугольников (TRect)
 
Функция использовалась для проверки пересекаемости 2-х форм, панелей и т.п. Причем пересекаться они могут и не углами, а, например, находиться один полностью в другом.
 
Зависимости: нет
Автор:       MikeZ, Zhuravsky2@Yandex.ru, Kiev
Copyright:   MikeZ (C) 2003
Дата:        8 октября 2003 г.
********************************************** }
 
Function OverlapRects(R1, R2: TRect): Boolean;
Var
  Temp : TRect;
Begin
  Result := False;
  If Not UnionRect(Temp, R1, R2) Then Exit;
  If (Temp.Right - Temp.Left &lt;= R1.Right - R1.Left + R2.Right - R2.Left) And
    (Temp.Bottom - Temp.Top &lt;= R1.Bottom - R1.Top + R2.Bottom - R2.Top) Then
    Result := True;
End;
</pre>

