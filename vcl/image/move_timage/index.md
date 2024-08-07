---
Title: Перемещение TImage
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Перемещение TImage
==================

Многие, наверно, сталкивались с проблемой перемещения Image\'a по форме.
Решить ее можно тремя способами (может есть и больше, но я знаю только
три).

**Способ первый.**

Его суть заключается в том, что свойства Left и Top
картинки изменяются на разницу между начальными и конечными координатами
(нажатия и отпускания мыши соответственно). Этот способ самый простой и
надежный, но у него есть один недостаток: left и top изменяются по
очереди, что приводит к заметному мерцанию картинки. Тем не менее мы
этот способ рассмотрим.
Не забудьте положить на форму Image и вставить в
нее какую-нибудь картинку.

Для начала необходимо объявить глобальные
переменные (они объявляются в разделе Implementation) `x0, y0: integer` -
они будут запоминать начальные координаты. И еще нам понадобится
переменная move типа boolean, чтобы нам отличать перемещение мыши над
картинкой, от попытки ее сдвинуть. Эти объявления делаются примерно так:

    implementation
    {$R *.DFM}
     
    var
      x0, y0: integer;
      move: boolean;

Теперь напишем обработчик OnMouseDown для нашей картинки:

    procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      if button <> mbLeft then
        move:=false //если нажали не левой кнопкой, то перемещать не будем!
      else
      begin
        move:=true;
        x0:=x; //запоминаем начальные координаты
        y0:=y; //запоминаем начальные координаты
      end;
    end;

В этом участке кода проверяется какой кнопкой нажали на картинку. Если
левой, то запоминаем координаты, а если любой другой, то перемещать
нельзя.

Теперь напишем обработчик OnMouseMove для нашей картинки:

    procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
    Y: Integer);
    begin
      if move then
      begin
        image1.Left:=image1.Left+x-x0; // Изменяем позицию левого края
        image1.Top:=image1.Top+y-y0; // Изменяем позицию верхнего края
      end;
    end;

Ну и наконец обработчик OnMouseUp для нашей картинки будет таким:

    procedure TForm1.Image1MouseUp(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      move := false;
    end;

Здесь все очень просто. Когда кнопка отпускается, то переменной move
присваивается значение false, чтобы до следующего клика по картинке ее
нельзя было сдвинуть.

**Способ 2.**

Первый способ довольно прост, как для понимания, так и для реализации.
Но такой же алгоритм перемещения можно реализовать немного красивее.

У некоторых компонентов, в том числе и Image, есть
такая классная процедура `SetBounds(Left,Top,Width,Height)`, которая может
изменять сразу все четыре параметра!

Таким образом событие OnMouseMove можно изменить так:

    procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
    Y: Integer);
    begin
      if move then
        image1.SetBounds(image1.Left+x-x0, image1.Top+y-y0,
        image1.width, image1.height);
    end;

**Способ 3.**

Но есть еще один очень интересный выход: по экрану можно перемещать не
саму картинку, а только ее рамку, когда пользователь выберет место для
картинки и отпустит кнопку - она туда переместится. Для этого нам
понадобится еще одна глобальная переменная: `rec: TRect`, которая будет
хранить параметры картинки. Теперь слегка изменим обработчики событий
для картинки. Таким образом все в целом будет выглядеть так:

    procedure TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      if button<>mbLeft then
        move:=false
      else
      begin
        move:=true;
        x0:=x;
        y0:=y;
        rec:=image1.BoundsRect; //запоминаем контур картинки
      end;
    end;
     
    procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
    Y: Integer);
    begin
      if move then
      begin
        Form1.Canvas.DrawFocusRect(rec); //рисуем рамку
        with rec do
        begin
          left:=Left+x-x0;
          top:=Top+y-y0;
          right:=right+x-x0;
          bottom:=bottom+y-y0;
          x0:=x;
          y0:=y; // изменяем координаты
        end;
        Form1.Canvas.DrawFocusRect(rec); // рисуем рамку на новом месте
      end;
    end;
     
    procedure TForm1.Image1MouseUp(Sender: TObject; Button: TMouseButton;
    Shift: TShiftState; X, Y: Integer);
    begin
      Form1.Canvas.DrawFocusRect(rec);
      with image1 do begin
        setbounds(rec.left+x-x0,rec.top+y-y0,width,height); //перемещаем картинку
        move:=false;
      end;
    end;

Поскольку DrawFocusRect рисует рамку методом Xor, то при повторном
вызове этой функции с теми же параметрами, рамка стирается. Этот очень
красивый метод добавит в ваши программы много интересного.

