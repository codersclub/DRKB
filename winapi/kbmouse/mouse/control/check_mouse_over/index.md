---
Title: Отслеживать переход мышки на компонент и уход ее
Date: 01.01.2007
---


Отслеживать переход мышки на компонент и уход ее
================================================

Вариант 1:

Source: <https://www.swissdelphicenter.ch>

    { 
     The following unit is a visual component inherited of TImage, which has the 
     2 additional events OnMouseEnter and OnMouseLeave. 
    }
     
    unit ImageEx;
    
    interface
    
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls;
    
    type
      TImageEx = class (TImage)
      private
        { Private declarations }
        FOnMouseLeave: TNotifyEvent;
        FOnMouseEnter: TNotifyEvent;
        procedure CMMouseEnter(var msg: TMessage);
          message CM_MOUSEENTER;
        procedure CMMouseLeave(var msg: TMessage);
          message CM_MOUSELEAVE;
      protected
        { Protected declarations }
        procedure DoMouseEnter; dynamic;
        procedure DoMouseLeave; dynamic;
      public
        { Public declarations }
      published
        { Published declarations }
        property OnMouseEnter: TNotifyEvent read FOnMouseEnter write FOnMouseEnter;
        property OnMouseLeave: TNotifyEvent read FOnMouseLeave write FOnMouseLeave;
      end;
    
    procedure Register;
    
    implementation
    
    procedure Register;
    begin
      RegisterComponents('Additional', [TImageEx]);
    end;
    
    { TImageEx }
    
    procedure TImageEx.CMMouseEnter(var msg: TMessage);
    begin
      DoMouseEnter;
    end;
    
    procedure TImageEx.CMMouseLeave(var msg: TMessage);
    begin
      DoMouseLeave;
    end;
    
    procedure TImageEx.DoMouseEnter;
    begin
      if Assigned(FOnMouseEnter) then FOnMouseEnter(Self);
    end;
    
    procedure TImageEx.DoMouseLeave;
    begin
      if Assigned(FOnMouseLeave) then FOnMouseLeave(Self);
    end;
    
    end.


------------------------------------------------------------------------

Вариант 2:

Source: <https://www.swissdelphicenter.ch>

Получить активный элемент управления под курсором мышки

    { You may call this function in a global event procedure, 
     linking as many components events to it as you need. }
    
    function FindControlAtPos: TWinControl;
    var
      Pt: TPoint;
    begin
      GetCursorPos(Pt);
      Result := FindControl(WindowFromPoint(Pt));
    end;
    
    
    { (Beispiel) Hier die allgemein gultige Procedure fur OnMouseUp. 
     Die Behandlung von OnClick bleibt dabei erhalten: 
     die Funktionalitat aus OnMouseUp kommt dazu. }
    
    { (example) There's the global proc for the OnMouseUp event. 
     Note: OnClick keeps working, so you can "add" the OnMouseUp 
     facility to no cost. }
    
    procedure TForm1.GenericMouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    var
      TWC: TWinControl;
    begin
      TWC := FindControlAtPos;
      //what for a class ! 
      Showmessage('Here we are: ' + TWC.ClassName);
      //Let it blink... 
      TWC.Visible := False;
      Sleep(150);
      TWC.Visible := True;
    end;

