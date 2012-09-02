<h1>Получить заголовок элемента управления под мышкой</h1>
<div class="date">01.01.2007</div>


<pre>
function GetCaptionAtPoint(CrPos: TPoint): string;
 var
   textlength: Integer;
   Text: PChar;
   Handle: HWND;
 begin
   Result := 'Empty';
   Handle := WindowFromPoint(CrPos);
   if Handle = 0 then Exit;
   textlength := SendMessage(Handle, WM_GETTEXTLENGTH, 0, 0);
   if textlength &lt;&gt; 0 then
   begin
     getmem(Text, textlength + 1);
     SendMessage(Handle, WM_GETTEXT, textlength + 1, Integer(Text));
     Result := Text;
     freemem(Text);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
