<h1>Получение текста из буфера обмена без использования модуля Clipbrd</h1>
<div class="date">01.01.2007</div>


<pre>
{ **** UBPFD *********** by kladovka.net.ru ****
&gt;&gt; Получение текста из буфера обмена без использования модуля Clipbrd
 
Wnd - Handle окна, получающего доступ к буферу обмена;
Str - строка, в которую будет скопирован текст;
 
Зависимости: Windows
Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
Copyright:   Dimka Maslov
Дата:        22 августа 2002 г.
********************************************** }
 
function GetClipboardText(Wnd: HWND; var Str: string): Boolean;
var
 hData: HGlobal;
begin
 Result:=True;
 if OpenClipboard(Wnd) then begin
  try
   hData:=GetClipboardData(CF_TEXT);
   if hData&lt;&gt;0 then begin
    try
     SetString(Str, PChar(GlobalLock(hData)), GlobalSize(hData));
    finally
     GlobalUnlock(hData);
    end;
   end else Result:=False;
   Str:=PChar(@Str[1]);
  finally
   CloseClipboard;
  end;
 end else Result:=False;
end; 
</pre>

<p> Пример использования:</p>
<pre>
function TForm1.Button2Click(Sender: TObject)
var
 Str: string;
begin 
 GetClipboardText(Handle, Str);
 ShowMessage(Str);
end; 
</pre>

