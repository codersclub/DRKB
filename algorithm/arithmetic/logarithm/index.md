---
Title: Как посчитать логарифм?
Date: 01.01.2007
---


Как посчитать логарифм?
=======================

::: {.date}
01.01.2007
:::

    {
     
       --- English ------
       A logarithm function with a variable basis
     
    }
     function Log(x, b: Real): Real;
     begin
       Result := ln(x) / ln(b);
     end;
     
     procedure TForm1.Button1Click(Sender: TObject);
     begin
       ShowMessage(Format('%f', [Log(10, 10)]));
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
