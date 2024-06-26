---
Title: Bitmap.PixelFormat := pf1bit;
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Bitmap.PixelFormat := pf1bit;
=============================

Доступ к pf8bit-изображениям осуществляется достаточно легко, с тех пор,
как они стали использовать один байт на пиксель. Но вы можете сохранить
много памяти, если вам необходим единственный бит на пиксель (как,
например, с различными масками) в случае pf1bit-изображения.

Как и в случае с pf8bit-изображениями, используйте TByteArray для
доступа к pf1bit-ным линиям чередования (Scanlines). Но для доступа к
отдельным пикселям вам понадобиться работать с битами отдельного байта.
Так, ширина линии чередования равна Bitmap.Width DIV 8 байт.

Нижеприведенный код показывает как можно создать шаблон 1-битного
изображения: черный, белый, полоски, "g", "стрелка" и случайный -
опция "инвертировано" также доступна. (Надеюсь, технологию вы освоите
без труда.)

Создайте форму с Image1: для TImage я использую одно изображение Image1
размером 256x256 и свойством Stretch := TRUE, чтобы отдельные пиксели
было легко разглядеть. Кнопки Black, White и Stripes имеют свойство
tags, c соответствующими значениями 0, 255, и 85 ($55 = 01010101 в
двоичной системе исчисления), вызывающие при нажатии обработчик события
ButtonStripesClick.

Кнопки "g" и "arrow" имеют собственные обработчики событий,
позволяющие корректно распечатать тестовые изображения на принтере HP
Laserjet.

"Random" случайным образом устанавливает биты в 1-битном изображении.

"Invert" меняет нули на единички и наоборот.

    // Пример того, как использовать Bitmap.Scanline для PixelFormat=pf1Bit.
    // По просьбе Mino Ballone из Италии.
    //
    // Авторское право (C) 1997, Earl F. Glynn, Overland Park, KS.
    // Все права защищены.
    // Может свободно использоваться для некоммерческих целей.
     
    unit ScreenSingleBit;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, ExtCtrls;
     
    type
     
      TForm1 = class(TForm)
        Image1: TImage;
        ButtonBlack: TButton;
        ButtonWhite: TButton;
        ButtonStripes: TButton;
        ButtonG: TButton;
        ButtonArrow: TButton;
        ButtonRandom: TButton;
        ButtonInvert: TButton;
        procedure ButtonStripesClick(Sender: TObject);
        procedure ButtonGClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure ButtonRandomClick(Sender: TObject);
        procedure ButtonInvertClick(Sender: TObject);
        procedure ButtonArrowClick(Sender: TObject);
      private
        Bitmap: TBitmap;
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    const
     
      BitsPerPixel = 8;
     
    procedure TForm1.ButtonStripesClick(Sender: TObject);
     
    var
      i: INTEGER;
      j: INTEGER;
      Row: pByteArray;
      Value: BYTE;
    begin
     
      Value := (Sender as TButton).Tag;
      // Value = $00 = 00000000 в двоичном исчислении для черного
      // Value = $FF = 11111111 в двоичном исчислении для белого
      // Value = $55 = 01010101 в двоичном исчислении для черных и белых полос
     
      for j := 0 to Bitmap.Height - 1 do
      begin
        Row := pByteArray(Bitmap.Scanline[j]);
        for i := 0 to (Bitmap.Width div BitsPerPixel) - 1 do
        begin
          Row[i] := Value
        end
      end;
     
      Image1.Picture.Graphic := Bitmap
    end;
     
    procedure TForm1.ButtonGClick(Sender: TObject);
     
    const
      {Изображение "g" было адаптировано для печати на принтере
      LaserJet IIP в соответствии с техническим руководством}
     
      G: array[0..31, 0..3] of BYTE =
        {0}(($00, $FC, $0F, $C0), {00000000 11111100 00001111 11000000}
        { 1}($07, $FF, $1F, $E0), {00000111 11111111 00011111 11100000}
        { 2}($0F, $FF, $9F, $C0), {00001111 11111111 10011111 11000000}
        { 3}($3F, $D7, $DE, $00), {00111111 11010111 11011110 00000000}
        { 4}($3E, $01, $FE, $00), {00111110 00000001 11111110 00000000}
        { 5}($7C, $00, $7E, $00), {01111100 00000000 01111110 00000000}
        { 6}($78, $00, $7E, $00), {01111000 00000000 01111110 00000000}
        { 7}($F0, $00, $3E, $00), {11110000 00000000 00111110 00000000}
        { 8}($F0, $00, $3E, $00), {11110000 00000000 00111110 00000000}
        { 9}($F0, $00, $1E, $00), {11110000 00000000 00011110 00000000}
        {10}($F0, $00, $1E, $00), {11110000 00000000 00011110 00000000}
        {11}($F0, $00, $1E, $00), {11110000 00000000 00011110 00000000}
        {12}($F0, $00, $1E, $00), {11110000 00000000 00011110 00000000}
        {13}($F0, $00, $3E, $00), {11110000 00000000 00111110 00000000}
        {14}($78, $00, $3E, $00), {01111000 00000000 00111110 00000000}
        {15}($78, $00, $3E, $00), {01111000 00000000 00111110 00000000}
        {16}($78, $00, $7E, $00), {01111000 00000000 01111110 00000000}
        {17}($3C, $00, $FE, $00), {00111100 00000000 11111110 00000000}
        {18}($1F, $D7, $DE, $00), {00011111 11010111 11011110 00000000}
        {19}($0F, $FF, $5E, $00), {00001111 11111111 10011110 00000000}
        {20}($07, $FF, $1E, $00), {00000111 11111111 00011110 00000000}
        {21}($00, $A8, $1E, $00), {00000000 10101000 00011110 00000000}
        {22}($00, $00, $1E, $00), {00000000 00000000 00011110 00000000}
        {23}($00, $00, $1E, $00), {00000000 00000000 00011110 00000000}
        {24}($00, $00, $1E, $00), {00000000 00000000 00011110 00000000}
        {25}($00, $00, $3E, $00), {00000000 00000000 00111110 00000000}
        {26}($00, $00, $3C, $00), {00000000 00000000 00111100 00000000}
        {27}($00, $00, $7C, $00), {00000000 00000000 01111100 00000000}
        {28}($00, $01, $F8, $00), {00000000 00000001 11111000 00000000}
        {29}($01, $FF, $F0, $00), {00000001 11111111 11110000 00000000}
        {30}($03, $FF, $E0, $00), {00000011 11111111 11100000 00000000}
        {31}($01, $FF, $80, $00)); {00000001 11111111 10000000 00000000}
     
    var
      i: INTEGER;
      j: INTEGER;
      Row: pByteArray;
    begin
     
      for j := 0 to Bitmap.Height - 1 do
      begin
        Row := pByteArray(Bitmap.Scanline[j]);
        for i := 0 to (Bitmap.Width div BitsPerPixel) - 1 do
        begin
          Row[i] := G[j, i]
        end
      end;
     
      Image1.Picture.Graphic := Bitmap
    end;
     
    procedure TForm1.ButtonArrowClick(Sender: TObject);
     
    const
      {Изображение "стрелка" было адаптировано для печати на принтере
      LaserJet IIP в соответствии с техническим руководством}
     
      Arrow: array[0..31, 0..3] of BYTE =
        {0}(($00, $00, $80, $00), {00000000 00000000 10000000 00000000}
        { 1}($00, $00, $C0, $00), {00000000 00000000 11000000 00000000}
        { 2}($00, $00, $E0, $00), {00000000 00000000 11100000 00000000}
        { 3}($00, $00, $F0, $00), {00000000 00000000 11110000 00000000}
        { 4}($00, $00, $F8, $00), {00000000 00000000 11111000 00000000}
        { 5}($00, $00, $FC, $00), {00000000 00000000 11111100 00000000}
        { 6}($00, $00, $FE, $00), {00000000 00000000 11111110 00000000}
        { 7}($00, $00, $FF, $00), {00000000 00000000 11111111 00000000}
        { 8}($00, $00, $FF, $80), {00000000 00000000 11111111 10000000}
        { 9}($FF, $FF, $FF, $C0), {11111111 11111111 11111111 11000000}
        {10}($FF, $FF, $FF, $E0), {11111111 11111111 11111111 11100000}
        {11}($FF, $FF, $FF, $F0), {11111111 11111111 11111111 11110000}
        {12}($FF, $FF, $FF, $F8), {11111111 11111111 11111111 11111000}
        {13}($FF, $FF, $FF, $FC), {11111111 11111111 11111111 11111100}
        {14}($FF, $FF, $FF, $FE), {11111111 11111111 11111111 11111110}
        {15}($FF, $FF, $FF, $FF), {11111111 11111111 11111111 11111111}
        {16}($FF, $FF, $FF, $FF), {11111111 11111111 11111111 11111111}
        {17}($FF, $FF, $FF, $FE), {11111111 11111111 11111111 11111110}
        {18}($FF, $FF, $FF, $FC), {11111111 11111111 11111111 11111100}
        {19}($FF, $FF, $FF, $F8), {11111111 11111111 11111111 11111000}
        {20}($FF, $FF, $FF, $F0), {11111111 11111111 11111111 11110000}
        {21}($FF, $FF, $FF, $E0), {11111111 11111111 11111111 11100000}
        {22}($FF, $FF, $FF, $C0), {11111111 11111111 11111111 11000000}
        {23}($00, $00, $FF, $80), {00000000 00000000 11111111 10000000}
        {24}($00, $00, $FF, $00), {00000000 00000000 11111111 00000000}
        {25}($00, $00, $FE, $00), {00000000 00000000 11111110 00000000}
        {26}($00, $00, $FC, $00), {00000000 00000000 11111100 00000000}
        {27}($00, $00, $F8, $00), {00000000 00000000 11111000 00000000}
        {28}($00, $00, $F0, $00), {00000000 00000000 11110000 00000000}
        {29}($00, $00, $E0, $00), {00000000 00000000 11100000 00000000}
        {30}($00, $00, $C0, $00), {00000000 00000000 11000000 00000000}
        {31}($00, $00, $80, $00)); {00000000 00000000 10000000 00000000}
     
    var
      i: INTEGER;
      j: INTEGER;
      Row: pByteArray;
    begin
     
      for j := 0 to Bitmap.Height - 1 do
      begin
        Row := pByteArray(Bitmap.Scanline[j]);
        for i := 0 to (Bitmap.Width div BitsPerPixel) - 1 do
        begin
          Row[i] := arrow[j, i]
        end
      end;
     
      Image1.Picture.Graphic := Bitmap
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
     
      Bitmap := TBitmap.Create;
      with Bitmap do
      begin
        Width := 32;
        Height := 32;
        PixelFormat := pf1bit
      end;
      Image1.Picture.Graphic := Bitmap
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
     
      Bitmap.Free
    end;
     
    procedure TForm1.ButtonRandomClick(Sender: TObject);
     
    var
      i: INTEGER;
      j: INTEGER;
      Row: pByteArray;
    begin
     
      for j := 0 to Bitmap.Height - 1 do
      begin
        Row := pByteArray(Bitmap.Scanline[j]);
        for i := 0 to (Bitmap.Width div BitsPerPixel) - 1 do
        begin
          Row[i] := Random(256)
        end
      end;
     
      Image1.Picture.Graphic := Bitmap
    end;
     
    procedure TForm1.ButtonInvertClick(Sender: TObject);
     
    var
      i: INTEGER;
      j: INTEGER;
      Row: pByteArray;
    begin
     
      for j := 0 to Bitmap.Height - 1 do
      begin
        Row := pByteArray(Bitmap.Scanline[j]);
        for i := 0 to (Bitmap.Width div BitsPerPixel) - 1 do
        begin
          Row[i] := not Row[i]
        end
      end;
     
      Image1.Picture.Graphic := Bitmap
    end;
     
    end.

