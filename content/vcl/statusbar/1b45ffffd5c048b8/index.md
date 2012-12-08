---
Title: TStatusBar + TProgressBar
Author: Vit
Date: 01.01.2007
---


TStatusBar + TProgressBar
=========================

::: {.date}
01.01.2007
:::

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

Автор: Vit

------------------------------------------------------------------------

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

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

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
все сложно\...

Взято из Советов по Delphi от [Валентина
Озерова](mailto:mailto:webmaster@webinspector.com)

Сборник Kuliba

------------------------------------------------------------------------

pgProgress положить на форму как Visible := false; StatusPanel надо
OwnerDraw сделать и pефpешить, если Position меняется.

    procedure TMainForm.stStatusBarDrawPanel(StatusBar: TStatusBar; Panel: TStatusPanel; const Rect: TRect);
    begin

      if Panel.Index = pnProgress then
      begin
        pgProgress.BoundsRect := Rect;
        pgProgress.PaintTo(stStatusBar.Canvas.Handle, Rect.Left, Rect.Top);
      end;
    end; 

Взято с Vingrad.ru <https://forum.vingrad.ru>

------------------------------------------------------------------------

With TProgressBar.Create(StatusBar1) Do Parent:=StatusBar1;

Автор: Song
