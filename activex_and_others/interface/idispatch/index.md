---
Title: Дайте теоретическое объяснение типу IDispatch
Author: Snick\_Y2K
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Дайте теоретическое объяснение типу IDispatch
=============================================

Вариант 1:

Идентификатор интерфейса тип IDispatch, используемый для связи с
объектом. Для создания объектов COM, не использующих интерфейс
IDispatch, надо использовать функцию CreateComObject.

Русскими словами: varDispatch        $0009        ссылка на
автоматический объект (указатель на интерфейс IDispatch)

Автор: Snick\_Y2K

------------------------------------------------------------------------
Вариант 2:

"Тип IDispatch" - не звучит. Ты бы сказал, в каком контексте.

Вообще, IDispatch - это интерфейс. Если ты заглянешь в System.pas, ты
найдешь его делфийское описание:

     IDispatch=interface
      .....
     end;

Это интерфейс используется для обеспечения "позднего связывания" в
COM, то есть вызовов методов(и использования property) когда на момент
компиляции их имена не известны. Например:

    var
      v:variant;
    begin
      v:=CreateOleObject("Excel.Appication");
      v.Quit;
    end;

Как тут вызывается метод Quit? Ведь компилятор совершенно ничего не
знает об этом методе, ровно как и о том, что содержится в переменно v.
На самом деле, одна эта строчка транслируется компилятором в набор
примерно таких вызовов:

    var
      v:variant;
    begin
      v:=CreateOleObject("Excel.Appication");
      if TVarData(v).vtType=vtIDispatch then
      begin
         pseudo_compiler_generated_IDispatch:IDispatch=TVarData(v).varIDispatch //указатель на интерфейс IDispatch
         cpl_gen_DispID:integer;
         pseudo_compiler_generated_IDispatch.GetIDsOfNames('Quit',1,cpl_gen_DispID);  //получаем числовой индефикатор имени "Quit"
         pseudo_compiler_generated_IDispatch.Invoke(cpl_gen_DispID,....); //вызывает метод по индификатору.
      end;
    end;

Если использоват IDispatch вместо variant, то все это можно написать
самому:

    var
      Disp:IDispatch;
      DispID:integer;
    begin
      Disp:=CreateOleObject("Excel.Appication");
      Disp.GetIDsOfNames('Quit',1,DispID);  //получаем числовой индефикатор имени "Quit"
      Disp.Invoke(DispID,....); //вызывает метод по индификатору.
    end;

Автор: Fantasist

