---
Title: Как узнать физические координаты каретки в пикселях?
Date: 01.01.2007
---


Как узнать физические координаты каретки в пикселях?
====================================================

::: {.date}
01.01.2007
:::

    {TRichEdit}
     
    var
      pt: TPoint;
    begin
      with richedit1 do
      begin
        Perform(messages.EM_POSFROMCHAR, WPARAM(@pt), selstart);
        label1.caption := Format('(%d, %d)', [pt.x, pt.y]);
      end;
    end;
     
    {TMemo and TEdit}
     
    var
      r: LongInt;
    begin
      with memo1 do
      begin
        r := Perform(messages.EM_POSFROMCHAR, selstart, 0);
        if r >= 0 then
        begin
          label1.caption := IntToStr(HiWord(r));
          label2.caption := IntToStr(LoWord(r));
        end;
      end;
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>