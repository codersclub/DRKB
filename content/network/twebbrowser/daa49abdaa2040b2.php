<h1>Найти и выделить текст в TWebBrowser</h1>
<div class="date">01.01.2007</div>


<pre>
{....} 
 
  private 
    procedure SearchAndHighlightText(aText: string); 
 
{....} 
 
procedure TForm1.SearchAndHighlightText(aText: string); 
var 
  i: Integer; 
begin 
  for i := 0 to WebBrowser1.OleObject.Document.All.Length - 1 do 
  begin 
    if Pos(aText, WebBrowser1.OleObject.Document.All.Item(i).InnerText) &lt;&gt; 0 then 
    begin 
      WebBrowser1.OleObject.Document.All.Item(i).Style.Color := '#FFFF00'; 
      WebBrowser1.OleObject.Document.All.Item(i).ScrollIntoView(True); 
    end; 
  end; 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  SearchAndHighlightText('some text...'); 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
