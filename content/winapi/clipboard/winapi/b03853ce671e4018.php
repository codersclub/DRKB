<h1>Добавление текста в буфер обмена без использования модуля Clipbrd</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Добавление текста в буфер обмена без использования модуля Clipbrd
 
Wnd - Handle окна, получающего доступ к буферу обмена, может быть Application.Handle или Form.Handle
Value - текст, помещаемый в буфер обмена
 
Зависимости: Windows
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        22 августа 2002 г.
********************************************** }
 
function SetClipboardText(Wnd: HWND; Value: string): Boolean;
var
 hData: HGlobal;
 pData: pointer;
 Len: integer;
begin
 Result:=True;
 if OpenClipboard(Wnd) then begin
  try
   Len:=Length(Value)+1;
   hData:=GlobalAlloc(GMEM_MOVEABLE or GMEM_DDESHARE, Len);
   try
    pData:=GlobalLock(hData);
    try
     Move(PChar(Value)^, pData^, Len);
     EmptyClipboard;
     SetClipboardData(CF_Text, hData);
    finally
     GlobalUnlock(hData);
    end;
   except
    GlobalFree(hData);
    raise
   end;
  finally
   CloseClipboard;
  end;
 end else Result:=False;
end; 
</pre>

<p> Пример использования:</p>
<pre>
procedure TForm1.Button1Click(Sender: TObject);
begin
 SetClipboardText(Handle, 'qwerty');
end; 
</pre>

