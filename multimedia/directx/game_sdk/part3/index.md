---
Title: DirectX (Игровой SDK) 3
Date: 01.01.2007
---


DirectX (Игровой SDK) 3
=======================

::: {.date}
01.01.2007
:::

Листинг 10 функция MakeltSo для оказание помощи в восстановлении
поверхности.

    function TForinl.MakeltSo(DDResult: HResult): boolean;
    begin
      { утилита для предоставления помощи в восстановлении поверхностей }
      case DDResult of
        DD_OK: Result := true;
        DDERR_SURFACELOST: Result := RestoreSurfaces <> DD_OK;
      else
        Result := DDResult <> DDERR_WASSTILLDRAWING;
      end;
    end;

Последний метод иосстанаиливает поцерхность i3 случае необходимости и
затем вызывает функцию RestoreSurface, которую я вам сейчас представлю.
Но сначала вот как следует ее использовать, применяя Flip, как в
предыдущем примере:

    repeat
      ...
    until
      MakeltSo(PrimarySurf асе.Flip(nil, DDFblP_WAIT));

Теперь я уверен, вы согласитесь, что это намного аккуратней и приятней,
чем постоянно дублировать код, который я продемонстрировал ранее. Flip
вызывается непрерывно, пока не достигнет успеха, либо пока не возникнет
серьезная про блема. Я мог бы вызвать исключение в MakeltSo, если бы
возникла неисправимая проблема. Примеры Game SDK, будучи написанными на
С без обработки исключений, просто игнорируют результаты ошибки. Однако,
если вы хотите использовать исключения, измените MakeltSo, как показано
в листинге 11.

Листинг 11 Необязательная MakeltSo, которая вызывает исключения.

    function TFormI.MakeltSo(DDResult: HResult): boolean;
    begin
      { утилита для предоставления помощи в восстановлении
      поверхностей - версия с исключениями }
      Result := false;
      case DDResult of
        DD_OK: Result := true;
        DDEKR_SURFACELOST: if RestoreSurfaces <> DD_OK then
            raise Exception.Create('MakeltSo failed');
      else if DDResult <> DDERR_WASSTILLDRAWING then
        raise Exception.Create('MakeltSo failed');
      end;
    end;

Хорошо, теперь перейдем к методу RestoreSurfaces, при необходимости
вызываемому в MakeltSo. Листинг 12 показывает метод RestoreSurfaces.

Листинг 12 Восстановление и перерисовка поверхности DirectDraw.

    function TFormI.RestoreSurfaces: HResult;
    begin
      { вызывается MakeltSo, если поверхности "потерялись" -
      восстановить и перерисовать их }
      Result := PrimarySurface.Restore;
      if Result = DD_OK then
        DrawSurfaces;
    end;

Ничего удивительного. Вызывается метод Restore объекта основной
поверхности. Ввиду того, что вы создали ее как комплексный объект, он
автоматически восстанавливает любые неявные поверхности. Поэтому нет
необходимости вызывать Restore для фонового буфера. Если Restore успешно
восстановил память поверхности, вы вызываете DrawSurfaces, которую мы
обсудим подробно далее.

Рисование на поверхностям DirectDraw

Существует два способа рисовать на поверхности DirectDraw. Вы можете
получить указатель непосредственно на область памяти поверхности и
непосредственно ею манипулировать. Это очень мощный способ, но требует
написания специального кода и часто для скорости - на ассемблере.
Все-таки вам редко придется это делать, потому что DirectDraw может
создавать контекст устройства (DC), совместимый с GDI. Это означает, что
вы можете рисовать на ней, используя стандартные вызовы GDI, а также
любой DC. Однако, вызовы GDI достаточно утомительны, и Delphi уже
включает DC в свой класс TCanvas. Таким образом, в примере я создаю
TCanvas и использую его для облегчения себе жизни. Разве невозможно
полюбить Delphi за это!

Все, что необходимо сделать, - создать объект TCanvas и вызвать метод
GetDC поверхности. Затем вы назначаете DCCanvas.Handle, убедившись, что
вы по завершению переустановили Handle в ноль. Создание полотна и
размещение контекстов устройств требует памяти и ресурсов. Контексты
устройства представляют собой особенно скудный ресурс. Существенно важно
освободить их, когда вы закончите. Для того, чтобы сделать код
непробиваемым, используйте блоки try...finally.

Листинг 13 представляет этот код. Он просто заполняет основную
поверхность голубым цветом и выводит текст "Primary surface" (Основная
поверхность) в центре слева. Фоновый буфер закрашивается в красный цвет
и содержит текст "Back buffer" (Фоновый буфер) в центре справа.
Листинг 13 с примером DDDemo4 можно скачать здесь.

Листинг 13 Данная процедура заполняет основную поверхность голубым
цветом и выводит текст "Primary surface" (Основная поверхность) в
центре слева. Фоновый буфер закрашивается в красный цвет и содержит
текст "Back buffer" (Фоновый буфер) в центре справа.

    procedure TForm1.DrawSurfaces;
    var
      DC: HDC;
      ARect: TRect;
      DDCanvas: TCanvas;
      ATopPos: integer;
    begin
      // fill the primary surface with red and the back buffer with blue
      // and put some text on each. Using a canvas makes this trivial.
      DDCanvas := TCanvas.Create;
      try
        // first output to the primary surface
        if PrimarySurface.GetDC(DC) = DD_OK then
        try
          ARect := Rect(0, 0, 640, 480);
          with DDCanvas do
          begin
            Handle := DC; // make the canvas output to the DC
            Brush.Color := clRed;
            FillRect(ARect);
            Brush.Style := bsClear; // transparent text background
            Font.Name := 'Arial';
            Font.Size := 24;
            Font.Color := clWhite;
            ATopPos := (480 - TextHeight('A')) div 2;
            TextOut(10, ATopPos, 'Primary surface');
          end;
        finally
          // make sure we tidy up and release the DC
          DDCanvas.Handle := 0;
          PrimarySurface.ReleaseDC(DC);
        end;
     
        // now do back buffer
        if BackBuffer.GetDC(DC) = DD_OK then
        try
          with DDCanvas do
          begin
            Handle := DC; // make the canvas output to the DC
            Brush.Color := clBlue;
            FillRect(ARect);
            Brush.Style := bsClear; // transparent text background
            Font.Name := 'Arial';
            Font.Size := 24;
            Font.Color := clWhite;
            TextOut(630 - TextWidth('Back buffer'), ATopPos, 'Back buffer');
          end;
        finally
          // make sure we tidy up and release the DC
          DDCanvas.Handle := 0;
          BackBuffer.ReleaseDC(DC);
        end;
      finally
        // make sure the canvas is freed
        DDCanvas.Free;
      end;
    end;

Непригодность основной формы

В предыдущих примерах форма была явно видима, заполняя собой основную
поверхность. Однако, вы не хотите, чтобы пользователь видел форму. Это
приложение смены страниц и оно рисует по всему экрану. Поэтому вы должны
предотвратить отображение формы на экране. Также необходимо избавиться
от системного меню и неклиентских клавиш. Все это можно достичь просто
установкой BorderStyle формы в bsNone в методе Foi-rnCreate. Вам также
не нужен и курсор, поэтому установите его в crNone. Добавьте эти три
строки к FormCreate:

    BorderStyle := bsNone;
    Color := clBlack;
    Cursor := crNone;

Единственно, что остается сделать, - убедиться ц том, что поверхности
рисуются правильно и самом начале. Сделайте проверку, вызвав
DrawSurfaces в обработчике события OnPaint формы. Если вы этого не
сделаете, основная поверхность изначально отобразит форму; то есть,
экран будет полностью черным. Листинг 14 представляет обработчик события
OnPaint формы.

Листинг 14 Обработчик события OnPaint просто вызывает DrawSurfaces.

    procedure TForml.FormPaint(Sender: TObject);
    begin
      // рисовать что-нибудь на основной поверхности и на фоновом буфере
      DrawSurfaces;
    end;

Ну, все! Вы можете найти измененный код в примере DDDemo4(скачать).

Мощь Delphi: пользовательский класс полотна (Canvas)

До этого вы наблюдали, как использовать прекрасное средство Delphi
TCanvas для получения доступа к контексту устройства, который позволяет
рисовать на поверхности DirectDraw. Однако, мы можем значительно все
упростить благодаря применению объектной ориентации. Сейчас вы создадите
специализированный (пользовательский) подкласс TCanvas для того, чтобы
иметь возможность рисовать на поверхности даже намного проще. Это очень
просто; код представлен в листинге 15.

Листинг 15 Объект полотна DirectDraw в Delphi.

    unit DDCanvas;
     
    interface
     
    uses Windows, SysUtils, Graphics, DDraw;
     
    type
      TDDCanvas = class(TCanvas)
      private
        FSurface: IDirectDrawSurface;
        FDeviceContext: HDC;
      protected
        procedure CreateHandle; override;
      public
        constructor Create(Asurface: IDirectDrawSurface);
        destructor Destroy; override;
        procedure Release;
      end;
     
    implementation
     
    constructor TDDCanvas.Create(Asurface: IDirectDrawSurface);
    begin
      inherited Create;
      if Asurface = nil then
        raise Exception.Create('Cannot create canvas for NIL surface');
      FSurface := Asurface;
    end;
     
    destructor TDDCanvas.Destroy;
    begin
      Release;
      inherited Destroy;
    end;
     
    procedure TDDCanvas.CreateHandle;
    begin
      if FDeviceContext = 0 then
      begin
        FSurface.GetDC(FDeviceContext);
        Handle := FDeviceContext;
      end;
    end;
     
    procedure TDDCanvas.Release;
    begin
      if FDeviceContext <> 0 then
      begin
        Handle := 0;
        FSurface.ReleaseDC(FDeviceContext)
          FDeviceContext := 0;
      end;
    end;
     
    end.
     
     
