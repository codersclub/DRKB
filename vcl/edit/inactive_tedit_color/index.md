---
Title: Изменить цвет неактивного TEdit
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Изменить цвет неактивного TEdit
===============================
 
> Как изменить цвет отключенного элемента управления (Edit1.Enabled:= false;)?
> Не хочу нормальный серый цвет.

Есть два варианта:

1) разместить элемент управления на панели и отключить панель вместо элемента управления.
Таким образом, цвет останется таким, каким вы его установили.

2) сделать потомка и самому перерисовать контрол, когда она запрещён.

    {Question: 
    How can I change the color of a disabled (Edit1.Enabled := false;) control? 
    I do not want the normal grey color. 
     
    Answer: 
    Two options: 
     
    1) place the control on a panel and disable the panel instead of the control. 
    This way the color stays to whatever you set it. 
     
    2) make a descendent and take over the painting when it is disabled. 
     
    Here is an example:}
     
     
     unit PBExEdit;
     
     interface
     
     uses
       Windows, Messages, SysUtils, Classes, Graphics, Controls,
       Forms, Dialogs, StdCtrls;
     
     type
       TPBExEdit = class(TEdit)
       private
         { Private declarations }
         FDisabledColor: TColor;
         FDisabledTextColor: TColor;
         procedure WMPaint(var msg: TWMPaint); message WM_PAINT;
         procedure WMEraseBkGnd(var msg: TWMEraseBkGnd); message WM_ERASEBKGND;
         procedure SetDisabledColor(const Value: TColor); virtual;
         procedure SetDisabledTextColor(const Value: TColor); virtual;
       protected
         { Protected declarations }
       public
         { Public declarations }
         constructor Create(aOwner: TComponent); override;
       published
         { Published declarations }
         property DisabledTextColor: TColor read FDisabledTextColor
           write SetDisabledTextColor default clGrayText;
         property DisabledColor: TColor read FDisabledColor
           write SetDisabledColor default clWindow;
       end;
     
     procedure Register;
     
      implementation
     
     procedure Register;
     begin
       RegisterComponents('PBGoodies', [TPBExEdit]);
     end;
     
     
     constructor TPBExEdit.Create(aOwner: TComponent);
     begin
       inherited;
       FDisabledColor := clWindow;
       FDisabledTextColor := clGrayText;
     end;
     
     
     procedure TPBExEdit.SetDisabledColor(const Value: TColor);
     begin
       if FDisabledColor <> Value then
       begin
         FDisabledColor := Value;
         if not Enabled then
           Invalidate;
       end;
     end;
     
     
     procedure TPBExEdit.SetDisabledTextColor(const Value: TColor);
     begin
       if FDisabledTextColor <> Value then
       begin
         FDisabledTextColor := Value;
         if not Enabled then
           Invalidate;
       end;
     end;
     
     
     procedure TPBExEdit.WMEraseBkGnd(var msg: TWMEraseBkGnd);
     var
       Canvas: TCanvas;
     begin
       if Enabled then
         inherited
       else
       begin
         Canvas:= TCanvas.Create;
         try
           Canvas.Handle := msg.DC;
           SaveDC(msg.DC);
           try
             canvas.Brush.Color := FDisabledColor;
             canvas.Brush.Style := bsSolid;
             canvas.Fillrect(clientrect);
             msg.Result := 1;
           finally
             RestoreDC(msg.DC, - 1);
           end;
         finally
           canvas.free
         end;
       end;
     end;
     
     
     procedure TPBExEdit.WMPaint(var msg: TWMPaint);
     var
       Canvas: TCanvas;
       ps: TPaintStruct;
       CallEndPaint: Boolean;
     begin
       if Enabled then
         inherited
       else
       begin
         CallEndPaint := False;
         Canvas:= TCanvas.Create;
         try
           if msg.DC <> 0 then
           begin
             Canvas.Handle := msg.DC;
             ps.fErase := true;
           end
           else
           begin
             BeginPaint(Handle, ps);
             CallEndPaint:= True;
             Canvas.handle := ps.hdc;
           end;
           if ps.fErase then
             Perform(WM_ERASEBKGND, Canvas.Handle, 0);
           SaveDC(canvas.handle);
           try
             Canvas.Brush.Style := bsClear;
             Canvas.Font := Font;
             Canvas.Font.Color := FDisabledTextColor;
             Canvas.TextOut(1, 1, Text);
           finally
             RestoreDC(Canvas.Handle, - 1);
           end;
         finally
           if CallEndPaint then
             EndPaint(handle, ps);
           Canvas.Free
         end;
       end;
     end;
     
     end.

