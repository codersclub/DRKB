<h1>Следование за мышкой в TMemo для установки позиции курсора</h1>
<div class="date">01.01.2007</div>


<pre>
procedure TForm1.Memo1MouseMove(Sender: TObject; Shift: TShiftState; X,
   Y: Integer);
 begin
   Memo1.SelStart  := LoWord(SendMessage(Memo1.Handle, EM_CHARFROMPOS, 0, MakeLParam(X, Y)));
   Memo1.SelLength := 0;
 end;
</pre>
<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
