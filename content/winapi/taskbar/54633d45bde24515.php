<h1>Получение информации о TaskBar</h1>
<div class="date">01.01.2007</div>


<p>Для вывода информации мы будет использовать компонент TStringGrid с закладки Additional. </p>
<p>Сначала вам нужно будет после </p>
<pre>
var
  Form1: TForm1;
</pre>

<p>добавить следующий код: </p>
<pre>
AppBarData : TAppBarData;
bAlwaysOnTop, bAutoHide : boolean;
Clrect,rect : TRect;
Edge: UInt;
</pre>

<p>затем после слова Implementation пишем </p>
<pre>
procedure DetectTaskBar;
begin
  AppBarData.hWnd := FindWindow('Shell_TrayWnd', nil);
  AppBarData.cbSize := sizeof(AppBarData);
  bAlwaysOnTop := (SHAppBarMessage(ABM_GETSTATE, AppBardata)
  and ABS_ALWAYSONTOP) &lt;&gt; 0;
  bAutoHide := (SHAppBarMessage(ABM_GETSTATE, AppBardata)
  and ABS_AUTOHIDE) &lt;&gt; 0;
  GetClientRect(AppBarData.hWnd, Clrect);
  GetWindowRect(AppBarData.hwnd, rect);
  if rect.top &gt; 0 then
    Edge := ABE_BOTTOM
  else
  if rect.bottom &lt; screen.height then
    Edge:=ABE_TOP
  else
  if rect.right &lt; screen.width then
    Edge:=ABE_LEFT
  else
    Edge:=ABE_RIGHT;
end;
</pre>
<p>и осталось описать самое главное - обработчик нажатия кнопки: </p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
  DetectTaskBar;
 
  StringGrid1.Cells[0,0] := 'Выше других окон';
  StringGrid1.Cells[0,1] := 'Автоматически убирать с экрана';
  StringGrid1.Cells[0,2] := 'Клиентская область';
  StringGrid1.Cells[0,3] := 'Оконная область';
  StringGrid1.Cells[0,4] := 'Края';
 
  if bAlwaysOnTop = true then
    StringGrid1.Cells[1,0] := 'true'
  else
    StringGrid1.Cells[1,0] := 'false';
 
  if bAutoHide = true then
    StringGrid1.Cells[1,1] := 'true'
  else
    StringGrid1.Cells[1,1] := 'false';
 
  StringGrid1.Cells[1,2] := IntToStr(Clrect.Left)+':'+IntToStr(Clrect.Top) +
  ':'+IntToStr(Clrect.Right)+':'+IntToStr(Clrect.Bottom);
 
  StringGrid1.Cells[1,3] := IntToStr(rect.Left)+':'+IntToStr(rect.Top) +
  ':'+IntToStr(rect.Right)+':'+IntToStr(rect.Bottom);
 
  StringGrid1.Cells[1,4] := IntToStr(Edge);
end;
</pre>


<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>
