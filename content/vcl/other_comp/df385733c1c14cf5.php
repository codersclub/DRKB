<h1>Как удалить сегодняшнюю дату из TDateTimePicker?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  CommCtrl;
 
procedure TForm1.DateTimePicker1DropDown(Sender: TObject);
var
  wnd: HWND;
  Style: Integer;
begin
  wnd := DateTime_GetMonthCal(DateTimePicker1.Handle);
  if wnd &lt;&gt; 0 then
  begin
    Style := GetWindowLong(wnd, GWL_STYLE);
    SetWindowLong(wnd, GWL_STYLE, Style or MCS_NOTODAY or MCS_NOTODAYCIRCLE);
  end;
end;
 
{
  The calendar will still highlite the current day but the circle and the
  today display at the bottom are gone.
}
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
