---
Title: Перетасовка экрана в Delphi
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Перетасовка экрана в Delphi
===========================

_Перевод одноимённой статьи с сайта delphi.about.com_

В статье описывается пример, который позволяет разделить экран на блоки,
а затем поменять эти блоки местами. Так же можно менять размеры блоков и
скрость их перемещения. На мой взгляд неплохое начало для создания
логической игрушки либо экранной заставки.

Уверен, что каждый из Вас уже хоть раз видел что-то подобное в действии.
При запуске, программа берёт изображение десктопа и разделяет его на
определённое количество прямоугольных частей (одинакового размера).
После этого часть блоков случайным образом перемещается со своего
первоначального места.

**Как это всё осуществить**

Создайте новый проект Delphi с чистой формой. Установите свойство Name в
\'Shuffler\'. Добавьте на форму компоненты Image (Image1) и Timer
(Timer1). Image будет содержать в себе изображение десктопа
(разобранное), а Timer будет вызывать процедуру рисования. Свойство
Interval компонента Timer определяет, как часто будет происходить
перемешивание (значение 1000 эквивалентно одной секунде, 2000 - двум
секундам).

Так же для проекта потребуется несколько глобальных переменных.
Поместите следующий код перед секцией implementation в модуле формы:

    var
      Shuffler: TShuffler; //это было добавлено самой Delphi
     
      DesktopBitmap   : TBitmap; 
      gx, gy          : Integer; 
      redRect         : TBitmap; 
     
      rW, rH          : Integer; 
     
    const
      DELTA = 8; //должно быть 2^n

- Значение константы (integer) DELTA определяет, на сколько частей будет
разбит экран (строк и колонок). Число DELTA должно быть в виде 2^n, где
n - целое (integer) число со знаком. Большое значение DELTA приводит к
маленьким размерам блоков. Например, если DELTA равна 16 и разрешение
экрана 1024 x 768, то экран будет поделён на 256 частей размером 64x48.

- DesktopBitmap - это битмап, который хранит в себе захваченное текущее
изображение десктопа - мы будем получать это изображение делая скриншот.

- redRect это битмап картинка, которая заменяет перемещённую часть
картинки. redRect создаётся в событии формы OnCreate.

- gx, gy содержат текущие координаты x и y (Left, Top) redRect внутри
разобранного изображения.

- rW, rH это ширина и высота прямоугольного блока. Для 1024x768 и
DELTA=16, rW будет равно 64 а rH = 48.

Проект начинает выполняться с обработчика события OnCreate:

    procedure TShuffler.FormCreate(Sender: TObject);
    begin
      rW := Screen.Width div DELTA;
      rH := Screen.Height div DELTA;
     
      redRect:=TBitmap.Create;
      with redRect do begin
        Width := rW;
        Height := rH;
        Canvas.Brush.Color := clRed;
        Canvas.Brush.Style := bssolid;
        Canvas.Rectangle(0,0,rW,rH);
        Canvas.Font.Color := clNavy;
        Canvas.Font.Style := Canvas.Font.Style + [fsBold];
        Canvas.TextOut(2,2,'About');
        Canvas.Font.Style := Canvas.Font.Style - [fsBold];
        Canvas.TextOut(2,17,'Delphi');
        Canvas.TextOut(2,32,'Programming');
      end;
     
      Timer1.Enabled := False;
      Image1.Align := alClient;
      Visible := False;
      BorderStyle := bsNone;
      Top := 0;
      Left := 0;
      Width := Screen.Width;
      Height := Screen.Height;
      InitScreen;
    //  SetWindowPos(Handle,HWND_TOPMOST,0,0,0,0,
                     SWP_NOSIZE + SWP_NOMOVE);
      Visible := True;
      Timer1.Interval := 10; // меньше := быстрее
      Timer1.Enabled  := True; // Запускаем вызов DrawScreen
    end;

Во-первых, значения rW и rH определяются значением DELTA. Как уже
объяснялось, если разрешение экрана 800x600 и DELTA равна 8, изображение
экрана будет разделено на 8x8 частей размером 100x75 (rW = 100, rH =
75).

Во-вторых, созданный битмап redRect, будет размещён внутри картинки, с
той целью, чтобы заменить перемещённый блок. redRect является простым
красным прямоугольником с текстом (синим) внутри него. Так же для этого
можно использовать готовую эмблему или что-то ещё.

Наконец, устанавливается ширина и высота формы как у экрана. Вызов
(закомментированный) API функции SetWindowPos можно использовать, чтобы
установить форму всегда на переднем плане (OnTop), не перемещаемую и не
изменяемую. Вызывается процедура InitScreen. Устанавливает интервал
таймера и начинает выполняться обработчик события OnTimer, запуская
процедуру DrawScreen.

**InitScreen - Скриншот**

Процедура InitScreen, вызываемая из обработчика события OnCreate,
используется для получения скриншота текущего изображения десктопа,
устанавливая начальную позицию redRect и рисуя сетку. Код, который будет
рисовать сетку необязателен.

Чтобы получить скриншот десктопа, используется GetDC для
GetDesktopWindow. API функция BitBt используется для передачи картинки
десктопа в DesktopBitmap. GetDC(GetDesktopWindow) получает дескриптор
контекста устройства дисплея для указанного окна - окна возвращённого
функцией GetDesktopWindow. В заключении DesktopBitmap ассоциируется с
компонентой Image1. Если что-то не ясно, то советую заглянуть справичные
файлы по Delphi.

Начальная позиция redRect выбирается случайным образом. Trunc(Random *
DELTA) возвращает целое число от 0 до DELTA. Далее, redRect рисуется в
точке gx, gy, используя функцию CopyRect объекта Canvas. Опять же, если
Вы не знакомы с алгоритмом рисования Delphi, то советую порыться в
справке.

В конце, при помощи MoveTo и LineTo рисуется сетка. Сетка необязательна
и используется только для того, чтобы лучше различать границы блоков.

    procedure InitScreen;
    var i,j:integer;
    begin
      //получаем битмап десктопа
      DesktopBitmap := TBitmap.Create;
      with DesktopBitmap do begin
        Width := Screen.Width;
        Height := Screen.Height;
      end;
      BitBlt(DesktopBitmap.Canvas.Handle,
             0,0,Screen.Width,Screen.Height,
             GetDC(GetDesktopWindow),0,0,SrcCopy);
     
      Shuffler.Image1.Picture.Bitmap := DesktopBitmap;
     
      //изначальные координаты redRect
      Randomize;
      gx := Trunc(Random * DELTA);
      gy := Trunc(Random * DELTA);
     
      Shuffler.Image1.Canvas.CopyRect(
        Rect(rW * gx, rH * gy, rW * gx + rW, rH * gy + rH),
        redRect.Canvas,
        Rect(0,0,rW,rH));
     
      //рисуем сетку
      for i:=0 to DELTA-1 do begin
        Shuffler.Image1.Canvas.MoveTo(rW * i,0);
        Shuffler.Image1.Canvas.LineTo(rW * i,Screen.Height);
     
        Shuffler.Image1.Canvas.MoveTo(0, rH * i);
        Shuffler.Image1.Canvas.LineTo(Screen.Width, rH * i);
      end;
    end;


**Draw Screen**

Основной код находится в процедуре DrawScreen. Эта процедура вызывается
внутри события OnTimer компонента Timer.

    procedure DrawScreen;
    var
      r1,r2:TRect;
      Direction:integer;
    begin
      r1:=Rect(rW * gx, rH * gy,  rW * gx + rW , rH * gy + rH);
     
      Direction := Trunc(Random*4);
      case Direction of
       0: gx := Abs((gx + 1) MOD DELTA);    //право
       1: gx := Abs((gx - 1) MOD DELTA);    //лево
       2: gy := Abs((gy + 1) MOD DELTA);    //низ
       3: gy := Abs((gy - 1) MOD DELTA);    //верх
      end; //case
     
      r2 := Rect(rW * gx, rH * gy,  rW * gx + rW , rH * gy + rH);
     
      with Shuffler.Image1.Canvas do begin
        CopyRect(r1, Shuffler.Image1.Canvas, r2);
        CopyRect(r2, redRect.Canvas, redRect.Canvas.ClipRect);
      end;
    end;

Несмотря на кажущуюся сложность кода, он очень прост в использовании.
Менять местами можно только части смежные с redRect, поэтому доступны
только 4 возможных направления. Прямоугольник r1 содержит текущию
позицию redRect, r2 указывает на прямоугольник с блоком, который был
перемещён. CopyRect используется для перемещения выбранного блока на
место redRect и рисования redRect его в новом месте - таким образом
осуществляется обмен этих двух блоков.

Было бы приятней наблюдать анимированный обмен блоков, но я оставлю эту
задачу для самостоятельного решения.

А так выглядит мой десктоп 640x480, после нескольких событий OnTimer, с
DELTA=4. Обычно у меня разрешение 1024x768, но для того, чтобы картинка
получилась лучше, я изменил свойства дисплея. Обратите внимание, что Вы
можете в любой момент прервать выполнение программы нажатием ALT+F4.
Здесь можно посмотреть код проекта.

**В заключение**

Вероятно вы встречались с подобными эффектами в виде скринсейвера. Если
возникнет желание создать что-то подобное, то дополнительную информацию
можно посмотреть в статье "Пишем Screensaver в Delphi".

Так же данный код может послужить отправной точкой для создания
популярной игры "Пятнашки" или "Ppuzzle". Всё, что необходимо для
этого изменить в коде, это остановить через какое-то время подпрограмму
DrawScreen, чтобы получить картинку паззла. Идея игры заключается в том,
чтобы сделать возможным перемещение блоков обратно. В общих чертах,
необходимо добавить код, который бы получал и обрабатывал клики
пользователя на разобранной картинке. Клик по блоку, следующему за
redRect должен заменить блок на redRect.

