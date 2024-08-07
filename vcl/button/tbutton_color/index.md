---
Title: Как изменить цвет TButton?
Date: 01.01.2007
---


Как изменить цвет TButton?
==========================

Вариант 1:

    { 
      You cannot change the color of a standard TButton, 
      since the windows button control always paints itself with the 
      button color defined in the control panel. 
      But you can derive derive a new component from TButton and handle 
      the and drawing behaviour there. 
    } 
     
     
    unit ColorButton; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls, Buttons, ExtCtrls; 
     
    type 
      TDrawButtonEvent = procedure(Control: TWinControl; 
        Rect: TRect; State: TOwnerDrawState) of object; 
     
      TColorButton = class(TButton) 
      private 
        FCanvas: TCanvas; 
        IsFocused: Boolean; 
        FOnDrawButton: TDrawButtonEvent; 
      protected 
        procedure CreateParams(var Params: TCreateParams); override; 
        procedure SetButtonStyle(ADefault: Boolean); override; 
        procedure CMEnabledChanged(var Message: TMessage); message CM_ENABLEDCHANGED; 
        procedure CMFontChanged(var Message: TMessage); message CM_FONTCHANGED; 
        procedure CNMeasureItem(var Message: TWMMeasureItem); message CN_MEASUREITEM; 
        procedure CNDrawItem(var Message: TWMDrawItem); message CN_DRAWITEM; 
        procedure WMLButtonDblClk(var Message: TWMLButtonDblClk); message WM_LBUTTONDBLCLK; 
        procedure DrawButton(Rect: TRect; State: UINT); 
      public 
        constructor Create(AOwner: TComponent); override; 
        destructor Destroy; override; 
        property Canvas: TCanvas read FCanvas; 
      published 
        property OnDrawButton: TDrawButtonEvent read FOnDrawButton write FOnDrawButton; 
        property Color; 
      end; 
     
    procedure Register; 
     
    implementation 
     
    procedure Register; 
    begin 
      RegisterComponents('Samples', [TColorButton]); 
    end; 
     
    constructor TColorButton.Create(AOwner: TComponent); 
    begin 
      inherited Create(AOwner); 
      FCanvas := TCanvas.Create; 
    end; 
     
    destructor TColorButton.Destroy; 
    begin 
      inherited Destroy; 
      FCanvas.Free; 
    end; 
     
    procedure TColorButton.CreateParams(var Params: TCreateParams); 
    begin 
      inherited CreateParams(Params); 
      with Params do Style := Style or BS_OWNERDRAW; 
    end; 
     
    procedure TColorButton.SetButtonStyle(ADefault: Boolean); 
    begin 
      if ADefault <> IsFocused then 
      begin 
        IsFocused := ADefault; 
        Refresh; 
      end; 
    end; 
     
    procedure TColorButton.CNMeasureItem(var Message: TWMMeasureItem); 
    begin 
      with Message.MeasureItemStruct^ do 
      begin 
        itemWidth  := Width; 
        itemHeight := Height; 
      end; 
    end; 
     
    procedure TColorButton.CNDrawItem(var Message: TWMDrawItem); 
    var 
      SaveIndex: Integer; 
    begin 
      with Message.DrawItemStruct^ do 
      begin 
        SaveIndex := SaveDC(hDC); 
        FCanvas.Lock; 
        try 
          FCanvas.Handle := hDC; 
          FCanvas.Font := Font; 
          FCanvas.Brush := Brush; 
          DrawButton(rcItem, itemState); 
        finally 
          FCanvas.Handle := 0; 
          FCanvas.Unlock; 
          RestoreDC(hDC, SaveIndex); 
        end; 
      end; 
      Message.Result := 1; 
    end; 
     
    procedure TColorButton.CMEnabledChanged(var Message: TMessage); 
    begin 
      inherited; 
      Invalidate; 
    end; 
     
    procedure TColorButton.CMFontChanged(var Message: TMessage); 
    begin 
      inherited; 
      Invalidate; 
    end; 
     
    procedure TColorButton.WMLButtonDblClk(var Message: TWMLButtonDblClk); 
    begin 
      Perform(WM_LBUTTONDOWN, Message.Keys, Longint(Message.Pos)); 
    end; 
     
    procedure TColorButton.DrawButton(Rect: TRect; State: UINT); 
    var 
      Flags, OldMode: Longint; 
      IsDown, IsDefault, IsDisabled: Boolean; 
      OldColor: TColor; 
      OrgRect: TRect; 
    begin 
      OrgRect := Rect; 
      Flags := DFCS_BUTTONPUSH or DFCS_ADJUSTRECT; 
      IsDown := State and ODS_SELECTED <> 0; 
      IsDefault := State and ODS_FOCUS <> 0; 
      IsDisabled := State and ODS_DISABLED <> 0; 
     
      if IsDown then Flags := Flags or DFCS_PUSHED; 
      if IsDisabled then Flags := Flags or DFCS_INACTIVE; 
     
      if IsFocused or IsDefault then 
      begin 
        FCanvas.Pen.Color := clWindowFrame; 
        FCanvas.Pen.Width := 1; 
        FCanvas.Brush.Style := bsClear; 
        FCanvas.Rectangle(Rect.Left, Rect.Top, Rect.Right, Rect.Bottom); 
        InflateRect(Rect, - 1, - 1); 
      end; 
     
      if IsDown then 
      begin 
        FCanvas.Pen.Color := clBtnShadow; 
        FCanvas.Pen.Width := 1; 
        FCanvas.Brush.Color := clBtnFace; 
        FCanvas.Rectangle(Rect.Left, Rect.Top, Rect.Right, Rect.Bottom); 
        InflateRect(Rect, - 1, - 1); 
      end 
      else 
        DrawFrameControl(FCanvas.Handle, Rect, DFC_BUTTON, Flags); 
     
      if IsDown then OffsetRect(Rect, 1, 1); 
     
      OldColor := FCanvas.Brush.Color; 
      FCanvas.Brush.Color := Color; 
      FCanvas.FillRect(Rect); 
      FCanvas.Brush.Color := OldColor; 
      OldMode := SetBkMode(FCanvas.Handle, TRANSPARENT); 
      FCanvas.Font.Color := clBtnText; 
      if IsDisabled then 
        DrawState(FCanvas.Handle, FCanvas.Brush.Handle, nil, Integer(Caption), 0, 
        ((Rect.Right - Rect.Left) - FCanvas.TextWidth(Caption)) div 2, 
        ((Rect.Bottom - Rect.Top) - FCanvas.TextHeight(Caption)) div 2, 
          0, 0, DST_TEXT or DSS_DISABLED) 
      else 
        DrawText(FCanvas.Handle, PChar(Caption), - 1, Rect, 
          DT_SINGLELINE or DT_CENTER or DT_VCENTER); 
      SetBkMode(FCanvas.Handle, OldMode); 
     
      if Assigned(FOnDrawButton) then 
        FOnDrawButton(Self, Rect, TOwnerDrawState(LongRec(State).Lo)); 
     
      if IsFocused and IsDefault then 
      begin 
        Rect := OrgRect; 
        InflateRect(Rect, - 4, - 4); 
        FCanvas.Pen.Color := clWindowFrame; 
        FCanvas.Brush.Color := clBtnFace; 
        DrawFocusRect(FCanvas.Handle, Rect); 
      end; 
    end; 
    end.

------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

В книгах Калверта, Свана и других авторов можно найти похожий текст.
Смысл текста - "Изменить цвет кнопок Button, BitBtn нельзя, т.к. их
рисует WINDOWS". Если нельзя, но ОЧЕНЬ НУЖНО, то можно.

Небольшой компонент ColorBtn, дает возможность использовать в кнопках
цвет. Кроме того, представлено новое свойство - Frame3D, позволяющее
получить более реалистичный вид нажатой кнопки. В отличие от API, при
изменении значения свойства Frame3D, не требуется переоткрытие
компонента.

**Примечание**
Кнопку по-прежнему рисует WINDOWS, а раскрашивает ее ColorBtn. Код
компонента на 90% повторяет код BitBtn, ничего необычного здесь нет.
Хочется повторить слова Калверта - "Пользуйтесь исходным кодом".
Чаще заглядывайте в VCL - можно найти много интересного. На рисунке
представлены ColorButton и ColorBitBtn.

    unit colorbtn;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, Buttons;
     
    type
     
      TColorBtn = class(TButton)
      private
        FCanvas: TCanvas;
        IsFocused: Boolean;
        F3DFrame: boolean;
        FButtonColor: TColor;
        procedure Set3DFrame(Value: boolean);
        procedure SetButtonColor(Value: TColor);
        procedure CNDrawItem(var Message: TWMDrawItem); message CN_DRAWITEM;
        procedure WMLButtonDblClk(var Message: TWMLButtonDblClk); message
          WM_LBUTTONDBLCLK;
        procedure DrawButtonText(const Caption: string; TRC: TRect; State:
          TButtonState; BiDiFlags: Longint);
        procedure CalcuateTextPosition(const Caption: string; var TRC: TRect;
          BiDiFlags: Longint);
      protected
        procedure CreateParams(var Params: TCreateParams); override;
        procedure SetButtonStyle(ADefault: Boolean); override;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
      published
        property ButtonColor: TColor read FButtonColor write SetButtonColor default
          clBtnFace;
        property Frame3D: boolean read F3DFrame write Set3DFrame default False;
      end;
     
    procedure Register;
     
    implementation
     
    { TColorBtn }
     
    constructor TColorBtn.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      Height := 21;
      FCanvas := TCanvas.Create;
      FButtonColor := clBtnFace;
      F3DFrame := False;
    end;
     
    destructor TColorBtn.Destroy;
    begin
      FCanvas.Free;
      inherited Destroy;
    end;
     
    procedure TColorBtn.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      with Params do
        Style := Style or BS_OWNERDRAW;
    end;
     
    procedure TColorBtn.Set3DFrame(Value: boolean);
    begin
      if F3DFrame <> Value then
        F3DFrame := Value;
    end;
     
    procedure TColorBtn.SetButtonColor(Value: TColor);
    begin
      if FButtonColor <> Value then
      begin
        FButtonColor := Value;
        Invalidate;
      end;
    end;
     
    procedure TColorBtn.WMLButtonDblClk(var Message: TWMLButtonDblClk);
    begin
      Perform(WM_LBUTTONDOWN, Message.Keys, Longint(Message.Pos));
    end;
     
    procedure TColorBtn.SetButtonStyle(ADefault: Boolean);
    begin
      if IsFocused <> ADefault then
        IsFocused := ADefault;
    end;
     
    procedure TColorBtn.CNDrawItem(var Message: TWMDrawItem);
    var
      RC: TRect;
      Flags: Longint;
      State: TButtonState;
      IsDown, IsDefault: Boolean;
      DrawItemStruct: TDrawItemStruct;
    begin
      DrawItemStruct := Message.DrawItemStruct^;
      FCanvas.Handle := DrawItemStruct.HDC;
      RC := ClientRect;
      with DrawItemStruct do
      begin
        IsDown := ItemState and ODS_SELECTED <> 0;
        IsDefault := ItemState and ODS_FOCUS <> 0;
        if not Enabled then
          State := bsDisabled
        else if IsDown then
          State := bsDown
        else
          State := bsUp;
      end;
      Flags := DFCS_BUTTONPUSH or DFCS_ADJUSTRECT;
      if IsDown then
        Flags := Flags or DFCS_PUSHED;
      if DrawItemStruct.ItemState and ODS_DISABLED <> 0 then
        Flags := Flags or DFCS_INACTIVE;
      if IsFocused or IsDefault then
      begin
        FCanvas.Pen.Color := clWindowFrame;
        FCanvas.Pen.Width := 1;
        FCanvas.Brush.Style := bsClear;
        FCanvas.Rectangle(RC.Left, RC.Top, RC.Right, RC.Bottom);
        InflateRect(RC, -1, -1);
      end;
      if IsDown then
      begin
        FCanvas.Pen.Color := clBtnShadow;
        FCanvas.Pen.Width := 1;
        FCanvas.Rectangle(RC.Left, RC.Top, RC.Right, RC.Bottom);
        InflateRect(RC, -1, -1);
        if F3DFrame then
        begin
          FCanvas.Pen.Color := FButtonColor;
          FCanvas.Pen.Width := 1;
          DrawFrameControl(DrawItemStruct.HDC, RC, DFC_BUTTON, Flags);
        end;
      end
      else
        DrawFrameControl(DrawItemStruct.HDC, RC, DFC_BUTTON, Flags);
      FCanvas.Brush.Color := FButtonColor;
      FCanvas.FillRect(RC);
      InflateRect(RC, 1, 1);
      if IsFocused then
      begin
        RC := ClientRect;
        InflateRect(RC, -1, -1);
      end;
      FCanvas.Font := Self.Font;
      if IsDown then
        OffsetRect(RC, 1, 1);
      DrawButtonText(Caption, RC, State, 0);
      if IsFocused and IsDefault then
      begin
        RC := ClientRect;
        InflateRect(RC, -4, -4);
        FCanvas.Pen.Color := clWindowFrame;
        Windows.DrawFocusRect(FCanvas.Handle, RC);
      end;
      FCanvas.Handle := 0;
    end;
     
    procedure TColorBtn.CalcuateTextPosition(const Caption: string; var TRC: TRect;
      BiDiFlags: Integer);
    var
      TB: TRect;
      TS, TP: TPoint;
    begin
      with FCanvas do
      begin
        TB := Rect(0, 0, TRC.Right + TRC.Left, TRC.Top + TRC.Bottom);
        DrawText(Handle, PChar(Caption), Length(Caption), TB, DT_CALCRECT or
          BiDiFlags);
        TS := Point(TB.Right - TB.Left, TB.Bottom - TB.Top);
        TP.X := ((TRC.Right - TRC.Left) - TS.X + 1) div 2;
        TP.Y := ((TRC.Bottom - TRC.Top) - TS.Y + 1) div 2;
        OffsetRect(TB, TP.X + TRC.Left, TP.Y + TRC.Top);
        TRC := TB;
      end;
    end;
     
    procedure TColorBtn.DrawButtonText(const Caption: string; TRC: TRect; State:
      TButtonState; BiDiFlags: Integer);
    begin
      with FCanvas do
      begin
        CalcuateTextPosition(Caption, TRC, BiDiFlags);
        Brush.Style := bsClear;
        if State = bsDisabled then
        begin
          OffsetRect(TRC, 1, 1);
          Font.Color := clBtnHighlight;
          DrawText(Handle, PChar(Caption), Length(Caption), TRC,
            DT_CENTER or DT_VCENTER or BiDiFlags);
          OffsetRect(TRC, -1, -1);
          Font.Color := clBtnShadow;
          DrawText(Handle, PChar(Caption), Length(Caption), TRC,
            DT_CENTER or DT_VCENTER or BiDiFlags);
        end
        else
          DrawText(Handle, PChar(Caption), Length(Caption), TRC,
            DT_CENTER or DT_VCENTER or BiDiFlags);
      end;
    end;
     
    procedure Register;
    begin
      RegisterComponents('Controls', [TColorBtn]);
    end;
     
    end.

