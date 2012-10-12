<h1>Как прочитать пароль, скрытый за звездочками?</h1>
<div class="date">01.01.2007</div>


<p>Наверно так: хотя классов может быть больше</p>
<pre>
procedure TForm1.Timer1Timer(Sender: TObject);

 
var
Wnd : HWND;
lpClassName: array [0..$FF] of Char;
begin
Wnd := WindowFromPoint(Mouse.CursorPos);
GetClassName (Wnd, lpClassName, $FF);
if ((strpas(lpClassName) = 'TEdit') or (strpas(lpClassName) = 'EDIT')) then
PostMessage (Wnd, EM_SETPASSWORDCHAR, 0, 0);
end; 
</pre>

<p class="author">Автор: Baa</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>

<hr>
<p>Здесь проблема: если страница памяти защищена, то её нельзя прочитать таким способом, но можно заменить PasswordChar(пример: поле ввода пароля в удаленном соединении) </p>
<p class="author">Автор: Mikel</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
