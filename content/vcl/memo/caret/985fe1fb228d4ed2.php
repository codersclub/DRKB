<h1>Как получить координаты курсора в memo-поле?</h1>
<div class="date">01.01.2007</div>



<pre>
procedure CaretPos(H: THandle; var L,C : Word); 
begin 
  L := SendMessage(H,EM_LINEFROMCHAR,-1,0); 
  C := LoWord(SendMessage(H,EM_GETSEL,0,0)) - SendMessage(H,EM_LINEINDEX,-1,0); 
end; 
 
procedure TForm1.Button1Click(Sender: TObject); 
var 
  LineNum,ColNum : Word; 
begin 
  CaretPos(Memo1.Handle,LineNum,ColNum); 
  Edit1.Text := IntToStr(LineNum) + '  ' + IntToStr(ColNum); 
end;
</pre>


<p>Хотя в Delphi 5 свойство CaretPos уже включено в memo.</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>


<hr />Как получить номер строки memo, в которой находится курсор?</p>

<p>Для этого необходимо послать сообщение EM_LINEFROMCHAR.</p>

<p>LineNumber :=&nbsp;&nbsp; Memo1.Perform(EM_LINEFROMCHAR, -1, 0);</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

<hr />
<pre>
var
  X, Y: LongInt;
begin
  Y := Memo1.Perform(EM_LINEFROMCHAR, Memo1.SelStart, 0);
  X := Memo1.Perform(EM_LINEINDEX, Y, 0);
  inc(Y);
  X := Memo1.SelStart - X + 1;
  Form1.Caption := 'X = ' + IntToStr(X) + ' : ' + 'Y = ' + IntToStr(Y);
end;
 
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
