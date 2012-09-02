<h1>Копирование потока компонент в буфер обмена</h1>
<div class="date">01.01.2007</div>


<pre>
{ 
  Clipboard has  methods  GetComponent and SetComponent but we need 
  to stream multiple components to the clipboard to include copy paste type 
  of feature. 
 
}
 
 
 procedure CopyStreamToClipboard(fmt: Cardinal; S: TStream);
 var
   hMem: THandle;
   pMem: Pointer;
 begin
   S.Position := 0;
   hMem       := GlobalAlloc(GHND or GMEM_DDESHARE, S.Size);
   if hMem &lt;&gt; 0 then
    begin
     pMem := GlobalLock(hMem);
     if pMem &lt;&gt; nil then
      begin
       S.Read(pMem^, S.Size);
       S.Position := 0;
       GlobalUnlock(hMem);
       Clipboard.Open;
       try
         Clipboard.SetAsHandle(fmt, hMem);
       finally
         Clipboard.Close;
       end;
     end { If }
     else
      begin
       GlobalFree(hMem);
       OutOfMemoryError;
     end;
   end { If }
   else
     OutOfMemoryError;
 end; { CopyStreamToClipboard }
</pre>

<pre>
 procedure CopyStreamFromClipboard(fmt: Cardinal; S: TStream);
 var
   hMem: THandle;
   pMem: Pointer;
 begin
   hMem := Clipboard.GetAsHandle(fmt);
   if hMem &lt;&gt; 0 then
    begin
     pMem := GlobalLock(hMem);
     if pMem &lt;&gt; nil then
      begin
       S.Write(pMem^, GlobalSize(hMem));
       S.Position := 0;
       GlobalUnlock(hMem);
     end { If }
     else
       raise Exception.Create('CopyStreamFromClipboard: could not lock global handle ' +
         'obtained from clipboard!');
   end; { If }
 end; { CopyStreamFromClipboard }
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>

