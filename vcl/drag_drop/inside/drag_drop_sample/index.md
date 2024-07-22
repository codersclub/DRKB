---
Title: Пример реализации Drag & Drop
Author: Akella
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Пример реализации Drag & Drop
=============================

```delphi
unit Main;

interface

uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
  StdCtrls, ExtCtrls;

type
  TMainForm = class(TForm)
    Panel1: TPanel;
    Edit1: TEdit;
    Edit2: TEdit;
    Label1: TLabel;
    Label2: TLabel;
    Panel2: TPanel;
    procedure Edit1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    procedure Edit2DragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure Edit2DragDrop(Sender, Source: TObject; X, Y: Integer);
    procedure Edit1EndDrag(Sender, Target: TObject; X, Y: Integer);
    procedure FormDragOver(Sender, Source: TObject; X, Y: Integer;
      State: TDragState; var Accept: Boolean);
    procedure FormDragDrop(Sender, Source: TObject; X, Y: Integer);
  private
    { Private declarations }
  public
    { Public declarations }
  end;

var
  MainForm: TMainForm;

implementation

{$R *.DFM}

procedure TMainForm.Edit1MouseDown(Sender: TObject; Button: TMouseButton;
  Shift: TShiftState; X, Y: Integer);
begin
 if Button = mbLeft
  then TEdit(Sender).BeginDrag(True);
end;

procedure TMainForm.Edit2DragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
 if Source is TEdit
  then Accept := True
  else Accept := False;
end;

procedure TMainForm.Edit2DragDrop(Sender, Source: TObject; X, Y: Integer);
begin
 TEdit(Sender).Text := TEdit(Source).Text;
 TEdit(Sender).SetFocus;
 TEdit(Sender).SelectAll;
end;

procedure TMainForm.Edit1EndDrag(Sender, Target: TObject; X, Y: Integer);
begin
 if Assigned(Target)
  then TEdit(Sender).Text := 'Текст перенесен в ' + TEdit(Target).Name;
end;

procedure TMainForm.FormDragOver(Sender, Source: TObject; X, Y: Integer;
  State: TDragState; var Accept: Boolean);
begin
 if Source.ClassName = 'TPanel'
  then Accept := True
  else Accept := False;
end;

procedure TMainForm.FormDragDrop(Sender, Source: TObject; X, Y: Integer);
begin
 TPanel(Source).Left := X;
 TPanel(Source).Top := Y;
end;

end.
```

Скачать полный проект примера реализации Drag-and-Drop: [27_1.zip](27_1.zip)

