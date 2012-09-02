<h1>Как посчитать возраст человека?</h1>
<div class="date">01.01.2007</div>


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
  Label1.Caption := Format('Your age is %d', [CalculateAge(StrToDate('01.01.1903'), Date)]); 
end; 
</pre>
<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
