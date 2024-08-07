---
Title: Видоизменяем чекбоксы в Delphi
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Видоизменяем чекбоксы в Delphi
==============================

В WIN3.1 чекбоксы заполняются символом "X". В WIN95 и WINNT - символом
"V". В стандартной палитре Delphi чекбоксы заполняются символом "X".
Спрашивается - почему фирма Borland/Inprise не исправила значок чекбокса
для W95/W98 ?

Данный пример позволяет заполнять чекбокс такими значками
как: "X", "V", "o", "закрашенным прямоугольником", или
бриллиантиком.

Пример тестировался под WIN95 и WINNT.

    { 
    ==================================================================== 
                              Обозначения
    ==================================================================== 
    X = крестик
    V = галочка 
    o = кружок 
     
    +-+ 
    |W| = заполненный прямоугольник 
    +-+ 
     
    /\ 
    = бриллиантик 
    \/ 
     
    ==================================================================== 
                      Преимущества этого чекбокса 
    ==================================================================== 
    Вы можете найти множество чекбоксов в интернете.
    Но у них есть недостаток, они не обрабатывают сообщение WM_KILLFOCUS.
    Приведённый ниже пример делает это. 
    ==================================================================== 
    } 
    Unit CheckBoxX; 
     
    Interface 
     
    Uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, 
      Dialogs, StdCtrls; 
     
    Const 
       { другие константы } 
       fRBoxWidth  : Integer = 13; // ширина квадрата checkbox 
       fRBoxHeight : Integer = 13; // высота квадрата checkbox 
     
    Type 
      TState = (cbUnchecked,cbChecked,cbGrayed); // такой же как в Delphi 
      TType = (cbCross,cbMark,cbBullet,cbDiamond,cbRect); // добавленный 
      TMouseState = (msMouseUp,msMouseDown); 
      TAlignment = (taRightJustify,taLeftJustify); // The same 
     
      TCheckBoxX = class(TCustomControl) 
     
      Private 
        { Private declarations } 
        fChecked        : Boolean; 
        fCaption        : String; 
        fColor          : TColor; 
        fState          : TState; 
        fFont            : TFont; 
        fAllowGrayed    : Boolean; 
        fFocus          : Boolean; 
        fType            : TType; 
        fMouseState     : TMouseState; 
        fAlignment      : TAlignment; 
        fTextTop        : Integer;  // отступ текта с верху 
        fTextLeft       : Integer;  // отступ текта с лева 
        fBoxTop         : Integer;  // координата чекбокса сверху 
        fBoxLeft        : Integer;  // координата чекбокса слева 
     
        Procedure fSetChecked(Bo : Boolean); 
        Procedure fSetCaption(S : String); 
        Procedure fSetColor(C : TColor); 
        Procedure fSetState(cbState : TState); 
        Procedure fSetFont(cbFont : TFont); 
        Procedure fSetAllowGrayed(Bo : Boolean); 
        Procedure fSetType(T : TType); 
        Procedure fSetAlignment(A : TAlignment); 
     
      Protected 
        { Protected declarations } 
        Procedure Paint; override; 
        Procedure MouseDown(Button: TMouseButton; Shift: TShiftState; 
          X, Y: Integer); override; 
        Procedure MouseUp(Button: TMouseButton; Shift: TShiftState; 
          X, Y: Integer); override; 
        Procedure WMKillFocus(var Message : TWMKillFocus); 
          Message WM_KILLFOCUS; // это убирает контур фокуса! 
        Procedure WMSetFocus(var Message : TWMSetFocus); 
          Message WM_SETFOCUS; // Если вы используете клавишу TAB или Shift-Tab 
        Procedure KeyDown(var Key : Word; Shift : TShiftState); override; 
          // перехват KeyDown 
        Procedure KeyUp(var Key : Word; Shift : TShiftState); override; 
          // перехват KeyUp 
     
      Public 
        { Public declarations } 
        // Если поместить Create и Destroy в раздел protected, 
        // то Delphi начинает ругаться. 
        Constructor Create(AOwner : TComponent); override; 
        Destructor Destroy; override; 
     
      Published 
        { Published declarations } 
        { --- Свойства --- } 
        Property Action; 
        Property Alignment : TAlignment 
           read fAlignment write fSetAlignment; 
        Property AllowGrayed : Boolean 
           read fAllowGrayed write fSetAllowGrayed; 
        Property Anchors; 
        Property BiDiMode; 
        Property Caption : String 
           read fCaption write fSetCaption; 
        Property CheckBoxType : TType 
           read fType write fSetType; 
        Property Checked : Boolean 
           read fChecked write fSetChecked; 
        Property Color : TColor 
           read fColor write fSetColor; 
        Property Constraints; 
        //Property Ctrl3D; 
        Property Cursor; 
        Property DragCursor; 
        Property DragKind; 
        Property DragMode; 
        Property Enabled; 
        Property Font : TFont 
           read fFont write fSetFont; 
        //Property Height; 
        Property HelpContext; 
        Property Hint; 
        Property Left; 
        Property Name; 
        //Property PartenBiDiMode; 
        Property ParentColor; 
        //Property ParentCtrl3D; 
        Property ParentFont; 
        Property ParentShowHint; 
        //Property PopMenu; 
        Property ShowHint; 
        Property State : TState 
           read fState write fSetState; 
        Property TabOrder; 
        Property TabStop; 
        Property Tag; 
        Property Top; 
        Property Visible; 
        //Property Width; 
        { --- Events --- } 
        Property OnClick; 
        Property OnContextPopup; 
        Property OnDragDrop; 
        Property OnDragOver; 
        Property OnEndDock; 
        Property OnEndDrag; 
        Property OnEnter; 
        Property OnExit; 
        Property OnKeyDown; 
        Property OnKeyPress; 
        Property OnKeyUp; 
        Property OnMouseDown; 
        Property OnMouseMove; 
        Property OnMouseUp; 
        Property OnStartDock; 
        Property OnStartDrag; 
      End; 
     
    Procedure Register; //Hello! 
     
    Implementation 
     
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.KeyDown(var Key : Word; Shift : TShiftState); 
     
    Begin 
    If fFocus then 
       If Shift = [] then 
          If Key = 0032 then 
             Begin 
             fMouseState := msMouseDown; 
             If fState <> cbGrayed then 
                Begin 
                SetFocus; // Устанавливаем фокус на этот компонент 
                          // всем другим компонентам Windows посылает сообщение WM_KILLFOCUS. 
                fFocus := True; 
                Invalidate; 
                End; 
             End; 
    Inherited KeyDown(Key,Shift); 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.KeyUp(var Key : Word; Shift : TShiftState); 
     
    Begin 
    If fFocus then 
       If Shift = [] then 
          If Key = 0032 then 
             Begin 
             If fState <> cbGrayed then 
                fSetChecked(not fChecked); // Изменяем состояние 
             fMouseState := msMouseUp; 
             End; 
    Inherited KeyUp(Key,Shift); 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.WMSetFocus(var Message : TWMSetFocus); 
     
    Begin 
    fFocus := True; 
    Invalidate; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.WMKillFocus(var Message : TWMKillFocus); 
     
    Begin 
    fFocus := False; // Удаляем фокус у всех компонент, которые не имеют фокуса. 
    Invalidate; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetAlignment(A : TAlignment); 
     
    Begin 
    If A <> fAlignment then 
       Begin 
       fAlignment := A; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetType(T : TType); 
     
    Begin 
    If fType <> T then 
       Begin 
       fType := T; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetFont(cbFont : TFont); 
     
    Var 
       FontChanged : Boolean; 
     
    Begin 
    FontChanged := False; 
     
    If fFont.Style <> cbFont.Style then 
       Begin 
       fFont.Style := cbFont.Style; 
       FontChanged := True; 
       End; 
     
    If fFont.CharSet <> cbFont.Charset then 
       Begin 
       fFont.Charset := cbFont.Charset; 
       FontChanged := True; 
       End; 
     
    If fFont.Size <> cbFont.Size then 
       Begin 
       fFont.Size := cbFont.Size; 
       FontChanged := True; 
       End; 
     
    If fFont.Name <> cbFont.Name then 
       Begin 
       fFont.Name := cbFont.Name; 
       FontChanged := True; 
       End; 
     
    If fFont.Color <> cbFont.Color then 
       Begin 
       fFont.Color := cbFont.Color; 
       FontChanged := True; 
       End; 
     
    If FontChanged then 
       Invalidate; 
    End; 
    {-------------------------------------------------------------------} 
    procedure TCheckBoxX.MouseDown(Button: TMouseButton; Shift: TShiftState; 
      X, Y: Integer); 
     
    Begin 
    // Процедура MouseDown вызывается, когда кнопка мышки нажимается в пределах 
    // кнопки, соответственно мы не можем получить значения координат X и Y. 
    inherited MouseDown(Button, Shift, X, Y); 
    fMouseState := msMouseDown; 
    If fState <> cbGrayed then 
       Begin 
       SetFocus; // Устанавливаем фокус на этот компонент 
                 // всем другим компонентам Windows посылает сообщение WM_KILLFOCUS. 
       fFocus := True; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    procedure TCheckBoxX.MouseUp(Button: TMouseButton; Shift: TShiftState; 
      X, Y: Integer); 
     
    Begin 
    // Процедура MouseUp вызывается, когда кнопка мышки отпускается в пределах 
    // кнопки, соответственно мы не можем получить значения координат X и Y. 
    inherited MouseUp(Button, Shift, X, Y); 
    If fState <> cbGrayed then 
       fSetChecked(not fChecked); // Изменяем состояние 
    fMouseState := msMouseUp; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetAllowGrayed(Bo : Boolean); 
     
    Begin 
    If fAllowGrayed <> Bo then 
       Begin 
       fAllowGrayed := Bo; 
       If not fAllowGrayed then 
          If fState = cbGrayed then 
             Begin 
             If fChecked then 
                fState := cbChecked 
             else 
                fState := cbUnChecked; 
             End; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetState(cbState : TState); 
     
    Begin 
    If fState <> cbState then 
       Begin 
       fState := cbState; 
       If (fState = cbChecked) then 
          fChecked := True; 
     
       If (fState = cbGrayed) then 
          fAllowGrayed := True; 
     
       If fState = cbUnChecked then 
          fChecked := False; 
     
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetColor(C : TColor); 
     
    Begin 
    If fColor <> C then 
       Begin 
       fColor := C; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetCaption(S : String); 
     
    Begin 
    If fCaption <> S then 
       Begin 
       fCaption := S; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    Procedure TCheckBoxX.fSetChecked(Bo : Boolean); 
     
    Begin 
    If fChecked <> Bo then 
       Begin 
       fChecked := Bo; 
       If fState <> cbGrayed then 
          Begin 
          If fChecked then 
             fState := cbChecked 
          else 
             fState := cbUnChecked; 
          End; 
       Invalidate; 
       End; 
    End; 
    {-------------------------------------------------------------------} 
    procedure TCheckBoxX.Paint;
     
    var
      Buffer: array[0..127] of Char;
      I: Integer;
      fTextWidth, fTextHeight: Integer;
     
    begin
    {Get Delphi's componentname and initially write it in the caption}
      GetTextBuf(Buffer, SizeOf(Buffer));
      if Buffer <> '' then
        fCaption := Buffer;
     
      Canvas.Font.Size := Font.Size;
      Canvas.Font.Style := Font.Style;
      Canvas.Font.Color := Font.Color;
      Canvas.Font.Charset := Font.CharSet;
     
      fTextWidth := Canvas.TextWidth(fCaption);
      fTextHeight := Canvas.TextHeight('Q');
     
      if fAlignment = taRightJustify then
        begin
          fBoxTop := (Height - fRBoxHeight) div 2;
          fBoxLeft := 0;
          fTextTop := (Height - fTextHeight) div 2;
          fTextLeft := fBoxLeft + fRBoxWidth + 4;
        end
      else
        begin
          fBoxTop := (Height - fRBoxHeight) div 2;
          fBoxLeft := Width - fRBoxWidth;
          fTextTop := (Height - fTextHeight) div 2;
          fTextLeft := 1;
          //If fTextWidth > (Width - fBoxWidth - 4) then
          //   fTextLeft := (Width - fBoxWidth - 4) -  fTextWidth;
        end;
     
      // выводим текст в caption
      Canvas.Pen.Color := fFont.Color;
      Canvas.Brush.Color := fColor;
      Canvas.TextOut(fTextLeft, fTextTop, fCaption);
     
      // Рисуем контур фокуса
      if fFocus = True then
        Canvas.DrawFocusRect(Rect(fTextLeft - 1,
          fTextTop - 2,
          fTextLeft + fTextWidth + 1,
          fTextTop + fTextHeight + 2));
     
      if (fState = cbChecked) then
        Canvas.Brush.Color := clWindow;
     
      if (fState = cbUnChecked) then
        Canvas.Brush.Color := clWindow;
     
      if (fState = cbGrayed) then
        begin
          fAllowGrayed := True;
          Canvas.Brush.Color := clBtnFace;
        end;
     
      // Создаём бокс clBtnFace когда кнопка мыши нажимается
      // наподобие "стандартного" CheckBox
      if fMouseState = msMouseDown then
        Canvas.Brush.Color := clBtnFace;
     
      Canvas.FillRect(Rect(fBoxLeft + 2,
        fBoxTop + 2,
        fBoxLeft + fRBoxWidth - 2,
        fBoxTop + fRBoxHeight - 2));
     
      // Рисуем прямоугольный чекбокс
      Canvas.Brush.Color := clBtnFace;
      Canvas.Pen.Color := clGray;
      Canvas.MoveTo(fBoxLeft + fRBoxWidth - 1, fBoxTop);
      Canvas.LineTo(fBoxLeft, fBoxTop);
      Canvas.LineTo(fBoxLeft, fBoxTop + fRBoxHeight);
     
      Canvas.Pen.Color := clWhite;
      Canvas.MoveTo(fBoxLeft + fRBoxWidth - 1, fBoxTop);
      Canvas.LineTo(fBoxLeft + fRBoxWidth - 1,
        fBoxTop + fRBoxHeight - 1);
      Canvas.LineTo(fBoxLeft - 1, fBoxTop + fRBoxHeight - 1);
     
      Canvas.Pen.Color := clBlack;
      Canvas.MoveTo(fBoxLeft + fRBoxWidth - 3, fBoxTop + 1);
      Canvas.LineTo(fBoxLeft + 1, fBoxTop + 1);
      Canvas.LineTo(fBoxLeft + 1, fBoxTop + fRBoxHeight - 2);
     
      Canvas.Pen.Color := clBtnFace;
      Canvas.MoveTo(fBoxLeft + fRBoxWidth - 2, fBoxTop + 1);
      Canvas.LineTo(fBoxLeft + fRBoxWidth - 2,
        fBoxTop + fRBoxHeight - 2);
      Canvas.LineTo(fBoxLeft, fBoxTop + fRBoxHeight - 2);
     
      // Теперь он должен быть таким же как чекбокс в Delphi
     
      if fChecked then
        begin
          Canvas.Pen.Color := clBlack;
          Canvas.Brush.Color := clBlack;
     
          // Рисуем прямоугольник
          if fType = cbRect then
            begin
              Canvas.FillRect(Rect(fBoxLeft + 4, fBoxTop + 4,
                fBoxLeft + fRBoxWidth - 4, fBoxTop + fRBoxHeight - 4));
            end;
     
          // Рисуем значёк "о"
          if fType = cbBullet then
            begin
              Canvas.Ellipse(fBoxLeft + 4, fBoxTop + 4,
                fBoxLeft + fRBoxWidth - 4, fBoxTop + fRBoxHeight - 4);
            end;
     
          // Рисуем крестик
          if fType = cbCross then
            begin
          {Right-top to left-bottom}
              Canvas.MoveTo(fBoxLeft + fRBoxWidth - 5, fBoxTop + 3);
              Canvas.LineTo(fBoxLeft + 2, fBoxTop + fRBoxHeight - 4);
              Canvas.MoveTo(fBoxLeft + fRBoxWidth - 4, fBoxTop + 3);
              Canvas.LineTo(fBoxLeft + 2, fBoxTop + fRBoxHeight - 3);
              Canvas.MoveTo(fBoxLeft + fRBoxWidth - 4, fBoxTop + 4);
              Canvas.LineTo(fBoxLeft + 3, fBoxTop + fRBoxHeight - 3);
          {Left-top to right-bottom}
              Canvas.MoveTo(fBoxLeft + 3, fBoxTop + 4);
              Canvas.LineTo(fBoxLeft + fRBoxWidth - 4,
                fBoxTop + fRBoxHeight - 3);
              Canvas.MoveTo(fBoxLeft + 3, fBoxTop + 3);
              Canvas.LineTo(fBoxLeft + fRBoxWidth - 3,
                fBoxTop + fRBoxHeight - 3); //mid
              Canvas.MoveTo(fBoxLeft + 4, fBoxTop + 3);
              Canvas.LineTo(fBoxLeft + fRBoxWidth - 3,
                fBoxTop + fRBoxHeight - 4);
            end;
     
          // Рисуем галочку
          if fType = cbMark then
            for I := 0 to 2 do
              begin
             {Left-mid to left-bottom}
                Canvas.MoveTo(fBoxLeft + 3, fBoxTop + 5 + I);
                Canvas.LineTo(fBoxLeft + 6, fBoxTop + 8 + I);
             {Left-bottom to right-top}
                Canvas.MoveTo(fBoxLeft + 6, fBoxTop + 6 + I);
                Canvas.LineTo(fBoxLeft + 10, fBoxTop + 2 + I);
              end;
     
          // Рисуем бриллиантик
          if fType = cbDiamond then
            begin
              Canvas.Pixels[fBoxLeft + 06, fBoxTop + 03] := clBlack;
              Canvas.Pixels[fBoxLeft + 06, fBoxTop + 09] := clBlack;
     
              Canvas.MoveTo(fBoxLeft + 05, fBoxTop + 04);
              Canvas.LineTo(fBoxLeft + 08, fBoxTop + 04);
     
              Canvas.MoveTo(fBoxLeft + 05, fBoxTop + 08);
              Canvas.LineTo(fBoxLeft + 08, fBoxTop + 08);
     
              Canvas.MoveTo(fBoxLeft + 04, fBoxTop + 05);
              Canvas.LineTo(fBoxLeft + 09, fBoxTop + 05);
     
              Canvas.MoveTo(fBoxLeft + 04, fBoxTop + 07);
              Canvas.LineTo(fBoxLeft + 09, fBoxTop + 07);
     
              Canvas.MoveTo(fBoxLeft + 03, fBoxTop + 06);
              Canvas.LineTo(fBoxLeft + 10, fBoxTop + 06); // middle line
            end;
        end;
    end;
     
    {-------------------------------------------------------------------} 
    procedure Register;
    begin
      RegisterComponents('Samples', [TCheckBoxX]);
    end;
    {-------------------------------------------------------------------}
     
    destructor TCheckBoxX.Destroy;
     
    begin
      inherited Destroy;
    end;
    {-------------------------------------------------------------------}
     
    constructor TCheckBoxX.Create(AOwner: TComponent);
     
    begin
      inherited Create(AOwner);
      Height := 17;
      Width := 97;
      fChecked := False;
      fColor := clBtnFace;
      fState := cbUnChecked;
      fFont := inherited Font;
      fAllowGrayed := False;
      fFocus := False;
      fMouseState := msMouseUp;
      fAlignment := taRightJustify;
      TabStop := True; // Sorry
    end;
    {-------------------------------------------------------------------}
    end.
    {===================================================================}

