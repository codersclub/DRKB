---
Title: Перейти на строку в TRichEdit
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Перейти на строку в TRichEdit
=============================

    with Richedit1 do
    begin
         selstart := perform( EM_LINEINDEX, linenumber, 0 );
         perform( EM_SCROLLCARET, 0, 0 );
    end;
     
    {
    The EM_LINEINDEX message returns the character index of the first character
    on a given line, assigning that to selstart moves the caret to that position.
    The control will only automatically scroll the caret into view if it has
    the focus, thus the EM_SCROLLCARET.
    }

