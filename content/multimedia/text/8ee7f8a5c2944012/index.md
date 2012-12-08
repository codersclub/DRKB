---
Title: Как нарисовать disabled текст?
Date: 01.01.2007
---


Как нарисовать disabled текст?
==============================

::: {.date}
01.01.2007
:::

    {Draw Disabled Text **************
     ***** This function draws text in "disabled" style.  *****
     ***** i.e. the text is grayed .                      *****
     **********************************************************}
    function DrawDisabledText (Canvas : tCanvas; Str: PChar; Count: Integer;
                               var Rect: TRect;  Format: Word): Integer;
    begin
      SetBkMode(Canvas.Handle, TRANSPARENT);
     
      OffsetRect(Rect, 1, 1);
      Canvas.Font.color:= ClbtnHighlight;
      DrawText (Canvas.Handle, Str, Count, Rect,Format);
     
      Canvas.Font.Color:= ClbtnShadow;
      OffsetRect(Rect, -1, -1);
      DrawText (Canvas.Handle, Str, Count, Rect, Format);
    end;

Зайцев О.В.

Владимиров А.М.

Взято из <https://forum.sources.ru>
