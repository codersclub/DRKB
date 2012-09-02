<h1>Как подсчитать возраст по дню рождения?</h1>
<div class="date">01.01.2007</div>



<pre>
{ BrthDate:  Date of birth }
 
function TFFuncs.CalcAge(brthdate: TDateTime): Integer;
var
  month, day, year, bmonth, bday, byear: word;
begin
  DecodeDate(BrthDate, byear, bmonth, bday);
  if bmonth = 0 then
    result := 0
  else
  begin
    DecodeDate(Date, year, month, day);
    result := year - byear;
    if (100 * month + day) &lt; (100 * bmonth + bday) then
      result := result - 1;
  end;
end;
</pre>
<hr />
<pre>
procedure TForm1.Button1Click(Sender: TObject);
var
  Month, Day, Year, CurrentMonth, CurrentDay, CurrentYear: word;
  Age: integer;
begin
  DecodeDate(DateTimePicker1.Date, Year, Month, Day);
  DecodeDate(Date, CurrentYear, CurrentMonth, CurrentDay);
  if (Year = CurrentYear) and (Month = CurrentMonth) and (Day = CurrentDay) then
    Age := 0
  else
  begin
    Age := CurrentYear - Year;
    if (Month &gt; CurrentMonth) then
      dec(Age)
    else if Month = CurrentMonth then
      if (Day &gt; CurrentDay) then
        dec(Age);
  end;
  Label1.Caption := IntToStr(Age);
end;
</pre>


<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>

<hr />
<pre>
function CalculateAge(Birthday, CurrentDate: TDate): Integer;
var
  Month, Day, Year, CurrentYear, CurrentMonth, CurrentDay: Word;
begin
  DecodeDate(Birthday, Year, Month, Day);
  DecodeDate(CurrentDate, CurrentYear, CurrentMonth, CurrentDay);
 
  if (Year = CurrentYear) and (Month = CurrentMonth) and (Day = CurrentDay) then
  begin
    Result := 0;
  end
  else
  begin
    Result := CurrentYear - Year;
    if (Month &gt; CurrentMonth) then
      Dec(Result)
    else
    begin
      if Month = CurrentMonth then
        if (Day &gt; CurrentDay) then
          Dec(Result);
    end;
  end;
end;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  Label1.Caption := Format('Your age is %d',
    [CalculateAge(StrToDate('01.01.1903'), Date)]);
end;
</pre>

<p>Взято с сайта: <a href="https://www.swissdelphicenter.ch" target="_blank">https://www.swissdelphicenter.ch</a></p>


<hr />
<pre>
DecodeDate(DM.Table.FieldByName('Born').AsDateTime, Year, Month, Day); // Дата рождения
DecodeDate(Date, YYYY, MM, DD); // Текущая дата
 
if (MM &gt;= Month) and (DD &gt;= Day) then
  Edit2.Text := IntToStr((YYYY - Year))
else
  Edit2.Text := IntToStr((YYYY - Year) - 1);
</pre>

<a href="https://delphiworld.narod.ru/" target="_blank">https://delphiworld.narod.ru/</a></p>
<p>DelphiWorld 6.0</p>

