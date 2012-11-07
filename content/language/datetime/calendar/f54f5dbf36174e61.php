<h1>Получить номер дня в году</h1>
<div class="date">01.01.2007</div>


<pre>
function GetDays(ADate: TDate): Extended;
 var
   FirstOfYear: TDateTime;
 begin
   FirstOfYear := EncodeDate(StrToInt(FormatDateTime('yyyy', now)) - 1, 12, 31);
   Result      := ADate - FirstOfYear;
 end;
 
 procedure TForm1.Button1Click(Sender: TObject);
 begin
   label1.Caption := 'Today is the ' + FloatToStr(GetDays(Date)) + '. day of the year';
 end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>
</p>
