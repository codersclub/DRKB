---
Title: Получить первую или последнюю видимую строку в TRichEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить первую или последнюю видимую строку в TRichEdit
========================================================

    function RE_GetLastVisibleLine(RichEdit: TRichEdit): Integer;
     const
       EM_EXLINEFROMCHAR = WM_USER + 54;
     var
       r: TRect;
       i: Integer;
     begin
       { 
       The EM_GETRECT message retrieves the formatting rectangle 
       of an edit control. 
       }
       RichEdit.Perform(EM_GETRECT, 0, Longint(@r));
       r.Left := r.Left + 1;
       r.Top  := r.Bottom - 2;
       { 
        The EM_CHARFROMPOS message retrieves information about the character 
        closest to a specified point in the client area of an edit control 
       }
       i := RichEdit.Perform(EM_CHARFROMPOS, 0, Integer(@r.topleft));
       { 
        The EM_EXLINEFROMCHAR message determines which 
        line contains the specified character in a rich edit control 
       }
       Result := RichEdit.Perform(EM_EXLINEFROMCHAR, 0, i);
     end;
     
     { 
      Sending the EM_GETFIRSTVISIBLELINE message to a multi-line edit control 
      finds out which line is the first line visible. 
      This is the line that is currently displayed at the top of the control. 
     }
     
     function RE_GetFirstVisibleLine(RichEdit: TRichEdit): Integer;
     begin
       Result := RichEdit.Perform(EM_GETFIRSTVISIBLELINE, 0, 0);
     end;

