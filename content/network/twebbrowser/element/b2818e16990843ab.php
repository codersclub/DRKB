<h1>Использоватние  Drag &amp; Drop для заполнения полей в TWebBrowser?</h1>
<div class="date">01.01.2007</div>


<pre>
  This example shows how to fill out fields in your webbrowser by 
  dragging the content of Label1 to a field of your webbrowser} 
 
procedure TForm1.FormCreate(Sender: TObject); 
begin 
  label1.DragMode := dmAutomatic; 
end; 
 
 
procedure TForm1.WebBrowserDragOver(Sender, Source: TObject; X, 
  Y: Integer; State: TDragState; var Accept: Boolean); 
var 
  item: Variant; 
begin 
  //check if document is interactive 
  if (Webbrowser.ReadyState and READYSTATE_INTERACTIVE) = 3 then 
  begin 
    item := WebBrowser.OleObject.Document.elementFromPoint(x, y); 
    if Source is TLabel then 
      Accept := True; 
    Accept := (item.tagname = 'INPUT') and ((item.type = 'text') or 
      (item.type = 'password')) or (item.tagname = 'TEXTAREA'); 
  end; 
end; 
 
procedure TForm1.WebBrowserDragDrop(Sender, Source: TObject; X, 
  Y: Integer); 
var 
  item: Variant; 
begin 
  //check if document is interactive 
  if (Webbrowser.ReadyState and READYSTATE_INTERACTIVE) = 3 then 
  begin 
    item       := WebBrowser.OleObject.Document.elementFromPoint(x, y); 
    item.Value := label1.Caption; 
  end; 
end; 
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
