---
Title: Комбинация TLabel и TEdit
Author: Mike Scott
Date: 01.01.2007
---


Комбинация TLabel и TEdit
=========================

Вариант 1:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

При размещении на форме, создается TLabel, расположенный выше поля
редактирования. При перемещении поля редактирования, TLabel "следует"
за ним. При удалении поля редактирования, TLabel также удаляется.
Имеется свойство LabelCaption, так что вы можете редактировать заголовок
Tlabel. Вероятно вам потребуются и другие свойства TLabel, типа Font, но
этот код только демонстрирует технологию, так что развивайте его по
своему усмотрению.

    unit LblEdit;
     
    interface
     
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls;
     
    type
      TLabelEdit = class(TEdit)
      private
        FLabel: TLabel;
        procedure WMMove(var Msg: TWMMove); message WM_MOVE;
      protected
        procedure SetParent(Value: TWinControl); override;
        function GetLabelCaption: string; virtual;
        procedure SetLabelCaption(const Value: string); virtual;
      public
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
      published
        property LabelCaption: string read GetLabelCaption write
          SetLabelCaption;
     
      end;
     
    procedure Register;
     
    implementation
     
    constructor TLabelEdit.Create(AOwner: TComponent);
     
    begin
      inherited Create(AOwner);
     
      { создаем TLabel }
      FLabel := TLabel.Create(nil);
      FLabel.Caption := 'Edit label';
    end;
     
    procedure TLabelEdit.SetParent(Value: TWinControl);
     
    begin
      { убеждаемся, что TLabel имеет того же родителя что и TEdit }
      if (Owner = nil) or not (csDestroying in Owner.ComponentState) then
        FLabel.Parent := Value;
      inherited SetParent(Value);
    end;
     
    destructor TLabelEdit.Destroy;
     
    begin
      if (FLabel <> nil) and (FLabel.Parent = nil) then
        FLabel.Free;
      inherited Destroy;
    end;
     
    function TLabelEdit.GetLabelCaption: string;
     
    begin
      Result := FLabel.Caption;
    end;
     
    procedure TLabelEdit.SetLabelCaption(const Value: string);
     
    begin
      FLabel.Caption := Value;
    end;
     
    procedure TLabelEdit.WMMove(var Msg: TWMMove);
     
    begin
      inherited;
     
      { заставляем TLabel 'прилипнуть' к верху TEdit }
      if FLabel <> nil then
        with FLabel do
          SetBounds(Msg.XPos, Msg.YPos - Height, Width, Height);
    end;
     
    procedure Register;
    begin
      RegisterComponents('Samples', [TLabelEdit]);
    end;
     
    initialization
      { Мы используем TLabel, поэтому для обеспечения
      "поточности" необходима регистрация }
      RegisterClass(TLabel);
    end.


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

    unit Editlbl1;
     
    interface
     
    uses
     
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, Dialogs, stdctrls;
     
    type
     
      TLabelEdit = class(TWinControl)
      private
        { Private declarations }
        FEdit: TEdit;
        FLabel: TLabel;
        function GetLabelCaption: string;
        procedure SetLabelCaption(LabelCaption: string);
        function GetEditText: string;
        procedure SetEditText(EditText: string);
      protected
        { Protected declarations }
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
      published
        property LabelCaption: string read GetLabelCaption write SetLabelCaption;
        property EditText: string read GetEditText write SetEditText;
        property Left;
        property Top;
        property Width;
        property Height;
        property Text;
        property Font;
        { Можете опубликовать другие, необходимые вам свойства. }
        { Published declarations }
      end;
     
    procedure Register;
     
    implementation
     
    constructor TLabelEdit.Create(AOwner: TComponent);
    begin
     
      inherited Create(AOwner);
     
      FEdit := TEdit.Create(self);
      FLabel := TLabel.Create(self);
     
      with FLabel do
      begin
        Width := FEdit.Width;
        visible := true;
        Parent := self;
        Caption := 'LabelEdit';
      end;
     
      with FEdit do
      begin
        Top := FLabel.Height + 2;
        Parent := self;
        Visible := true;
      end;
     
      Top := 0;
      Left := 0;
      Width := FEdit.Width;
      Height := FEdit.Height + FLabel.Height;
      Visible := true;
    end;
     
    function TLabelEdit.GetLabelCaption: string;
    begin
     
      Result := FLabel.Caption;
    end;
     
    procedure TLabelEdit.SetLabelCaption(LabelCaption: string);
    begin
     
      FLabel.Caption := LabelCaption;
    end;
     
    function TLabelEdit.GetEditText: string;
    begin
     
      Result := FEdit.Text;
    end;
     
    procedure TLabelEdit.SetEditText(EditText: string);
    begin
     
      FEdit.Text := EditText;
    end;
     
    procedure Register;
    begin
     
      RegisterComponents('Test', [TLabelEdit]);
    end;
     
    end.


