<h1>Как вставить свой курсор из внешнего файла?</h1>
<div class="date">01.01.2007</div>


<p>Используя процедуру LoadCursorFromFile</p>
<pre>
var
  h: hcursor;
begin
  h := LoadCursorFromFile('D:\mc.cur');
  Screen.Cursors[1] := h;
  Form1.Cursor := 1;
end;
</pre>

<hr />
<pre>
var h: THandle;
begin
  h := LoadImage(0, 'c:\Cursor.cur', IMAGE_CURSOR, 0, 0, LR_DEFAULTSIZE or
    LR_LOADFROMFILE);
  if h = 0 then
    ShowMessage('Cursor not loaded!!!')
  else
    begin
      Screen.Cursors[1] := h;
      Form1.Cursor := 1;
    end;
end;
</pre>

<hr />Этот пример позволяет также использовать анимированные курсоры (*.ani)!</p>

<p>Вот кусок кода для загрузки анимированного курсора, который можно вставить в обработку события активизации формы :</p>
<pre>
var
  h: THandle;
  name: array[0..255] of char;
begin
  StrPCopy(name, 'Animcurs.ani');
  h := LoadImage(0, name, IMAGE_CURSOR, 0, 0, LR_DEFAULTSIZE or
    LR_LOADFROMFILE);
  if h &lt;&gt; 0 then
    begin
      Screen.Cursors[1] := h;
      Screen.Cursor := 1;
    end
  else
    Screen.Cursor := crDefault;
end;
</pre>


<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
