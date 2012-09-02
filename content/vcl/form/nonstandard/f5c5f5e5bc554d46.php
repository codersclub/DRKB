<h1>Как создавать неквадратные формы и контроллы?</h1>
<div class="date">01.01.2007</div>


<p>Всё, что нам нужно, это HRGN и дескриптор (handle) элемента управления. SetWindowRgn имеет три параметра: дескриптор окна, которое будем менять, дескритор региона и булевый (boolean) параметр, который указывает - перерисовывать или нет после изменения. Как только у нас есть дескриптор и регион, то можно вызвать SetWindowRgn(Handle, Region, True) и вуаля!</p>

<p>Здесь приведён пример использования функции BitmapToRgn (описанной в примере Как создать регион(HRNG) по маске). </p>

<p>Заметьте, что Вы не должны освобождать регион при помощи DeleteObject, так как после вызова SetWindowRgn владельцем региона становится операционная система.</p>
<pre>
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
</pre>


<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>

