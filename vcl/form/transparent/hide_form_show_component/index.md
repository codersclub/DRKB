---
Title: Как сделать форму невидимой, а компоненты (TImage) видимые?
Author: Нуржанов Аскар. (NikNet/Arazel)
Date: 04.12.2006.
---


Как сделать форму невидимой, а компоненты (TImage) видимые?
===========================================================

::: {.date}
04.12.2006.
:::

Автор: Нуржанов Аскар. (NikNet/Arazel)

Сайт кому интересно : NikNet.narod.ru

Данный пример показывает, как сделать форму невидимой, а компоненты
(image) видимые...

И ещё, если компонент имеет Transparent = false, то процедура не
вырезает те части

которые должны быть вырезанные. Одни, словом как вы видите её визуально
так и

увидите в Runtime.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ExtCtrls, StdCtrls, Buttons;
     
     
    type
      TForm1 = class(TForm)
        Image3: TImage;
        Image2: TImage;
        Image1: TImage;
        procedure FormCreate(Sender: TObject);
      protected
    procedure ImagesWindowRgn;
      public
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses Types;
     
    {$R *.dfm}
     
    procedure TForm1.ImagesWindowRgn;
    var
     FullRgn, Rgn: THandle;
     ClientX, ClientY, i, k: integer;
     
     x, y, firstx, cl : integer;
     last : boolean;
     temprgn : hrgn;
    Begin
    k:=0;
      ClientX := (Width  - ClientWidth) div 2;
      ClientY :=  Height - ClientHeight  -  ClientX;
      FullRgn:=CreateRectRgn(0,0,Width,Height);
      Rgn:=CreateRectRgn(ClientX,ClientY,ClientX+ClientWidth,ClientY+ClientHeight);
      CombineRgn(FullRgn,FullRgn,Rgn,RGN_DIFF);
     
      for i:=0 to ControlCount-1 do
      with Controls[i] do
      begin
    //      Rgn:=CreateRectRgn(ClientX+Left,ClientY+Top,ClientX+Left+Width,ClientY+Top+Height);
    //      CombineRgn(FullRgn,FullRgn,Rgn,RGN_OR);
    //***************************************************************************************
          if (TImage(Controls[i]).Picture) <> nil  then
          with TImage(Controls[i]) do
          Begin
          if Transparent then
          cl := Picture.Bitmap.Canvas.Pixels [0, 0];
          for y:=0 to Picture.Bitmap.height-1 do
           begin
             firstx:=0; last:=false;
              for x:=0 to  Picture.Bitmap.width-1 do
               if(abs( Picture.Bitmap.canvas.pixels[x,y] - cl)>0) and (x<>pred( Picture.Bitmap.width))  then
                begin
                  if not last then
                    begin
                      last:=true;
                      if Transparent then
                      firstx:=x;
                    end;
                end  else
                if last then
                begin
                  last:=false;
                  temprgn:=CreateRectRgn( firstx+left,
                                          y+Top,
                                          left+x,
                                          Top+y+1);
    //              temprgn:=createrectrgn(firstx,y,x,y+1);
                  CombineRgn(FullRgn,FullRgn,temprgn,RGN_or);
                  deleteobject(temprgn);
                end;
           end;
          end;
    //***************************************************************************************
     end;
      SetWindowRgn(Handle,FullRgn,true);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      HorzScrollbar.Visible := false;
      VertScrollbar.Visible := false;
      BorderStyle:=bsNone;
      ImagesWindowRgn;
    end;
     
    end.
