---
Title: Получить количество ссылок AnsiString
Date: 01.01.2007
---


Получить количество ссылок AnsiString
=====================================

::: {.date}
01.01.2007
:::

    function GetAnsistringRefcount(const S: string): Cardinal;
     asm
       or eax, eax
       jz @done
       sub eax, 8
       mov eax, dword ptr [eax]
     @done:
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       S1, S2: string;
     begin
       memo1.lines.Add(Format('Refcount at start: %d',
         [GetAnsistringRefcount(S1)]));
       S1 := StringOfChar('A', 10);
       memo1.lines.Add(Format('Refcount after assignment: %d',
         [GetAnsistringRefcount(S1)]));
       S2 := S1;
       memo1.lines.Add(Format('Refcount after S2:=S1: %d',
         [GetAnsistringRefcount(S1)]));
       S2 := S1 + S2;
       memo1.lines.Add(Format('Refcount after S2:=S1+S2: %d',
         [GetAnsistringRefcount(S1)]));
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>

 
