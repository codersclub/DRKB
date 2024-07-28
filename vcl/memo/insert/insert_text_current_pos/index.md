---
Title: Вставка текста в TMemo в текущую позицию
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Вставка текста в TMemo в текущую позицию
========================================

    {1} SendMessage(Memo.Handle, EM_REPLACESEL, 0, PCHAR('Delphi World - это КРУТО!'));

     
    {2} Var TempBuf :Array [0..255] of Char;
    SendMessage(Memo.Handle, EM_REPLACESEL, 0, StrPCopy(TempBuf,'Delphi World - это КРУТО!'));

     
    {3} Memo1.SelText := 'Delphi World!';


