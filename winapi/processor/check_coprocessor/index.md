---
Title: Как определить наличие сопроцессора?
Date: 01.01.2007
---

Как определить наличие сопроцессора?
====================================

::: {.date}
01.01.2007
:::

В отличие от общепринятого мнения не всее клоны 486/586/686/ и Pentium
имеют сопроцессор для вычислений с плавающей запятой. В примере
определяется наличие сопроцессора и под Win16 и под Win32.

Пример:

    {$IFDEF WIN32}
     
    uses Registry;
     
    {$ENDIF}
     
    function HasCoProcesser : bool;
    {$IFDEF WIN32}
    var
            TheKey : hKey;
    {$ENDIF}
    begin
            Result := true;
            {$IFNDEF WIN32}
            if GetWinFlags and Wf_80x87 = 0 then
            Result := false;
            {$ELSE}
            if RegOpenKeyEx(HKEY_LOCAL_MACHINE,
            'HARDWARE\DESCRIPTION\System\FloatingPointProcessor',0,
            KEY_EXECUTE, TheKey) <> ERROR_SUCCESS then result := false;
            RegCloseKey(TheKey);
    {$ENDIF}
            end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
            if HasCoProcesser then
                    ShowMessage('Has CoProcessor') 
            else
                    ShowMessage('No CoProcessor - Windows Emulation Mode');
    end;

Взято из

DELPHI VCL FAQ Перевод с английского      

Подборку, перевод и адаптацию материала подготовил Aziz(JINX)

специально для [Королевства Дельфи](https://delphi.vitpc.com/)
