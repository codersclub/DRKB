---
Title: Вставка текста в TMemo в текущую позицию
Date: 01.01.2007
---


Вставка текста в TMemo в текущую позицию
========================================

::: {.date}
01.01.2007
:::

    SendMessage(Memo.Handle, EM_REPLACESEL, 0, PCHAR('Delphi World - это КРУТО!'));
     
     
     
     
     
    Var TempBuf :Array [0..255] of Char;
    SendMessage(Memo.Handle, EM_REPLACESEL, 0, StrPCopy(TempBuf,'Delphi World - это КРУТО!'));
     
     
     
     
     
    Memo1.SelText := 'Delphi World!';
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
