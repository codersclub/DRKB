---
Title: Как удалить сегодняшнюю дату из TDateTimePicker?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch/en/tipsindex.php>
---


Как удалить сегодняшнюю дату из TDateTimePicker?
================================================

    uses
      CommCtrl;
     
    procedure TForm1.DateTimePicker1DropDown(Sender: TObject);
    var
      wnd: HWND;
      Style: Integer;
    begin
      wnd := DateTime_GetMonthCal(DateTimePicker1.Handle);
      if wnd <> 0 then
      begin
        Style := GetWindowLong(wnd, GWL_STYLE);
        SetWindowLong(wnd, GWL_STYLE, Style or MCS_NOTODAY or MCS_NOTODAYCIRCLE);
      end;
    end;
     
    {
      The calendar will still highlite the current day but the circle and the
      today display at the bottom are gone.
    }

