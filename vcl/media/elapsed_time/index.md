---
Title: Как показать оставшееся время до конца?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как показать оставшееся время до конца?
=======================================

```delphi
procedure TForm1.Timer1Timer(Sender: TObject);
var
  TheLength, Posi, SummaMin, SummaSec: Integer;
begin
  // Progress Bar to check if the track is playing
  if Progress.Max <> 0 then
  begin
    Progress.Position := Mediaplayer1.Position;

    // Gets the length of the selected track
    TheLength := Mediaplayer1.TrackLength[ListBox1.ItemIndex];

    // gets the current position of the track
    Posi := Mediaplayer1.Position;

    // Caculates Minutes
    SummaMin := ((TheLength - Posi) div 1000) Div 60;

    // Calculates Seconds
    SummaSec := ((TheLength - Posi) Div 1000) Mod 60;

    // Adds zero if Seconds are less then ten
    if SummaSec < 10 Then
      Label2.Caption := '0' + IntToStr(SummaSec)
    else
      Label2.Caption := IntToStr(SummaSec);

    // Minutes
    Label1.Caption := IntToStr(SummaMin);
  end;
end;
```
