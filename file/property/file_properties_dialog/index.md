---
Title: Как вызвать диалог свойств файла?
Date: 01.01.2007
---


Как вызвать диалог свойств файла?
=================================

    Procedure ShowFileProperties(Const filename: String);
    Var
      sei: TShellExecuteinfo;
    Begin
      FillChar(sei,sizeof(sei),0);
      sei.cbSize := sizeof(sei);
      sei.lpFile := Pchar(filename);
      sei.lpVerb := 'properties';
      sei.fMask  := SEE_MASK_INVOKEIDLIST;
      ShellExecuteEx(@sei);
    End;

