<h1>Конвертируем Unix-дату</h1>
<div class="date">01.01.2007</div>



<p>The value is a Unix Time, defined as seconds since 1970-01-01T00:00:00,0Z. Important is the Letter Z, you live in Sweden, in consequence you must add 1 hour for StandardDate and 2 hours for DaylightDate to the date. The infos you can get with GetTimeZoneInformation. But you must determine, which Bias (Standard or Daylight) is valid for the date (in this case -60). You can convert the date value with the function below.</p>

<p>The Date for 977347109 is 2000-12-20T22:18:29+01:00.</p>

<pre>
const
  UnixDateDelta = 25569; { 1970-01-01T00:00:00,0 }
  SecPerMin = 60;
  SecPerHour = SecPerMin * 60;
  SecPerDay = SecPerHour * 24;
  MinDayFraction = 1 / (24 * 60);
 
  {Convert Unix time to TDatetime}
 
function UnixTimeToDateTime(AUnixTime: DWord; ABias: Integer): TDateTime;
begin
  Result := UnixDateDelta + (AUnixTime div SecPerDay) { Days }
  + ((AUnixTime mod SecPerDay) / SecPerDay) { Seconds }
  - ABias * MinDayFraction { Bias to UTC in minutes };
end;
 
{Convert Unix time to String with locale settings}
 
function UnixTimeToStr(AUnixTime: DWord; ABias: Integer): string;
begin
  Result := FormatDateTime('ddddd  hh:nn:ss', UnixTimeToDateTime(AUnixTime, ABias));
end;
 
{Convert TDateTime to Unix time}
 
function DateTimeToUnixTime(ADateTime: TDateTime; ABias: Integer): DWord;
begin
  Result := Trunc((ADateTime - UnixDateDelta) * SecPerDay) + ABias * SecPerMin;
end;
 
procedure TForm1.Button4Click(Sender: TObject);
begin
  Label1.Caption := UnixTimeToStr(977347109, -60);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
