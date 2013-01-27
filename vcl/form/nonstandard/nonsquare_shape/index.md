---
Title: Как создавать неквадратные формы и контроллы?
Date: 01.01.2007
---


Как создавать неквадратные формы и контроллы?
=============================================

::: {.date}
01.01.2007
:::

Всё, что нам нужно, это HRGN и дескриптор (handle) элемента управления.
SetWindowRgn имеет три параметра: дескриптор окна, которое будем менять,
дескритор региона и булевый (boolean) параметр, который указывает -
перерисовывать или нет после изменения. Как только у нас есть дескриптор
и регион, то можно вызвать SetWindowRgn(Handle, Region, True) и вуаля!

Здесь приведён пример использования функции BitmapToRgn (описанной в
примере Как создать регион(HRNG) по маске).

Заметьте, что Вы не должны освобождать регион при помощи DeleteObject,
так как после вызова SetWindowRgn владельцем региона становится
операционная система.

    var 
      MaskBmp: TBitmap; 
    begin 
      MaskBmp := TBitmap.Create; 
      try 
        MaskBmp.LoadFromFile('FormShape.bmp'); 
        Height := MaskBmp.Height; 
        Width := MaskBmp.Width; 
        // ОС владеет регионом, после вызова SetWindowRgn
        SetWindowRgn(Self.Handle, BitmapToRgn(MaskBmp), True); 
      finally 
        MaskBmp.Free; 
      end; 
    end;

Взято из <https://forum.sources.ru>
