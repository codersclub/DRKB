<h1>Предотвратить изменение ширины колонки для TListView</h1>
<div class="date">01.01.2007</div>


<pre>
private
   FListViewOldWndProc: TWndMethod;
   procedure ListViewNewWndProc(var Msg: TMessage);
 end;
 
 {....}
 
 implementation
 
 uses
   CommCtrl;
 
 
 procedure TForm1.FormCreate(Sender: TObject);
 begin
   //Sichern der ursprunglichen WindowProc der Listview 
  FListViewOldWndProc := ListView1.WindowProc;
 
   //Subclassing: Umleiten der WindowProc auf unsere eigene Procedur 
  Listview1.WindowProc := ListViewNewWndProc;
 end;
 
 procedure TForm1.ListViewNewWndProc(var Msg: TMessage);
 var
   hdn: ^THDNotify;
 begin
   if Msg.Msg = WM_NOTIFY then
   begin
     hdn := Pointer(Msg.lParam);
     //Abfangen und loschen der HDN_BeginTrack Botschaft 
    if (hdn.hdr.code = HDN_BeginTrackW) or (hdn.hdr.code = HDN_BeginTrackA) then
       Msg.Result := 1
     else
       FListViewOldWndProc(Msg);
   end
   // ansonsten Botschaft an die ursprungliche WindowProc weiterreichen 
  else
      FListViewOldWndProc(Msg);
 end;
 
 procedure TForm1.FormDestroy(Sender: TObject);
 begin
   //vor dem Beenden Original WindowProc wiederherstellen 
  ListView1.WindowProc := FlistViewOldWndProc;
   FListViewOldWndProc  := nil;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
