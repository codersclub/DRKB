---
Title: Как получить описание кода, полученного GetLastError?
Date: 01.01.2007
---


Как получить описание кода, полученного GetLastError?
=====================================================

::: {.date}
01.01.2007
:::

Функция RTL SysErrorMessage(GetLastError).

    procedure TForm1.Button1Click(Sender: TObject);
    begin
     {Cause a Windows system error message to be logged}
      ShowMessage(IntToStr(lStrLen(nil)));
      ShowMessage(SysErrorMessage(GetLastError));
    end;
