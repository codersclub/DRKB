<h1>Прибавить час</h1>
<div class="date">01.01.2007</div>

<p>Тип TDateTime, используемый для передачи даты и времени, это тип double, у которого целая часть определяет день, а дробная время от полуночи. То есть, если прибавить ко времени 1, то дата изменится на один день, а время не изменится. Если прибавить 0.5, то прибавится 12 часов. Причем этот метод работает даже в том случае, когда меняется дата, месяц или год. </p>
<pre>
procedure TForm1.Timer1Timer(Sender: TObject);
begin
  Label1.Caption := DateTimeToStr(Time);
  Label2.Caption := DateTimeToStr(Time + 1 / 24);
end;
</pre>
<p><a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>
&nbsp;</p>

