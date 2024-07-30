---
Title: TStatusBar + TProgressBar
Date: 01.01.2007
---


TStatusBar + TProgressBar
=========================

Вариант 1:

Автор: Vit

Вставить ProgressBar в StatusBar:

Вот эту функцию применять вместо стандартного Create

    function CreateProgressBar(StatusBar:TStatusBar; index:integer):TProgressBar;
    var findleft:integer;
        i:integer;
    begin
      result:=TProgressBar.create(Statusbar);
      result.parent:=Statusbar;
      result.visible:=true;
      result.top:=2;
      findleft:=0;
      for i:=0 to index-1 do 
        findleft:=findleft+Statusbar.Panels[i].width+1;
      result.left:=findleft;
      result.width:=Statusbar.Panels[index].width-4;
      result.height:=Statusbar.height-2;
    end;

------------------------------------------------------------------------

Вариант 2:

Source: Vingrad.ru <https://forum.vingrad.ru>

    var pb: TProgressBar;

    begin
    ....
    pb:= TProgressBar.Create(self);
      with pb do begin
        Parent:= StatusBar1;
        Position:= 30;
        Top:= 2;
        Left:= 0;
        Height:= StatusBar1.Height - Top;
        Width:= StatusBar1.Panels[0].Width - Left;
      end;  //with;
    pb.Visible:= True;
    ....
    end; 


------------------------------------------------------------------------

Вариант 3:

Source: Советы по Delphi от [Валентина Озерова](mailto:webmaster@webinspector.com)

    unit adStatba;
     
    interface
     
    uses
     
    Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
    ComCtrls;
     
    type
     
    TAdrockStatusBar = class(TStatusBar)
    private
    { Private declarations }
    protected
    { Protected declarations }
    public
    { Public declarations }
    Constructor Create(Aowner : TComponent); override;
    published
    { Published declarations }
    end;
     
    procedure Register;
     
    implementation
     
    Constructor TAdrockStatusBar.Create(Aowner : TComponent);
    begin
     
    inherited Create(Aowner);
      ControlStyle := ControlStyle + [csAcceptsControls];
    end;
     
    procedure Register;
    begin
      RegisterComponents('Adrock', [TAdrockStatusBar]);
    end;
     
    end. 

Это позволит вам разместить элемент управления в панели. Но этот способ
не поддерживает использование вложенных панелей. Вероятно, вам также
понадобиться выровнять элемент управления по правому краю. Не так это
все сложно...

Сборник Kuliba

------------------------------------------------------------------------

Вариант 4:

Source: Vingrad.ru <https://forum.vingrad.ru>

pgProgress положить на форму как Visible := false; StatusPanel надо
OwnerDraw сделать и pефpешить, если Position меняется.

    procedure TMainForm.stStatusBarDrawPanel(StatusBar: TStatusBar;
                                             Panel: TStatusPanel;
                                             const Rect: TRect);
    begin

      if Panel.Index = pnProgress then
      begin
        pgProgress.BoundsRect := Rect;
        pgProgress.PaintTo(stStatusBar.Canvas.Handle, Rect.Left, Rect.Top);
      end;
    end; 


------------------------------------------------------------------------

Вариант 5:

Author: Song

    With TProgressBar.Create(StatusBar1) Do Parent:=StatusBar1;

