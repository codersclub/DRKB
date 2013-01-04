---
Title: Как прочитать время компиляции проги?
Author: Vit
Date: 01.01.2007
---


Как прочитать время компиляции проги?
=====================================

::: {.date}
01.01.2007
:::

Дату компилляции вытащить нельзя.
Можно дату Build (т.е. дату когда ты
сделал опрерацию Build All, или самую первую компилляцию)

1. Ставим библиотеку RxLib
2. Идем в опции проэкта, закладка Version Info, отмечаем птичкой -
include version info
3. В коде пишем следующее:


    uses
      Rxverinf;

     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      with TVersionInfo.create(paramstr(0)) do
      try
        caption := datetimetostr(verfiledate);
      finally
        free;
      end;
    end;

Автор: Vit

Взято с Vingrad.ru <https://forum.vingrad.ru>
