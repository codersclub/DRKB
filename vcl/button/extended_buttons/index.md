---
Title: Расширяем возможности кнопок в Delphi
Author: Maarten de Haan
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Расширяем возможности кнопок в Delphi
=====================================

Пример показывает, как сделать кнопку с тремя состояниями. В обычном
состоянии она сливается с формой. При наведении на такую кнопку курсором
мышки, она становится выпуклой. Ну и, соотвественно, при нажатии, кнопка
становится вогнутой.

Также можно создать до 4-х изображений для индикации состояния кнопки

    <--------- Ширина --------->
    +------+------+-----+------+    ^
    |Курсор|Курсор|нажа-|недос-|    |
    |на кно|за пре| та  |тупна |  Высота
    | пке  |делами|     |      |    |
    +------+------+-----+------+    v

Вы также можете присвоить кнопке текстовый заголовок. Можно расположить
текст и изображение в любом месте кнопки. Для этого в пример добавлены
четыре свойства:

- TextTop и TextLeft, Для расположения текста заголовка на кнопке,
- GlyphTop и GlyphLeft, Для расположения Glyph на кнопке.

Текст заголовка прорисовывается после изображения, потому что они
используют одно пространство кнопки, и соответственно заголовок
прорисуется поверх изображения. Бэкграунд текста сделан прозрачным.
Соответственно мы увидим только текстовые символы поверх изображения.

**Найденные баги:**

1) Если двигать мышку очень быстро, то кнопка может не вернуться в
исходное состояние

2) Если кнопка находится в запрещённом состоянии, то при нажатии на неё,
будет наблюдаться неприятное мерцание.

    Unit NewButton; 
     
    Interface 
     
    Uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, 
      Forms, Dialogs; 
     
    Const 
       fShift = 2; // Изменяем изображение и заголовок, когда кнопка нажата.
       fHiColor = $DDDDDD; // Цвет нажатой кнопки (светло серый) 
                   // Windows создаёт этот цвет путём смешивания пикселей clSilver и clWhite (50%). 
                   // такой цвет хорошо выделяет нажатую и отпущенную кнопки.
     
    Type 
      TNewButton = Class(TCustomControl) 
      Private 
        { Private declarations } 
        fMouseOver,fMouseDown              : Boolean; 
        fEnabled                          : Boolean; 
                                          // То же, что и всех компонент   
        fGlyph                            : TPicture; 
                                          // То же, что и в SpeedButton 
        fGlyphTop,fGlyphLeft              : Integer; 
                                          // Верх и лево Glyph на изображении кнопки
        fTextTop,fTextLeft                : Integer; 
                                          // Верх и лево текста на изображении кнопки 
        fNumGlyphs                        : Integer; 
                                          // То же, что и в SpeedButton 
        fCaption                          : String; 
                                          // Текст на кнопке 
        fFaceColor                        : TColor; 
                                          // Цвет изображения (да-да, вы можете задавать цвет изображения кнопки 
     
        Procedure fLoadGlyph(G : TPicture); 
        Procedure fSetGlyphLeft(I : Integer); 
        Procedure fSetGlyphTop(I : Integer); 
        Procedure fSetCaption(S : String); 
        Procedure fSetTextTop(I : Integer); 
        Procedure fSetTextLeft(I : Integer); 
        Procedure fSetFaceColor(C : TColor); 
        Procedure fSetNumGlyphs(I : Integer); 
        Procedure fSetEnabled(B : Boolean); 
     
      Protected 
        { Protected declarations } 
        Procedure Paint; override; 
        Procedure MouseDown(Button: TMouseButton; Shift: TShiftState; 
          X, Y: Integer); override; 
        Procedure MouseUp(Button: TMouseButton; Shift: TShiftState; 
          X, Y: Integer); override; 
        Procedure WndProc(var Message : TMessage); override; 
        // Таким способом компонент определяет - находится ли курсор мышки на нём или нет
        // Если курсор за пределами кнопки, то она всё равно продолжает принимать сообщения мышки.
        // Так же кнопка будет принимать сообщения, если на родительском окне нет фокуса. 
     
      Public 
        { Public declarations } 
        Constructor Create(AOwner : TComponent); override; 
        Destructor Destroy; override; 
     
      Published 
        { Published declarations } 
        {----- Properties -----} 
        Property Action; 
        // Property AllowUp не поддерживается 
        Property Anchors; 
        Property BiDiMode; 
        Property Caption : String 
           read fCaption write fSetCaption; 
        Property Constraints; 
        Property Cursor; 
        // Property Down не поддерживается 
        Property Enabled : Boolean 
           read fEnabled write fSetEnabled; 
        // Property Flat не поддерживается 
        Property FaceColor : TColor 
           read fFaceColor write fSetFaceColor; 
        Property Font; 
        property Glyph : TPicture // Такой способ позволяет получить серую кнопку, которая сможет
                                  //   находиться в трёх положениях. 
                                  // После нажатия на кнопку, с помощью редактора картинок Delphi 
                                  // можно будет создать картинки для всех положений кнопки.. 
           read fGlyph write fLoadGlyph; 
        // Property GroupIndex не поддерживается 
        Property GlyphLeft : Integer 
           read fGlyphLeft write fSetGlyphLeft; 
        Property GlyphTop : Integer 
           read fGlyphTop write fSetGlyphTop; 
        Property Height; 
        Property Hint; 
        // Property Layout не поддерживается 
        Property Left; 
        // Property Margin не поддерживается 
        Property Name; 
        Property NumGlyphs : Integer 
           read fNumGlyphs write fSetNumGlyphs; 
        Property ParentBiDiMode; 
        Property ParentFont; 
        Property ParentShowHint; 
        // Property PopMenu не поддерживается 
        Property ShowHint; 
        // Property Spacing не поддерживается 
        Property Tag; 
        Property Textleft : Integer 
           read fTextLeft write fSetTextLeft; 
        Property TextTop : Integer 
           read fTextTop write fSetTextTop; 
     
        Property Top; 
        // Property Transparent не поддерживается 
        Property Visible; 
        Property Width; 
        {--- События ---} 
        Property OnClick; 
        Property OnDblClick; 
        Property OnMouseDown; 
        Property OnMouseMove; 
        Property OnMouseUp; 
      end; 
     
    Procedure Register; // Hello 
     
    Implementation 
     
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetEnabled(B : Boolean); 
     
    Begin 
    If B <> fEnabled then 
       Begin 
       fEnabled := B; 
       Invalidate; 
       End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetNumGlyphs(I : Integer); 
     
    Begin 
    If I > 0 then 
       If I <> fNumGlyphs then 
          Begin 
          fNumGlyphs := I; 
          Invalidate; 
          End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetFaceColor(C : TColor); 
     
    Begin 
    If C <> fFaceColor then 
       Begin 
       fFaceColor := C; 
       Invalidate; 
       End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetTextTop(I : Integer); 
     
    Begin 
    If I >= 0 then 
       If I <> fTextTop then 
          Begin 
          fTextTop := I; 
          Invalidate; 
          End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetTextLeft(I : Integer); 
     
    Begin 
    If I >= 0 then 
       If I <> fTextLeft then 
          Begin 
          fTextLeft := I; 
          Invalidate; 
          End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetCaption(S : String); 
     
    Begin 
    If (fCaption <> S) then 
       Begin 
       fCaption := S; 
       SetTextBuf(PChar(S)); 
       Invalidate; 
       End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetGlyphLeft(I : Integer); 
     
    Begin 
    If I <> fGlyphLeft then 
       If I >= 0 then 
          Begin 
          fGlyphLeft := I; 
          Invalidate; 
          End; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.fSetGlyphTop(I : Integer); 
     
    Begin 
    If I <> fGlyphTop then 
       If I >= 0 then 
          Begin 
          fGlyphTop := I; 
          Invalidate; 
          End; 
    End; 
    {--------------------------------------------------------------------} 
    procedure tNewButton.fLoadGlyph(G : TPicture); 
     
    Var 
       I      : Integer; 
     
    Begin 
    fGlyph.Assign(G); 
    If fGlyph.Height > 0 then 
       Begin 
       I := fGlyph.Width div fGlyph.Height; 
       If I <> fNumGlyphs then 
          fNumGlyphs := I; 
       End; 
    Invalidate; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure Register; // Hello 
     
    Begin 
    RegisterComponents('Samples', [TNewButton]); 
    End; 
    {--------------------------------------------------------------------} 
    Constructor TNewButton.Create(AOwner : TComponent); 
     
    Begin 
    Inherited Create(AOwner); 
    { Инициализируем переменные } 
    Height := 37; 
    Width := 37; 
    fMouseOver := False; 
    fGlyph := TPicture.Create; 
    fMouseDown := False; 
    fGlyphLeft := 2; 
    fGlyphTop := 2; 
    fTextLeft := 2; 
    fTextTop := 2; 
    fFaceColor := clBtnFace; 
    fNumGlyphs := 1; 
    fEnabled := True; 
    End; 
    {--------------------------------------------------------------------} 
    Destructor TNewButton.Destroy; 
     
    Begin 
    If Assigned(fGlyph) then 
       fGlyph.Free; // Освобождаем glyph 
    inherited Destroy; 
    End; 
    {--------------------------------------------------------------------} 
    Procedure TNewButton.Paint; 
     
    Var 
       fBtnColor,fColor1,fColor2, 
       fTransParentColor            : TColor; 
       Buffer                      : Array[0..127] of Char; 
       I,J                          : Integer; 
       X0,X1,X2,X3,X4,Y0            : Integer; 
       DestRect                    : TRect; 
       TempGlyph                    : TPicture; 
     
    Begin 
    X0 := 0; 
    X1 := fGlyph.Width div fNumGlyphs; 
    X2 := X1 + X1; 
    X3 := X2 + X1; 
    X4 := X3 + X1; 
    Y0 := fGlyph.Height; 
    TempGlyph := TPicture.Create; 
    TempGlyph.Bitmap.Width := X1; 
    TempGlyph.Bitmap.Height := Y0; 
    DestRect := Rect(0,0,X1,Y0); 
     
    GetTextBuf(Buffer,SizeOf(Buffer)); // получаем caption 
    If Buffer <> '' then 
       fCaption := Buffer; 
     
    If fEnabled = False then 
       fMouseDown := False; // если недоступна, значит и не нажата 
     
    If fMouseDown then 
       Begin 
       fBtnColor := fHiColor; // Цвет нажатой кнопки 
       fColor1 := clWhite;    // Правая и нижняя окантовка кнопки, когда на неё нажали мышкой.
       fColor2 := clBlack;    // Верхняя и левая окантовка кнопки, когда на неё нажали мышкой. 
       End 
    else 
       Begin 
       fBtnColor := fFaceColor; // fFaceColor мы сами определяем 
       fColor2 := clWhite;     // Цвет левого и верхнего края кнопки, когда на неё находится курсор мышки
       fColor1 := clGray;      // Цвет правого и нижнего края кнопки, когда на неё находится курсор мышки
       End; 
     
    // Рисуем лицо кнопки :) 
    Canvas.Brush.Color := fBtnColor; 
    Canvas.FillRect(Rect(1,1,Width - 2,Height - 2)); 
     
    If fMouseOver then 
       Begin 
       Canvas.MoveTo(Width,0); 
       Canvas.Pen.Color := fColor2; 
       Canvas.LineTo(0,0); 
       Canvas.LineTo(0,Height - 1); 
       Canvas.Pen.Color := fColor1; 
       Canvas.LineTo(Width - 1,Height - 1); 
       Canvas.LineTo(Width - 1, - 1); 
       End; 
     
    If Assigned(fGlyph) then  // Bitmap загружен? 
       Begin 
       If fEnabled then       // Кнопка разрешена? 
          Begin 
          If fMouseDown then  // Мышка нажата? 
             Begin 
             // Mouse down on the button so show Glyph 3 on the face 
             If (fNumGlyphs >= 3) then 
                TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                   fGlyph.Bitmap.Canvas,Rect(X2,0,X3,Y0)); 
     
             If (fNumGlyphs < 3) and (fNumGlyphs > 1)then 
                TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                   fGlyph.Bitmap.Canvas,Rect(X0,0,X1,Y0)); 
     
             If (fNumGlyphs = 1) then 
                TempGlyph.Assign(fGlyph); 
     
             // Извините, лучшего способа не придумал... 
             // Glyph.Bitmap.Прозрачность цвета не работает, если Вы выберете в качестве
             // прозрачного цвета clWhite... 
             fTransParentColor := TempGlyph.Bitmap.Canvas.Pixels[0,Y0-1]; 
             For I := 0 to X1 - 1 do 
                For J := 0 to Y0 - 1 do 
                   If TempGlyph.Bitmap.Canvas.Pixels[I,J] = 
                      fTransParentColor then 
                      TempGlyph.Bitmap.Canvas.Pixels[I,J] := fBtnColor; 
             //Рисуем саму кнопку
             Canvas.Draw(fGlyphLeft + 2,fGlyphTop + 2,TempGlyph.Graphic); 
             End 
          else 
             Begin 
             If fMouseOver then 
                Begin 
                // Курсор на кнопке, но не нажат, показываем Glyph 1 на морде кнопки 
                // (если существует) 
                If (fNumGlyphs > 1) then 
                   TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                      fGlyph.Bitmap.Canvas,Rect(0,0,X1,Y0)); 
                If (fNumGlyphs = 1) then 
                   TempGlyph.Assign(fGlyph); 
                End 
             else 
                Begin 
                // Курсор за пределами кнопки, показываем Glyph 2 на морде кнопки (если есть) 
                If (fNumGlyphs > 1) then 
                   TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                      fGlyph.Bitmap.Canvas,Rect(X1,0,X2,Y0)); 
                If (fNumGlyphs = 1) then 
                   TempGlyph.Assign(fGlyph); 
                End; 
             // Извиняюсь, лучшего способа не нашёл... 
             fTransParentColor := TempGlyph.Bitmap.Canvas.Pixels[0,Y0-1]; 
             For I := 0 to X1 - 1 do 
                For J := 0 to Y0 - 1 do 
                   If TempGlyph.Bitmap.Canvas.Pixels[I,J] = 
                      fTransParentColor then 
                      TempGlyph.Bitmap.Canvas.Pixels[I,J] := fBtnColor; 
             //Рисуем bitmap на морде кнопки 
             Canvas.Draw(fGlyphLeft,fGlyphTop,TempGlyph.Graphic); 
             End; 
          End 
       else 
          Begin 
          // Кнопка не доступна (disabled), показываем Glyph 4 на морде кнопки (если существует) 
          If (fNumGlyphs = 4) then 
             TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                fGlyph.Bitmap.Canvas,Rect(X3,0,X4,Y0)) 
          else 
             TempGlyph.Bitmap.Canvas.CopyRect(DestRect, 
                fGlyph.Bitmap.Canvas,Rect(0,0,X1,Y0)); 
          If (fNumGlyphs = 1) then 
             TempGlyph.Assign(fGlyph.Graphic); 
     
          // Извините, лучшего способа не нашлось... 
          fTransParentColor := TempGlyph.Bitmap.Canvas.Pixels[0,Y0-1]; 
          For I := 0 to X1 - 1 do 
             For J := 0 to Y0 - 1 do 
                If TempGlyph.Bitmap.Canvas.Pixels[I,J] = 
                   fTransParentColor then 
                   TempGlyph.Bitmap.Canvas.Pixels[I,J] := fBtnColor; 
          //Рисуем изображение кнопки 
          Canvas.Draw(fGlyphLeft,fGlyphTop,TempGlyph.Graphic); 
          End; 
       End; 
     
    // Рисуем caption 
    If fCaption <> '' then 
       Begin 
       Canvas.Pen.Color := Font.Color; 
       Canvas.Font.Name := Font.Name; 
       Canvas.Brush.Style := bsClear; 
       //Canvas.Brush.Color := fBtnColor; 
       Canvas.Font.Color := Font.Color; 
       Canvas.Font.Size := Font.Size; 
       Canvas.Font.Style := Font.Style; 
     
       If fMouseDown then 
          Canvas.TextOut(fShift + fTextLeft,fShift + fTextTop,fCaption) 
       else 
          Canvas.TextOut(fTextLeft,fTextTop,fCaption); 
       End; 
     
    TempGlyph.Free; // Освобождаем временный glyph 
    End; 
    {--------------------------------------------------------------------} 
    // Нажата клавиша мышки на кнопке ? 
    Procedure TNewButton.MouseDown(Button: TMouseButton; 
       Shift: TShiftState;X, Y: Integer); 
     
    Var 
       ffMouseDown,ffMouseOver : Boolean; 
     
    Begin 
    ffMouseDown := True; 
    ffMouseOver := True; 
    If (ffMouseDown <> fMouseDown) or (ffMouseOver <> fMouseOver) then 
       Begin 
       fMouseDown := ffMouseDown; 
       fMouseOver := ffMouseOver; 
       Invalidate; // не перерисовываем кнопку без необходимости.
       End; 
    Inherited MouseDown(Button,Shift,X,Y);; 
    End; 
    {--------------------------------------------------------------------} 
    // Отпущена клавиша мышки на кнопке ?
    Procedure TNewButton.MouseUp(Button: TMouseButton; Shift: TShiftState; 
          X, Y: Integer); 
     
    Var 
       ffMouseDown,ffMouseOver : Boolean; 
     
    Begin 
    ffMouseDown := False; 
    ffMouseOver := True; 
    If (ffMouseDown <> fMouseDown) or (ffMouseOver <> fMouseOver) then 
       Begin 
       fMouseDown := ffMouseDown; 
       fMouseOver := ffMouseOver; 
       Invalidate; // не перерисовываем кнопку без необходимости. 
       End; 
    Inherited MouseUp(Button,Shift,X,Y); 
    End; 
    {--------------------------------------------------------------------} 
    // Эта процедура перехватывает события мышки, если она даже за пределами кнопки 
    // Перехватываем оконные сообщения 
    Procedure TNewButton.WndProc(var Message : TMessage); 
     
    Var 
       P1,P2 : TPoint; 
       Bo    : Boolean; 
     
    Begin 
    If Parent <> nil then 
       Begin 
       GetCursorPos(P1); // Получаем координаты курсона на экране 
       P2 := Self.ScreenToClient(P1); // Преобразуем их в координаты относительно кнопки
       If (P2.X > 0) and (P2.X < Width) and 
          (P2.Y > 0) and (P2.Y < Height) then 
          Bo := True // Курсор мышки в области кнопки 
       else 
          Bo := False; // Курсор мышки за пределами кнопки 
     
       If Bo <> fMouseOver then // не перерисовываем кнопку без необходимости. 
          Begin 
          fMouseOver := Bo; 
          Invalidate; 
          End; 
       End; 
    inherited WndProc(Message); // отправляем сообщение остальным получателям 
    End; 
    {--------------------------------------------------------------------} 
    End. 
    {====================================================================}

