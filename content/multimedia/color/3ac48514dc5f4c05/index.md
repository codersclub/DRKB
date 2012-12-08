---
Title: Как сделать стандартные цвета в Delphi светлее или темнее?
Author: Den Bedard
Date: 01.01.2007
---


Как сделать стандартные цвета в Delphi светлее или темнее?
==========================================================

::: {.date}
01.01.2007
:::

Автор: Den Bedard

В данной статье хотелось бы показать принцип получения из обычного цвета
более тёмный или более светлый. А так же рассмотрим, как этот принцип
реализовани в программном коде.

Итак, немного теории:

Каждый из трёх основных цветов (Красный,Зелёный,Синий) могут иметь
значение от 0 до 255, соответственно скомбинировав их мы можем получить
16,777,216 возможных цветов. Визуально это можно предствить как три оси
куба, в котором направления x, y и z отвечают за цвета красный, зелёный
и синий. В сочетании эти направления дают точку в кубе, представляющую
один цвет из 16 миллионов. Точка куба, в которой значение равняется 0
(0,0,0) соответствует чёрному цвету, значение (255,255,255) - белому
цвету, (255,0,0) - чисто красному, и т.д.

Если визуально провести линию между каким-либо цветом (r,g,b) и белым
цветом (255,255,255), то получится, что на этой линии будут лежать все
значения данного цвета (r,g,b). Если мы будем двигаться по линии в
сторону белого цвета, то яркость будет увеличиваться до тех пор пока не
получим чисто белый цвет.

То же самое можно сделать и для уменьшения яркости цвета. Достаточно
провести линию из цвета (r,g,b) в чёрный (0,0,0). То есть при движении
по линии к чёрному цвету мы будем уменьшать яркость до тех пор, пока не
получим чёрный цвет.

Функция \"Darker\" возвращает новое значение цвета, которое будет на
сколько-то процентов темнее. Естевственно, что при 100% мы получим
чёрный цвет.

Функция \"Lighter\" возвращает цвет, который светлее на сколько-то
процентов исходного. 100% - белый цвет.

Функции Darker и Lighter требуют 2 параметра и используются примерно
так:

Panel1.Color := Darker(clBlue,20);

Получется панель цветов, которая на 20% темнее обычного синего цвета.

Теперь давайте посмотрим, как выглядят внутри наши функции:

    function Darker(Color:TColor; Percent:Byte):TColor; 
    var 
      r,g,b:Byte; 
    begin 
    Color:=ColorToRGB(Color); 
    r:=GetRValue(Color); 
    g:=GetGValue(Color); 
    b:=GetBValue(Color); 
    r:=r-muldiv(r,Percent,100);  //процент% уменьшения яркости
    g:=g-muldiv(g,Percent,100); 
    b:=b-muldiv(b,Percent,100); 
    result:=RGB(r,g,b); 
    end; 
     
    function Lighter(Color:TColor; Percent:Byte):TColor; 
    var 
      r,g,b:Byte; 
    begin 
    Color:=ColorToRGB(Color); 
    r:=GetRValue(Color); 
    g:=GetGValue(Color); 
    b:=GetBValue(Color); 
    r:=r+muldiv(255-r,Percent,100); //процент% увеличения яркости
    g:=g+muldiv(255-g,Percent,100); 
    b:=b+muldiv(255-b,Percent,100); 
    result:=RGB(r,g,b); 
    end; 
     
    Так же я добавил некоторые функции, в которых уже добавлены стандартные значения процентов. Это для тех, кому некогда задумываться над процентами :)
     
    Panel1.Color := Light(clBlue); 
    Panel1.Color := SlightlyDark(clRed); 
    Panel1.Color := VeryLight(clMagenta); 
    etc. 
     
    function SlightlyDark(Color:TColor):TColor; 
    begin 
      Result := Darker(Color,25); 
    end; 
     
    function Dark(Color:TColor):TColor; 
    begin 
      Result := Darker(Color,50); 
    end; 
     
    function VeryDark(Color:TColor):TColor; 
    begin 
      Result := Darker(Color,75); 
    end; 
     
    function SlightlyLight(Color:TColor):TColor; 
    begin 
      Result := Lighter(Color,25); 
    end; 
     
    function Light(Color:TColor):TColor; 
    begin 
      Result := Lighter(Color,50); 
    end; 
     
    function VeryLight(Color:TColor):TColor; 
    begin 
      Result := Lighter(Color,75); 
    end;

Взято из <https://forum.sources.ru>
