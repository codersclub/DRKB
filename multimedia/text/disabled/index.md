---
Title: Как нарисовать disabled текст?
Date: 01.01.2007
Author: Зайцев О.В., Владимиров А.М.
Source: <https://forum.sources.ru>
---


Как нарисовать disabled текст?
==============================

    {***** Draw Disabled Text *********************************
     ***** This function draws text in "disabled" style.  *****
     ***** i.e. the text is grayed .                      *****
     **********************************************************}
    function DrawDisabledText (Canvas : tCanvas; Str: PChar;
                               Count: Integer;
                               var Rect: TRect;
                               Format: Word): Integer;
    begin
      SetBkMode(Canvas.Handle, TRANSPARENT);
     
      OffsetRect(Rect, 1, 1);
      Canvas.Font.color:= ClbtnHighlight;
      DrawText (Canvas.Handle, Str, Count, Rect,Format);
     
      Canvas.Font.Color:= ClbtnShadow;
      OffsetRect(Rect, -1, -1);
      DrawText (Canvas.Handle, Str, Count, Rect, Format);
    end;

