---
Title: Перемещение из TDBGrid
Date: 01.01.2007
---


Перемещение из TDBGrid
======================

::: {.date}
01.01.2007
:::

Кто-нибудь пробовал перемещать что-либо из DbGrid методом перетащи и
брось (drag and drop)? Вы сами можете создать потомка TDBGrid (или
TDBCustomGrid) и добавить необходимую функциональность для достижения
цели.

Скопируйте код из данного "Совета", сохраните его с именем DBGrid.pas
и установите компонент в палитру. У Вас появится новый компонент EDBGrid
с двумя новыми событиями: OnMouseDown и OnMouseUp. Я не считаю эту
информацию конфиденциальной: это ошибка разработчиков Delphi! На самом
деле эти два события должны быть частью компонента DBGrid.

    unit Dbgrid;
     
    interface
     
    uses
     
      DBGrids, Controls, Classes;
     
    type
     
      TEDBGrid = class(TDBGrid)
      private
        FOnMouseDown: TMouseEvent;
        FOnMouseUp: TMouseEvent;
      protected
        procedure MouseDown(Button: TMouseButton; Shift: TShiftState; X, Y:
          Integer); override;
     
        procedure MouseUp(Button: TMouseButton; Shift: TShiftState; X, Y:
          Integer); override;
     
      published
        property OnMouseDown: TMouseEvent read FOnMouseDown write
          FOnMouseDown;
     
        property OnMouseUp: TMouseEvent read FOnMouseUp write FOnMouseUp;
      end;
     
    procedure Register;
     
    implementation
     
    procedure Register;
    begin
     
      RegisterComponents('Data Controls', [TEDBGrid]);
    end;
     
    procedure TEDBGrid.MouseDown(Button: TMouseButton; Shift: TShiftState;
      X, Y: Integer);
    begin
     
      if Assigned(FOnMouseDown) then
        FOnMouseDown(Self, Button, Shift, X, Y);
      inherited MouseDown(Button, Shift, X, Y);
    end;
     
    procedure TEDBGrid.MouseUp(Button: TMouseButton; Shift: TShiftState; X,
      Y: Integer);
    begin
     
      if Assigned(FOnMouseUp) then
        FOnMouseUp(Self, Button, Shift, X, Y);
      inherited MouseUp(Button, Shift, X, Y);
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>
