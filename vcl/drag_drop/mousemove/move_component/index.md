---
Title: Как перемещать компонент во время работы программы?
Author: Олег Кулабухов
Date: 01.01.2007
---


Как перемещать компонент во время работы программы?
===================================================

::: {.date}
01.01.2007
:::

Автор: Олег Кулабухов

Нижеприведенный пример показывает как перемещать компонент при
перетаскивании его нажатой левой кнопкой мыши при нажатом Ctrl.

    procedure TForm1.Button1MouseDown(Sender: TObject; Button:
      TMouseButton; Shift: TShiftState; X, Y: Integer);
    {$IFNDEF WIN32}
    var
      pt: TPoint;
    {$ENDIF}
    begin
      if ssCtrl in Shift then
      begin
        ReleaseCapture;
        SendMessage(Button1.Handle, WM_SYSCOMMAND, 61458, 0);
    {$IFNDEF WIN32}
        GetCursorPos(pt);
        SendMessage(Button1.Handle,
          WM_LBUTTONUP,
          MK_CONTROL,
          Longint(pt));
    {$ENDIF}
      end;
    end;
     
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

Перетаскивание компонентов в окне приложения

Например: перемещение компонентов с помощью мыши по площади формы в
среде разработки Delphi.

Нарисовать в графическом редакторе картинку, сохранить ее в файле с
расширенем .bmp.


Поместить в форме 4 компонента типа TImage.

При создании формы (событие формы onCreate) приложения разделить
созданную картинку на 4 части и поместить каждую в компоненту Image:

    var
      Pict: TImage;
      beginPict := TImage.Create(Self);
      Pict.AutoSize :=
        true;
      Pict.Picture.LoadFromFile('Cus5.bmp');
      Image1.Canvas.CopyRect(Image1.ClientRect,
        Pict.Canvas, Rect(0, 0, Pict.Width div 2, Pict.Height div
        2));
      Image2.Canvas.CopyRect(Image2.ClientRect, Pict.Canvas, Rect(Pict.Width
        div 2, 0, Pict.Width, Pict.Height div
        2));
      Image3.Canvas.CopyRect(Image3.ClientRect, Pict.Canvas, Rect(0, Pict.Height
        div 2, Pict.Width div
        2, Pict.Height));
      Image4.Canvas.CopyRect(Image4.ClientRect,
        Pict.Canvas, Rect(Pict.Width div 2, Pict.Height div 2, Pict.Width,
          Pict.Height
        ));
      Pict.Free;
    end;

Все методы используют глобальные переменные:

    var
      move: boolean; //определяет режим буксировки, она будет устанавливаться
      в True вначале и в False в концеX0, Y0: Integer;
        //запоминание координат курсора мыши

Метод 1:

Буксировка начинается при нажатии левой кнопки мыши на соответствующем
компоненте Image. Поэтому начало определяется событием onMouseDown,
обработчик котрого имеет вид:

    procedure
      TForm1.Image1MouseDown(Sender: TObject; Button: TMouseButton; Shift:
      TShiftState; X, Y: Integer);
    beginif Button <> mbLeft then
      exit;
    X0 := X;
    Y0 := Y;
    move := true;
    (Sender as
      TControl).BringToFront;
    end;

Сначала в этой процедуре проверяется, нажата ли именно левая кнопка
мыши, затем запоминаются координаты мыши именно в этот момент. Задается
режим буксировки -- переменная move := true. Последний оператор
выдвигает методом BringToFront компонент, в котором произошло событие,
на передний план. Это позволит ему в дальнейшем перемещаться поверх
других аналогичных компонентов.

Во время буксировки компонента работает его обработчик события
onMouseMove, имеющий вид:

    procedure
      TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X, Y:
      Integer);
    beginif move&nbsp;
    then with (Sender as TControl)
      doSetBounds(Left + X - X0, Top + Y - Y0, Width, Height)
      end;

Метод SetBounds изменяет координаты левого верхнего угла на величину
сдвига курсора мыши (X - X0 для координаты X и Y - Y0 для координаты Y).
Тем самым поддерживается постоянное расположение точки курсора в системе
координат компонента, т.е. компонент перемещается вслед за курсором.
Ширина Width и высота Height компонента остаются неизменными.

По окончании буксировки, когда пользователь отпустит кнопку мыши,
наступит событие . Обработчик этого события onMouseUp должен сожержать
всего один оператор:

    procedure TForm1.Image1MouseUp(Sender: TObject; Button:
      TMouseButton; Shift: TShiftState; X, Y: Integer);
    beginmove :=
      false;
    end;

Этот оператор указывает указывает приложению на конец буксировки. Тогода
при последующих событиях onMouseMove их обработчик перестанет изменять
координаты компонента.
Метод 2:

Основной недостаток рассмотренного метода буксировки -- некоторое
дрожание изображения при перемещении. Устранить его можно, если
перемещать не сам компонент, а его контур, при этом сам компонент
перемещается только один раз -- в момент окончания буксировки, когда
требуемое положение уже выбрано. В этом варианта используются методы
рисования на канве. Для их применения требуется еще одна глобальная
переменная:

var

rec: Trect;

Переменная rec будетиспользоваться для запоминания положения
перемещаемого курсора компонента.

Начинается процесс буксировки,как и ранее, с события onMouseDown:

    procedure TForm1.Image4MouseDown(Sender: TObject;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    beginif
      Button <> mbLeft then exit;
    X0 := X;
    &nbsp;
    Y0 := Y;
    rec := (Sender as
      TControl).BoundsRect;
    move := true;
    end;
    Оператор: rec := (Sender as
      TControl).BoundsRect;

запоминает в переменной rec исходное положение компонента. В процедуре
отсутствует также опереатор BringToFront, поскольку сам компонент не
будет перемещаться.

При дальнейшем перемещении мыши срабатывает обработчик события
onMouseMove:

    procedure
      TForm1.Image4MouseMove(Sender: TObject; Shift: TShiftState; X, Y:
      Integer);
    beginif not move then
      exit;
    Canvas.DrawFocusRect(rec);
    with rec dobeginleft := left + X
      - X0;
    right := right + X - X0;
    &nbsp;
    top := top + Y - Y0;
    &nbsp;
    bottom := bottom +
      Y - Y0;
    X0 := X;
    Y0 := Y;
    end;
    Canvas.DrawFocusRect(rec);
    end;

В этой процедуре перерисовывается и сдвигается только прямоугольник
контура компонента с помощью метода DrawFocusRect. Первое обращение к
этому методу стирает прежнее изображение контура, поскольку повторная
прорисовка того же изображения по операции ИЛИ(or) стирает нанесенное
ранее изображение. Затем изменяются значения, хранимые в переменной rec,
и той же функцией DrawFocusRect осуществляется прорисовка сдвинутого
прямоугольника. При этом сам компонент остается на месте.

Когда пользователь отпускает кнопку мыши, наступает событие onMouseUp:

    procedure
      TForm1.Image4MouseUp(Sender: TObject; Button: TMouseButton; Shift:
        TShiftState;
      X, Y: Integer);
    beginCanvas.DrawFocusRect(rec); { if not (ssAlt in
    Shift) then} with (Sender as TControl) do
      beginSetBounds(rec.Left + X -
        X0, rec.Top + Y - Y0, Width, Height);
    BringToFront;
    end;
    move := false;
    end;

Первый ее оператор стирает последнее изображение контура, а второй
оператор перемещает компонент в новую позицию. В обработчике события
onMouseUp можно предусмотреть условияотказа от перемещения: например,
нажатая клавиша Alt (см. оператор в фигурных скобках).

Полный текст приложения:

    unit UMove;
    interfaceusesWindows, Messages,
    SysUtils, Classes, Graphics, Controls, Forms, Dialogs, Menus, ExtCtrls,
    ExtDlgs;
    typeTForm1 = class(TForm)Image1: TImage;
      Image2:
      TImage;
      Image3: TImage;
      Image4: TImage;
      procedure
        Image1MouseDown(Sender: TObject; Button: TMouseButton; Shift: TShiftState;
          X,
        Y: Integer);
      procedure Image1MouseMove(Sender: TObject; Shift: TShiftState;
        X, Y: Integer);
      procedure Image1MouseUp(Sender: TObject; Button:
        TMouseButton; Shift: TShiftState; X, Y: Integer);
      procedure
        FormCreate(Sender: TObject);
      procedure Image4MouseDown(Sender: TObject;
        Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
      procedure
        Image4MouseMove(Sender: TObject; Shift: TShiftState; X, Y:
        Integer);
      procedure Image4MouseUp(Sender: TObject; Button:
        TMouseButton; Shift: TShiftState; X, Y: Integer);
    private { Private
    declarations } public { Public declarations }
    end;
    varForm1:
    TForm1;
    implementation{$R *.DFM}var
      move: boolean;
      X0, Y0:
      Integer;
      rec: Trect;
     
    procedure TForm1.Image1MouseDown(Sender: TObject;
      Button: TMouseButton; Shift: TShiftState; X, Y: Integer);
    beginif
      Button <> mbLeft then exit;
    X0 := X;
    Y0 := Y;
    move :=
      true;
    (Sender as TControl).BringToFront;
    end;
     
    procedure
      TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X, Y:
      Integer);
    beginif move then with (Sender as TControl)
      doSetBounds(Left + X - X0, Top + Y - Y0, Width,
      Height)
    end;
     
    procedure TForm1.Image1MouseUp(Sender: TObject; Button:
      TMouseButton; Shift: TShiftState; X, Y: Integer);
    beginmove :=
      false;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      Pict: TImage;
      beginPict := TImage.Create(Self);
      Pict.AutoSize :=
        true;
      Pict.Picture.LoadFromFile('Cus5.bmp');
      Image1.Canvas.CopyRect(Image1.ClientRect,
        Pict.Canvas, Rect(0, 0, Pict.Width div 2, Pict.Height div
        2));
      Image2.Canvas.CopyRect(Image2.ClientRect, Pict.Canvas, Rect(Pict.Width
        div 2, 0, Pict.Width, Pict.Height div
        2));
      Image3.Canvas.CopyRect(Image3.ClientRect, Pict.Canvas, Rect(0, Pict.Height
        div 2, Pict.Width div
        2, Pict.Height));
      Image4.Canvas.CopyRect(Image4.ClientRect,
        Pict.Canvas, Rect(Pict.Width div 2, Pict.Height div 2, Pict.Width,
          Pict.Height
        ));
      Pict.Free;
    end;
     
    procedure TForm1.Image4MouseDown(Sender:
      TObject; Button: TMouseButton; Shift: TShiftState; X, Y:
      Integer);
    beginif Button <> mbLeft then exit;
    X0 := X;
    Y0 :=
      Y;
    rec := (Sender as TControl).BoundsRect;
    move :=
      true;
    end;
     
    procedure TForm1.Image4MouseMove(Sender: TObject; Shift:
      TShiftState; X, Y: Integer);
    beginif not move then
      exit;
    Canvas.DrawFocusRect(rec);
    with rec dobeginleft := left + X
      - X0;
    right := right + X - X0;
    top := top + Y - Y0;
    bottom :=
      bottom + Y - Y0;
    X0 := X;
    Y0 :=
      Y;
    end;
    Canvas.DrawFocusRect(rec);
    end;
     
    procedure
      TForm1.Image4MouseUp(Sender: TObject; Button: TMouseButton; Shift:
        TShiftState;
      X, Y: Integer);
    beginCanvas.DrawFocusRect(rec);
    if not (ssAlt in
      Shift)thenwith(Sender as TControl) do beginSetBounds(rec.Left + X -
      X0, rec.Top + Y - Y0, Width, Height);
    BringToFront;
    end;
    move :=
    false;
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

 

------------------------------------------------------------------------

Перетаскивание элементов управления c рамкой контура

...как перетаскивать элементы управления с контурной рамкой по их
форме, \"приклеенной\" к курсору? Решение, найденное вами, работать не
будет, поскольку таскаемая рамка не обязательно может находиться в
пределах области компонента (а вы отрисовываете ее только на
компоненте).

В общих чертах, вы должны рисовать на всей поверхности формы и даже
рабочего стола, для чего необходимо сделать растровую КОПИЮ окна или
десктопа и рисовать на ней. Вот что нам нужно.

Начните со свеженькой формы. Бросьте на нее компонент Notebook и
установите его свойство Align в alClient. Разработайте форму на первой
странице компонента Notebook. Создайте вторую страницу в Notebook,
поместите туда Paintbox и установите его свойство Align в alClient.
Далее добавьте нижеследующие строчки в секцию Private вашей формы:

    Img : TBitmap;
    DragX, DragY, DragW, DragH, XOff, YOff : Integer;

В обработчике формы OnCreate:

    Img := TBitmap.Create;

В общем, для всех перетаскиваемых компонентов, обработчике события
OnMouseDown:

    IF NOT (ssShift IN Shift) THEN Exit;
    Img := GetFormImage;
    Notebook1.PageIndex := 1;
    WITH Sender AS TControl DO
    BEGIN
    DragW := Width;
    DragH := Height;
    XOff:= X;
    YOff := Y;
    BeginDrag(True);
    END;

В общем, для всех перетаскиваемых компонентов, обработчике события
EndDrag:

    Notebook1.PageIndex := 0;
    WITH Sender AS Tcontrol DO
    BEGIN
    Left := X-Xoff;
    Top := Y-YOff;
    END;

Поместите следующую строку в обработчик события OnPaint компонента
PaintBox:

PaintBox1.Canvas.Draw(0, 0, Img);

И наконец, если вам еще это не надоело, поместите следующую строчку в
обработчик OnDragOver компонента PaintBox:

    IF (X=DragX) AND (Y=DragY) THEN Exit;
    WITH PaintBox1.Canvas DO
    BEGIN
    DrawFocusRect(Bounds(DragX-XOff, DragY-YOff, DragW, DragH);
    DragX := X; DragY := Y;
    DrawFocusRect(Bounds(DragX-XOff, DragY-YOff, DragW, DragH);
    END;

ФУ!! Но это работает! Я не хотел убирать в компонентах возможность
перетаскивания их мышью обычным способом, поэтому для включения
дополнительной характеристики необходимо при старте держать нажатой
клавишу Shift. Попробуйте это!

Я пытаюсь \"потаскать\" TPanel, используемую в качестве ToolBar и всегда
почему-то получаю иконку с перечеркнутым кругом. Я понимаю, что это
означает невозможность перетаскивания. К сожалению, в документации я
ничего не нашел как решить эту проблему. Я пробовал и ручные, и
автоматические настройки (DragMode = dmManual/dmAutomatic - В.О.), но
все без толку.

Иногда я вообще не могу \"оторвать\" TPanel!

Начнем с самого начала. Причина того, что вы получаете курсор
\"crNoDrop\" в том, что под курсором элемент управления не готов принять
перетаскиваемый компонент. Чтобы исправить эту ситуацию, дважды щелкните
(в Инспекторе Объектов) на событии формы или компонента OnDragOver и
установите параметр Accept в, например так:

    procedure TForm1.FormDragOver(Sender, Source: TObject; X, Y: Integer;
    State: TDragState; var Accept: Boolean);
    begin
      Accept := true ;
    end;

Благодарю за пример создания прямоугольника при перетаскивании. Ваши
инструкции помогли мне первое время и я легко интегрировал ваш код в мое
приложение. Но если вы не возражаете, я хотел бы получить другой
небольшой совет .... есть ли возможность во время операции
перетаскивания (PaintBox1DragOver) работать с элементами управления,
находящимимя под PainBox с тем, чтобы они также изменяли курсор и также
могли бы принимать перетаскиваемый элемент? Когда перетаскиваемый
элемент выдает сообщение EndDrag, параметр Target должен быть PaintBox
(логически).

Можно как-то определить, с каким конкретно элементом управления,
расположенным под PainBox, взаимодействует в данный момент
перетаскиваемый элемент (для его акцептования)? Я опять что-то упустил,
но я не знаю как это сделать.

Вы можете получить координаты в методе OnDragOver при сравнении
BoundsRect с областью компонентов. Например, вы не хотите принимать
перетаскиваемый компонент кнопкой, перекрывающей любую другую имеющуюся
кнопку. В обработчике OnDragOver напишите примерно следующее:

    FOR N := 0 TO ComponentCount-1 DO
      IF COmponents[N] IS TButton THEN
        IF IntersectRect(DummyRect, TControl(Components[N]).BoundsRect,
          (Bounds(X-XOff, Y-YOff, DragW, DragH)) >0 THEN
            Accept := False;

В этом случае курсор будет изменяться на перечеркнутый кружок при
пересечении перетаскиваемым элементом границы интересующей вас кнопки.
Вы должны сделать аналогичную логику или в обработчике EndDrag или
OnDragDrop компонента PainBox.

Автор: NEil

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 
