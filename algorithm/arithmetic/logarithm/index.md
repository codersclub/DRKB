---
Title: Как посчитать логарифм?
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Как посчитать логарифм?
=======================

Функция вычисления логарифма с переменным основанием

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

