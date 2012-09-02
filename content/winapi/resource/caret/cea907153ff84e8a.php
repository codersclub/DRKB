<h1>Найти позицию каретки</h1>
<div class="date">01.01.2007</div>


<pre>
function GetCaretPosition(var APoint: TPoint): Boolean;
 var w: HWND;
   aID, mID: DWORD;
 begin
   Result:= False;
   w:= GetForegroundWindow;
   if w &lt;&gt; 0 then
   begin
     aID:= GetWindowThreadProcessId(w, nil);
     mID:= GetCurrentThreadid;
     if aID &lt;&gt; mID then
     begin
       if AttachThreadInput(mID, aID, True) then
       begin
         w:= GetFocus;
         if w &lt;&gt; 0 then
         begin
           Result:= GetCaretPos(APoint);
           Windows.ClientToScreen(w, APoint);
         end;
         AttachThreadInput(mID, aID, False);
       end;
     end;
   end;
 end;
 
 
 //Small demo: set cursor to active caret position 
procedure TForm1.Timer1Timer(Sender: TObject);
 var
   Pt: TPoint;
 begin
   if GetCaretPosition(Pt) then
   begin
     ListBox1.Items.Add(Format('Caret position is %d %d', [Pt.x, Pt.y]));
     SetCursorPos(Pt.X, Pt.Y);
   end;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
