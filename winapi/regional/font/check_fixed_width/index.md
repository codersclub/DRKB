---
Title: Является ли шрифт шрифтом с фиксированной шириной?
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Является ли шрифт шрифтом с фиксированной шириной?
==================================================

    procedure TConsole.FontChanged(Sender: TObject);
    var
      DC: HDC;
      Save: THandle;
      Metrics: TTextMetric;
      Temp: string;
    begin
      if Font.Handle <> FOldFont.Handle then
      begin
        DC := GetDC(0);
        Save := SelectObject(DC, Font.Handle);
        GetTextMetrics(DC, Metrics);
        SelectObject(DC, Save);
        ReleaseDC(0, DC);
        if not (((Metrics.tmPitchAndFamily and ff_Modern) <> 0) and
          ((Metrics.tmPitchAndFamily and $01) = 0)) then
        begin
          Temp := 'TConsole: ' + Font.Name +
            ' не является шрифтом с фиксированной шириной';
          Font.Name := FOldFont.Name; { Возвращаем предыдущие атрибуты шрифта }
          raise EInvalidFont.Create(Temp);
        end;
        SetMetrics(Metrics);
      end;
      FOldFont.Assign(Font);
      if csDesigning in ComponentState then
        InternalClrScr;
    end;

