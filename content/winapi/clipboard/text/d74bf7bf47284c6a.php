<h1>Как скопировать содержимое строки в буфер обмена?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure CopyStringToClipboard(s: string);
var
  hg: THandle;
  P: PChar;
begin
  hg:=GlobalAlloc(GMEM_DDESHARE or GMEM_MOVEABLE, Length(S)+1);
  P:=GlobalLock(hg);
  StrPCopy(P, s);
  GlobalUnlock(hg);
  OpenClipboard(Application.Handle);
  SetClipboardData(CF_TEXT, hg);
  CloseClipboard;
  GlobalFree(hg);
end;
</pre>

<p>Взято с <a href="https://delphiworld.narod.ru" target="_blank">https://delphiworld.narod.ru</a></p>

<hr />
<pre>
uses 
  ClipBrd; 
 
procedure StrToClipbrd(StrValue: string); 
var 
  S: string; 
  hMem: THandle; 
  pMem: PChar; 
begin 
  hMem := GlobalAlloc(GHND or GMEM_SHARE, Length(StrValue) + 1); 
  if hMem &lt;&gt; 0 then 
  begin 
    pMem := GlobalLock(hMem); 
    if pMem &lt;&gt; nil then 
    begin 
      StrPCopy(pMem, StrValue); 
      GlobalUnlock(hMem); 
      if OpenClipboard(0) then 
      begin 
        EmptyClipboard; 
        SetClipboardData(CF_TEXT, hMem); 
        CloseClipboard; 
      end 
      else 
        GlobalFree(hMem); 
    end 
    else 
      GlobalFree(hMem); 
  end; 
end; 
 
function GetStrFromClipbrd: string; 
begin 
  if Clipboard.HasFormat(CF_TEXT) then 
    Result := Clipboard.AsText 
  else 
  begin 
    ShowMessage('There is no text in the Clipboard!'); 
    Result := ''; 
  end; 
end; 
 
 
// write "Hallo" to the clipboard and read it back. 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  StrToClipbrd('Hallo'); 
  ShowMessage(GetStrFromClipbrd); 
end;
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
