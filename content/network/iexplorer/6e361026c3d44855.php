<h1>Как обновить все окна IE?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
 MSHTML_TLB, SHDocVw_TLB;
 
procedure TForm1.Button1Click(Sender: TObject);
var
 ShellWindow: IShellWindows;
 WB: IWebbrowser2;
 spDisp: IDispatch;
 IDoc1: IHTMLDocument2;
 k: Integer;
begin
 ShellWindow := CoShellWindows.Create;
 for k := 0 to ShellWindow.Count do
 begin
   spDisp := ShellWindow.Item(k);
   if spDisp = nil then Continue;
   spDisp.QueryInterface(iWebBrowser2, WB);
   if WB &lt;&gt; nil then
   begin
     WB.Document.QueryInterface(IHTMLDocument2, iDoc1);
     if iDoc1 &lt;&gt; nil then
     begin
       WB := ShellWindow.Item(k) as IWebbrowser2;
       WB.Refresh;
     end;
   end;
 end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
