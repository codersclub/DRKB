---
Title: Анимация без DirectX
Author: http://sunsb.dax.ru
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Анимация без DirectX
====================

При попытке изобразить некую анимацию использую только средства TCanvas,
на экране получается черте-чего. Все мельтешит, дергается,
одним словом - не годится.

Для получения " гладкой" ( не мельтешащей ) анимация в программах не
использующих DirectX, я обычно использую следующую технику.

Узким местом в процессе является момент изменения картинки на экране,
поэтому рисование нужно проводить на невидимом для пользователя канвасе,
и только подготовив там обновляемые участки выводить их на видимый
экран.

Для того, чтобы стереть кртинку в том месте где ее уже нет, нужно
помнить позицию в которой она была выведена в прошлый раз. Обзовем эту
позицию Old: TRect, текущую позицию запомним в New: TRect.

TRect я использую, на сучай если размер отображаемой картинки может
изменяться.

Стандартным подходом является написание двух процедур - Hide и Show,
одна из которых прячет картинку в старой позиции, выводя участок фона
поверх нее, а вторая выводит в новой позиции.

Такой вариант не проходит и приводит к мерцанию изображения.

Я предлагаю оставить процедуру Hide в покое, и пользоваться ей только
если картинку нужно совсем убрать с экрана.

Процедура Show будет выполнять обе нужные функции. Для обновления экрана
нам нужно погасить картинку в старой позиции и показать в новой.

Тут возможны два варианта.

**Первый** - старый и новый прямоугольники пересекаются. В этом случае мы
создаем временный TBItmap - tmp с размером их объединения, заполняем его
требуемым участком фона, и рисуем на нем картинку. После такой
подготовки выводим tmp в нужной позиции экрана.

**Второй** - старый и новый прямоугольники не пересекаются. В этом случае мы
просто копируем прямоугольник old с невидимой копии фона на экран (
процедура Hide ), и рисуем нужную картинку в прямоугольнике new.

При таком подходе мы избегаем двойной перерисовки экрана, что исключает
мерцание.

Ниже программа которая все это делает.

    var wsrf: TPaintBox; // видимый экран
    var ssrf: TBitmap;   // скрытый неизменяемый фон
    var bmp : TBitmap;   // картинка для анимации
    var tmp : TBitmap;   // временное хранилище
     
    function hasIntersect( const A,B : TRect): boolean;
    var R: trect; // пересекаются ли прямоугольники
    begin
       result  := false;
       R.Left  := max( A.Left,   B.Left   );
       R.Right := min( A.Right,  B.Right  );
       if R.Left > = R.Right then exit;
       R.Top   := max( A.Top,    B.Top    );
       R.Bottom:= min( A.Bottom, B.Bottom );
       if R.Top  > = R.Bottom then exit;
       result := true;
    end;
     
    function Union( A, B: TRect ):TRect;
    begin // результат - объединение
       if EmptyRect( A ) then result := B
       else if EmptyRect( B ) then result := A
            else begin
             Result.Left  := min( A.Left,   B.Left   );
             Result.Top   := min( A.Top,    B.Top    );
             Result.Right := max( A.Right,  B.Right  );
             Result.Bottom:= max( A.Bottom, B.Bottom );
          end;
    end;
     
    procedure TOneTooth.Hide;
    begin
      tmp.Width := bmp.Width;
      tmp.Height:= bmp.Height;
      tmp.Canvas.CopyRect( bmpRect(tmp), ssrf.Canvas, old );
      wsrf.Canvas.Draw( old.Left, old.Top, tmp );
    end;
     
    procedure TOneTooth.Show;
    var R, R1 : TRect;
    begin
      now.Right  := now.Left + bmp.Width ; 
             //корректировка now на случай
      now.Bottom := now.Top  + bmp.Height; 
             //изменения размеров bmp
      if hasIntersect( old, now ) then begin
        R := Union( old, now );
        tmp.Width := R.Right-R.Left;
        tmp.Height:= R.Bottom-R.Top;
        tmp.Canvas.CopyRect( bmpRect(tmp), ssrf.Canvas, R );   
           // фон
        tmp.Canvas.Draw( now.left-r.left, now.Top-r.top, bmp ) 
           // фон + картинка
      end else begin
        Hide;
        tmp.Canvas.CopyRect( bmpRect(bmp), ssrf.Canvas, now ); 
           // фон
        tmp.Canvas.Draw( 0, 0, bmp ); // фон + картинка
        R:=now;
      end;
      wsrf.Canvas.Draw( R.Left, R.Top, tmp );
      old := now;
    end;

