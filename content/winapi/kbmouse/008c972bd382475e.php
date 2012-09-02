<h1>Програмное выключение клавиатуры и мыши</h1>
<div class="date">01.01.2007</div>


<pre>
winexec(Pchar('rundll32 keyboard,disable' ) ,sw_Show); Клава OFF 
winexec(Pchar('rundll32 mouse,disable' ) ,sw_Show); Маус OFF 
</pre>
<p>кстати а вот так клава врубается</p>
<p>Отрубить</p>
<pre>
Asm 
  in al,21h
  or al,00000010b
  out 21h,al
End;
</pre>
<p>Врубить</p>
<pre>
Asm 
  in al,21h
  mov al,0
  out 21h,al
End;
</pre>

<p class="author">Автор: Radmin</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>BlockInput(), живёт в user32.dll </p>
<p class="author">Автор: Song</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr />
<p>Как скрыть курсор мышки</p>
<p>Поместите в событие OnClick в button1 и button2 следующие коды.Если курсор мышки скрыт, то выбрать button2 можно клавишей Tab.</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  ShowCursor(False);
end;
 
procedure TForm1.Button2Click(Sender: TObject);
begin
  ShowCursor(True);
end;
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
<hr />
<pre>
//Выключение курсора
procedure TForm1.Button1Click(Sender: TObject);
var
  CState: Integer;
begin
  CState := ShowCursor(True);
  while Cstate &gt;= 0 do
    Cstate := ShowCursor(False);
end;
 
//Включение курсора
procedure TForm1.Button2Click(Sender: TObject);
var
  Cstate: Integer;
begin
  Cstate := ShowCursor(True);
  while CState &lt; 0 do
    CState := ShowCursor(True);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
