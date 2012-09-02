<h1>Как прочитать выделенный текст из IE?</h1>
<div class="date">01.01.2007</div>


<pre>
uses
  SHDocVw_TLB; // http://www.euromind.com/iedelphi if don't have that unit
 
function GetSelectedIEtext: string;
var
  x: Integer;
  Sw: IShellWindows;
  IE: HWND;
begin
  IE := FindWindow('IEFrame', nil);
  sw := CoShellWindows.Create;
  for x := SW.Count - 1 downto 0 do
    if (Sw.Item(x) as IWebbrowser2).hwnd = IE then begin
      Result := variant(Sw.Item(x)).Document.Selection.createRange.Text;
      break;
    end;
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
