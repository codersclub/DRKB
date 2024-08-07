---
Title: Денежное поле редактирования
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Денежное поле редактирования
============================

    unit CurrEdit;
     
    interface
     
    uses
      SysUtils,
      WinTypes,
      WinProcs,
      Messages,
      Classes,
      Graphics,
      Controls,
      Menus,
      Forms,
      Dialogs,
      StdCtrls;
     
    type
      TCurrencyEdit = class(TCustomMemo)
      private
        DispFormat: string;
        FieldValue: Extended;
        procedure SetFormat(A: string);
        procedure SetFieldValue(A: Extended);
        procedure CMEnter(var Message: TCMEnter); message CM_ENTER;
        procedure CMExit(var Message: TCMExit); message CM_EXIT;
        procedure FormatText;
        procedure UnFormatText;
      protected
        procedure KeyPress(var Key: Char); override;
        procedure CreateParams(var Params: TCreateParams); override;
      public
        constructor Create(AOwner: TComponent); override;
      published
        property Alignment default taRightJustify;
        property AutoSize default True;
        property BorderStyle;
        property Color;
        property Ctl3D;
        property DisplayFormat: string read DispFormat write SetFormat;
        property DragCursor;
        property DragMode;
        property Enabled;
        property Font;
        property HideSelection;
        property MaxLength;
        property ParentColor;
        property ParentCtl3D;
        property ParentFont;
        property ParentShowHint;
        property PopupMenu;
        property ReadOnly;
        property ShowHint;
        property TabOrder;
        property Value: Extended read FieldValue write SetFieldValue;
        property Visible;
        property OnChange;
        property OnClick;
        property OnDblClick;
        property OnDragDrop;
        property OnDragOver;
        property OnEndDrag;
        property OnEnter;
        property OnExit;
        property OnKeyDown;
        property OnKeyPress;
        property OnKeyUp;
        property OnMouseDown;
        property OnMouseMove;
        property OnMouseUp;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
      RegisterComponents('Additional', [TCurrencyEdit]);
    end;
     
    constructor TCurrencyEdit.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      AutoSize := True;
      Alignment := taRightJustify;
      Width := 121;
      Height := 25;
      DispFormat := '$,0.00;($,0.00)';
      FieldValue := 0.0;
      AutoSelect := False;
      WantReturns := False;
      WordWrap := False;
      FormatText;
    end;
     
    procedure TCurrencyEdit.SetFormat(A: string);
    begin
      if DispFormat <> A then
      begin
        DispFormat := A;
        FormatText;
      end;
    end;
     
    procedure TCurrencyEdit.SetFieldValue(A: Extended);
    begin
      if FieldValue <> A then
      begin
        FieldValue := A;
        FormatText;
      end;
    end;
     
    procedure TCurrencyEdit.UnFormatText;
    var
      TmpText: string;
      Tmp: Byte;
      IsNeg: Boolean;
    begin
      IsNeg := (Pos('-', Text) > 0) or (Pos('(', Text) > 0);
      TmpText := '';
      for Tmp := 1 to Length(Text) do
        if Text[Tmp] in ['0'..'9', '.'] then
          TmpText := TmpText + Text[Tmp];
      try
        FieldValue := StrToFloat(TmpText);
        if IsNeg then
          FieldValue := -FieldValue;
      except
        MessageBeep(mb_IconAsterisk);
      end;
    end;
     
    procedure TCurrencyEdit.FormatText;
    begin
      Text := FormatFloat(DispFormat, FieldValue);
    end;
     
    procedure TCurrencyEdit.CMEnter(var Message: TCMEnter);
    begin
      SelectAll;
      inherited;
    end;
     
    procedure TCurrencyEdit.CMExit(var Message: TCMExit);
    begin
      UnformatText;
      FormatText;
      inherited;
    end;
     
    procedure TCurrencyEdit.KeyPress(var Key: Char);
    begin
      if not (Key in ['0'..'9', '.', '-']) then
        Key := #0;
      inherited KeyPress(Key);
    end;
     
    procedure TCurrencyEdit.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      case Alignment of
        taLeftJustify: Params.Style := Params.Style or ES_LEFT and not ES_MULTILINE;
        taRightJustify: Params.Style := Params.Style or ES_RIGHT and not
          ES_MULTILINE;
        taCenter: Params.Style := Params.Style or ES_CENTER and not ES_MULTILINE;
      end;
    end;
     
    end.

