<h1>Как определить координаты курсора мыши?</h1>
<div class="date">01.01.2007</div>


<p>GetCursorPos()</p>
<div class="author">Автор: Spawn</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Обрабатывай событие OnMouseMove. Координаты курсора можно получить следующим путем:</p>
<pre>
procedure TForm1.FormMouseMove(Sender: TObject; Shift: TShiftState; X, Y: Integer);
begin

 
   if (X &gt;= 40 or X &lt;= 234) and (Y &gt;= 60 or Y &lt;=258) then {здесь запуск твоей функции};
end;
</pre>

<div class="author">Автор: Pegas</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<pre>

  mouse.CursorPos.x
  mouse.CursorPos.y
</pre>

<div class="author">Автор: Vit</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Для этого можно воспользоваться API функцией GetCursorPos. Передав в эту функцию TPoint, мы получим текущие координаты курсора. Следующий код показывает, как получить значения координат курсора по нажатию кнопки.</p>
<pre>
procedure Form1.Button1Click(Sender: TObject);
var
  foo: TPoint;
begin
  GetCursorPos(foo)
  ShowMessage( '(' + IntToStr(foo.X) + ' ,' + IntToStr( foo.Y ) + ')' );
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<p>Для этого можно воспользоваться API функцией GetCursorPos. Передав в эту функцию TPoint, мы получим текущие координаты курсора. Следующий код показывает, как получить значения координат курсора по нажатию кнопки.</p>
<pre>
 
procedure Form1.Button1Click(Sender: TObject);
var
  foo: TPoint;
begin
  GetCursorPos(foo);
  ShowMessage('(' + IntToStr(foo.X) + ' ,' + IntToStr(foo.Y) + ')');
end;
</pre>

<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

