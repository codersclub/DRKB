---
Title: Округление времени
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Округление времени
==================

    function RoundTime(ADate: string; Rounding: Integer; bRound: Boolean): string;
     var
       Year, Month, Day, Hour, Min, Sec, MSec: Word;
       tmpDate: TDateTime;
       Res, Diff: string;
       M: integer;
     begin
       tmpDate := StrToDateTime(ADate);
       DecodeTime(tmpDate, Hour, Min, Sec, MSec);
       if (Rounding > 0) and (bRound = True) then
       begin
         if Min mod Rounding = 0 then
           Res := IntToStr(Min)
         else
           Res := IntToStr(Round(Min / Rounding) * Rounding);
         M := StrToInt(Copy(ADate, Length(ADate) - 1, 2));
         Diff := IntToStr(StrToInt(Res) - M);
         if Copy(Diff, 1, 1) = '-' then
         begin
           Diff   := Copy(Diff, 2, Length(Diff) - 1);
           Result := FormatDateTime('dd.mm.yy hh:mm', (tmpDate - StrToTime('00:00' + Diff)));
         end
         else
           Result := FormatDateTime('dd.mm.yy hh:mm', (tmpDate + StrToTime('00:00' + Diff)));
       end
       else
         Result := ADate;
     end;
     
     // Example: 
     
    procedure TForm1.Button1Click(Sender: TObject);
     begin
       Edit1.Text := FormatDateTime('dd.mm.yy hh:mm', Now);
       Edit2.Text := RountTime(Edit1.Text, SpinEdit1.Value, Checkbox1.Checked);
       // Example: RoundTime('07.08.02 10:41', '15', True) -- > 07.08.02 10:45 
    end;

