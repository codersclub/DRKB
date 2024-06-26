---
Title: Массив компонентов
Author: Юрий Лапицкий
Date: 01.01.2007
---


Массив компонентов
==================

> Возможно ли создание массива компонентов? Для показа статуса я использую
> набор LED-компонентов и хотел бы иметь к ним доступ, используя массив.

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Прежде всего необходимо объявить массив:

    {10 элементов компонентного типа TLed}
    LED : array[1..10] of TLed;

При необходимости динамического создания LED-компонентов организуйте
цикл, пример которого мы приводим ниже:

    for counter := 1 to 10 do
    begin
      LED[counter]:= TLED.Create;
      LED[counter].top := ...
      LED[counter].Left := ...
      LED[counter].Parent := Mainform;   {что-то типа этого}
    end;

Если компоненты уже присутствуют на форме (в режиме проектирования),
сделайте их элементами массива, например так:

    leds := 0;
    for counter := 0 to Form.Componentcount do
    begin
      if (components[counter] is TLED) then
      begin
        inc(leds);
        LED[leds] := TLED(components[counter]);
      end
    end;

Тем не менее у нас получился массив со случайным расположением
LED-компонентов. Я предлагаю назначить свойству Tag каждого
LED-компонента порядковый номер его расположения в массиве, а затем
заполнить массив, используя это свойство:

    for counter := 0 to Form.Componentcount do
    begin
      if (components[counter] is TLED) then
      begin
        LED[Component[counter].tag] := TLED(components[counter]);
      end
    end;

Если вам нужен двухмерный массив, то для формирования индекса
понадобится другая хитрость, например, хранение в свойстве Hint
информации о времени создания компонентов.


------------------------------------------------------------------------

Вариант 2:

Author: Юрий Лапицкий

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Продолжая начатую тему в "Советах по Дельфи 1.0.9" о динамическом
массиве компонентов (на этот раз двухмерном, так как одномерный очень
хорошо был описан в этой версии журнала) я предлагаю следующей код
который позволяет создать такой массив компонентов TImage с удобным
(скажем так - почти) использованием их в этом массиве (например, при
осуществлении связи с каким-то другим массивом). Я использовал этот код
в одной из моих программ и после многих его тестов пришёл к выводу что
он нормально работает при размерах массива 17х17 (думаю что можно
довести и до 20х20 и более, но это увеличило бы код... Тем более что
для моей программы такого массива вполне достаточно!).

    {
    Листинг 1: Создание двухмерного динамического массива компонентов
    © 1999, Юрий Лапицкий
    }
     
    {
    Шаг #1: Вначале, сделаем потомок стандартного TImage как дополнение
    для их различия в будующем массиве компонентов.
    }
    type
     
      TMyImage = class(TImage)
      private
        FXTag, FYTag: Longint;
      published
        property XTag: Longint read FXTag write FXTag default 0;
        property YTag: Longint read FYTag write FYTag default 0;
      end;
      {===================}
      {
      Шаг #2: В описание класса главной формы вставим двухмерный динамический
      массив компонентов TMyImage, а в секцию private - необходимый код для
      инициализации массива!
      }
    type
      TForm1 = class(TForm)
     
        //Процедура реализации события OnMouseUp при наведении на картинку
        procedure ImageMouseUp(Sender: TObject; Button: TMouseButton;
          Shift: TShiftState; X, Y: Integer);
      public
        Images: array of array of TMyImage;
      private
        {Процедура "создания" поля}
        procedure MakeField(const MaxRows: byte = 4; MaxCols: byte = 4);
        {Процедура "убора" поля (вообще-то не обязательно,
        но я предпочитаю перестараться, чем недостараться...)}
        procedure FreeField(const MaxRows: byte = 4; MaxCols: byte = 4);
      end;
    var
     
      Form1: TForm1;
      Bitmap1: TBitmap;
      {
      В Bitmap1 можно загрузить картинку. Например из файла Bitmap1.bmp:
     
      Bitmap1:=TBitmap1.Create;
      Bitmap1.LoadFromFile('Bitmap1.bmp');
      }
      {===================}
      {
      Шаг #3: Реализация процедур в секции implementation.
      }
     
    procedure TForm1.MakeField(const MaxRows, MaxCols: byte);
    var
      Col, Row: byte;
    begin
     
      {Иницализация самого массива}
      Initialize(Images);
      System.SetLength(Images, MaxRows);
      for Row := 0 to MaxRows - 1 do
        System.SetLength(Images[Row], MaxCols);
     
      {Создание и заполнение элементов массива}
      for Row := 0 to MaxRows - 1 do
        for Col := 0 to MaxCols - 1 do
        begin
          Images[Row, Col] := TMyImage.Create(Self);
          with Images[Row, Col] do
          begin
            XTag := Row;
            YTag := Col;
     
            Picture.Bitmap := Bitmap1;
            Left := Col * Bitmap1.Width;
            Top := Row * Bitmap1.Height;
            Width := Bitmap1.Width + Left;
            Height := Bitmap1.Height + Top;
            Center := True;
            Transparent := True;
            AutoSize := True;
            Visible := True;
            onMouseUp := ImageMouseUp;
     
            Parent := Self;
          end
        end;
     
      Invalidate
    end;
     
    procedure TMainForm.FreeField(const MaxRows, MaxCols: byte);
    var
      Col, Row: byte;
    begin
     
      {Уничтожение элементов массива}
      for Row := 0 to MaxRows - 1 do
        for Col := 0 to MaxCols - 1 do
          Images[Row, Col].Destroy;
      {Уничтожение самого массива}
      Finalize(Images)
    end;
     
    procedure TMainForm.ImageMouseUp(Sender: TObject; Button:
      TMouseButton; Shift: TShiftState; X, Y: Integer);
    begin
     
      { Проверка необязательна, но ведь можно (случайно)
      присвоить это событие также и форме!}
      if (Sender is TMyImage) then
      begin
        {
        обратиться к элементу массива можно используя введ?нные
        мною дополнения: Sender.XTag и Sender.YTag
        Images[Sender.XTag, Sender.YTag]
        }
     
      end
    end;
 

------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    type
    PtImg = ^TtImg;
    TtImg = array [0..0] of TImage;
     
    var
    tImg: PtImg;
     
    GetMem(tImg, 4 * numberofentries);

Преимущество в том, что вы должны использовать столько памяти, сколько
вам нужно. Недостаток в том, что вы должны кодировать все с
tImg\^[n]....

------------------------------------------------------------------------

**Примечание от Vit**

Массивы компонентов это конечно круто, как и вообще динамические
массивы, но в современных реализациях идей ООП есть и более продвинутые
решения, такие как коллекции, желательно прежде чем делать динамический
массив компонентов и вообще какой-либо динамический массив ознакомится
например с классом TList и идеей коллекций вообще. По началу они могут
вызвать у Вас чуство неудобства, особенно если вы очень привыкли к
массивам, но в последующем Вы найдёте что многие типичные проблемы типа
поиска, сортировки, добавления и удаления элементов, ассоциации с
другими структурами, сериализация и т.п. в коллекциях уже реализованы и
исключительно просты в использовании.
