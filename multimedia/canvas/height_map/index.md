---
Title: Карта высот картинки
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Карта высот картинки
====================

    {
     вы знаете что такое карта высот?
     можно создать супер эффект на простом Canvas.
     к сожалению мой код моргает при перерисовке,
     но вы уж поковыряйтесь.... :)
    }
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      ExtCtrls, StdCtrls, ExtDlgs, math, ComCtrls, ShellApi;
     
    type
      TForm1 = class(TForm)
        Image1: TImage;
        OpenDialog1: TOpenDialog;
        Timer1: TTimer;
        PageControl1: TPageControl;
        Specular: TTabSheet;
        sRed: TEdit;
        Label1: TLabel;
        ScrollBar1: TScrollBar;
        Label2: TLabel;
        sGreen: TEdit;
        ScrollBar2: TScrollBar;
        ScrollBar3: TScrollBar;
        sBlue: TEdit;
        Label3: TLabel;
        Label4: TLabel;
        Edit1: TEdit;
        ScrollBar4: TScrollBar;
        Diffuse: TTabSheet;
        Ambient: TTabSheet;
        Label5: TLabel;
        Label6: TLabel;
        Label7: TLabel;
        dGreen: TEdit;
        dBlue: TEdit;
        dRed: TEdit;
        ScrollBar5: TScrollBar;
        ScrollBar6: TScrollBar;
        ScrollBar7: TScrollBar;
        Label8: TLabel;
        Label9: TLabel;
        Label10: TLabel;
        aBlue: TEdit;
        aGreen: TEdit;
        aRed: TEdit;
        ScrollBar8: TScrollBar;
        ScrollBar9: TScrollBar;
        ScrollBar10: TScrollBar;
        Label11: TLabel;
        Label12: TLabel;
        Edit2: TEdit;
        Label13: TLabel;
        procedure FormCreate(Sender: TObject);
        procedure Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
          Y: Integer);
        procedure ScrollBarChange(Sender: TObject);
        procedure Label11Click(Sender: TObject);
        procedure Timer1Timer(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    type
      normal = record
        x: integer;
        y: integer;
      end;
     
    type
      rgb32 = record
        b: byte;
        g: byte;
        r: byte;
        t: byte;
      end;
    type
      rgb24 = record
        r: integer;
        g: integer;
        b: integer;
      end;
     
    var
      Form1: TForm1;
      bumpimage: tbitmap;
      current_X, Current_Y: integer;
    var
      Bump_Map: array[0..255, 0..255] of normal;
      Environment_map: array[0..255, 0..255] of integer;
      Palette: array[0..256] of rgb24;
     
    implementation
     
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    type
      image_array = array[0..255, 0..255] of byte;
    var
      x, y: integer;
      Buffer: image_array;
      bump_file: file of image_array;
      ny2, nx, nz: double;
      c: integer;
      ca, cap: double;
    begin
      assignfile(bump_File, 'bump.raw');
      reset(Bump_File);
      Read(Bump_File, buffer);
      for y := 1 to 254 do
      begin
        for x := 1 to 254 do
        begin
          Bump_Map[x, y].x := buffer[y + 1, x] - buffer[y + 1, x + 2];
          bump_map[x, y].y := buffer[y, x + 1] - buffer[y + 2, x + 1];
        end;
      end;
      closefile(bump_File);
     
      for y := -128 to 127 do
      begin
        nY2 := y / 128;
        nY2 := nY2 * nY2;
        for X := -128 to 127 do
        begin
          nX := X / 128;
          nz := 1 - SQRT(nX * nX + nY2);
          c := trunc(nz * 255);
          if c < = 0 then
            c := 0;
          Environment_Map[x + 128, y + 128] := c;
        end;
      end;
     
      nx := pi / 2;
      ny2 := nx / 256;
      for y := 0 to 255 do
      begin
        ca := cos(nx);
        cap := power(ca, 35);
        nx := nx - ny2;
        palette[y].r := trunc((128 * ca) + (235 * cap));
        if palette[y].r > 255 then
          palette[y].r := 255;
        palette[y].G := trunc((128 * ca) + (245 * cap));
        if palette[y].g > 255 then
          palette[y].g := 255;
        palette[y].B := trunc(5 + (170 * ca) + (255 * cap));
        ;
        if palette[y].b > 255 then
          palette[y].b := 255;
      end;
      bumpimage := TBitmap.create;
      bumpimage.width := 255;
      bumpimage.height := 255;
      bumpimage.PixelFormat := pf32bit;
      Image1.Picture.Bitmap := bumpimage;
      image1mousemove(self, [], 128, 128);
      application.ProcessMessages;
     
    end;
     
    procedure TForm1.Image1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    begin
      Current_X := x;
      Current_Y := y;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      x, y, x2, y2, y3: integer;
      Scan: ^Scanline;
      bx, by: longint;
      c: byte;
    begin
      x := Current_X;
      y := Current_Y;
      for y2 := 0 to 253 do
      begin
        scan := image1.Picture.Bitmap.ScanLine[y2];
        y3 := 128 + y2 - y;
        for x2 := 0 to 253 do
        begin
          bx := bump_Map[x2, y2].x + 128 + x2 - x;
          by := bump_Map[x2, y2].y + y3;
          if (bx < 255) and (bx > 0) and (by < 255) and (by > 0) then
          begin
            c := Environment_Map[bx, by];
            scan^[x2].r := palette[c].r;
            scan^[x2].g := palette[c].g;
            scan^[x2].b := palette[c].b;
          end
          else
          begin
            scan^[x2].r := palette[0].r;
            scan^[x2].g := palette[0].g;
            scan^[x2].b := palette[0].b;
          end;
          {image1.Canvas.Pixels[x,y] := rgb(r,g,b);}
        end;
      end;
      image1.Refresh;
     
    end;
     
    procedure TForm1.ScrollBarChange(Sender: TObject);
    var
      ny2, nx: double;
      c: integer;
      ca, cap: double;
    begin
      sRed.Text := inttostr(scrollbar1.position);
      sGreen.Text := inttostr(scrollbar2.position);
      sBlue.Text := inttostr(scrollbar3.position);
      edit1.Text := inttostr(scrollbar4.position);
     
      dRed.Text := inttostr(scrollbar5.position);
      dGreen.Text := inttostr(scrollbar6.position);
      dBlue.Text := inttostr(scrollbar7.position);
     
      aRed.Text := inttostr(scrollbar8.position);
      aGreen.Text := inttostr(scrollbar9.position);
      aBlue.Text := inttostr(scrollbar10.position);
     
      nx := pi / 2;
      ny2 := nx / 256;
      for C := 0 to 255 do
      begin
        ca := cos(nx);
        cap := power(ca, scrollbar4.position);
        nx := nx - ny2;
        palette[c].r := trunc(scrollbar8.position + (scrollbar5.position * ca) +
          (scrollbar1.position * cap));
        if palette[c].r > 255 then
          palette[c].r := 255;
        palette[c].G := trunc(scrollbar9.position + (scrollbar6.position * ca) +
          (scrollbar2.position * cap));
        if palette[c].g > 255 then
          palette[c].g := 255;
        palette[c].B := trunc(scrollbar10.position + (scrollbar7.position * ca) +
          (scrollbar3.position * cap));
        ;
        if palette[c].b > 255 then
          palette[c].b := 255;
      end;
      image1mousemove(self, [], Current_X, Current_Y);
      application.ProcessMessages;
     
    end;
     
    procedure TForm1.Label11Click(Sender: TObject);
    begin
      ShellExecute(handle, 'open', 'http://wkweb5.cableinet.co.uk/daniel.davies/',
        nil, nil, SW_SHOWNORMAL);
    end;
     
    end.

