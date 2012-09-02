<h1>Как конвертировать виртуальную клавишу в ASCII-код?</h1>
<div class="date">01.01.2007</div>


<p>Получаем символ, соответствующий виртуальной клавише:</p>
<pre>
function GetCharFromVKey(vkey: Word): string;
var
  keystate: TKeyboardState;
  retcode: Integer;
begin
  Win32Check(GetKeyboardState(keystate));
  SetLength(Result, 2);
  retcode := ToAscii(vkey,
    MapVirtualKey(vkey, 0),
    keystate, @Result[1],
    0);
  case retcode of
    0: Result := '';
    1: SetLength(Result, 1);
    2: ;
    else
      Result := '';
  end;
end;
 
{
Использование:
procedure TForm1.Edit1KeyDown
  (Sender: TObject; var Key: Word;
  Shift: TShiftState);
begin
  ShowMessage(GetCharFromVKey(Key));
end; 
}
</pre>

<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

