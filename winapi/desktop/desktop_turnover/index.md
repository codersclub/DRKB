---
Title: Переворачиваем рабочий стол
Author: William Egge
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Переворачиваем рабочий стол
===========================

Весёлая программка, которая позволяет подшутить над Вашими друзьями:-].
Пример переворачивает десктоп и держит его в таком положение, до тех пор
пока не кликнуть по нему мышкой. Помимо этого код содержит в себе
довольно интересные моменты.

В примере используется TDesktopCanvas, который получить доступ к
десктопу через объект TCanvas.

Так же в примере используется TQuickPixel, который позволяет увеличить
скорость доступа к пикселям.

Скачайте исходник, откомпилируйте его, и поместите программку в папку
"Автозагрузка" на компьютере Вашего друга и смело идите по своим делам :-).

Для завершения работы программки достаточно кликнуть по перевёрнутому
экрану.

А теперь давайте разберёмся с исходником:

Класс TQuickPixel был сделан для быстрого доступа к пикселям, чтобы не
возиться со строками развёртки. Для увеличения производительности,
данный класс кэширует строки развёртки. Единственный недостаток данного
класса заключается в том, что он устанавливает Ваш Bitmap в 24 бита.

Ниже представлен собственно сам код TQuickPixel.

    unit QuickPixel;
     
    interface
    uses
      Windows, Graphics;
     
    type
      TQuickPixel = class
      private
        FBitmap: TBitmap;
        FScanLines: array of PRGBTriple;
        function GetPixel(X, Y: Integer): TColor;
        procedure SetPixel(X, Y: Integer; const Value: TColor);
        function GetHeight: Integer;
        function GetWidth: Integer;
      public
        constructor Create(const ABitmap: TBitmap);
        property Pixel[X, Y: Integer]: TColor read GetPixel write SetPixel;
        property Width: Integer read GetWidth;
        property Height: Integer read GetHeight;
      end;
     
    implementation
     
    { TQuickPixel }
     
    constructor TQuickPixel.Create(const ABitmap: TBitmap);
    var
      I: Integer;
    begin
      inherited Create;
      FBitmap:= ABitmap;
      FBitmap.PixelFormat:= pf24bit;
      SetLength(FScanLines, FBitmap.Height);
      for I:= 0 to FBitmap.Height-1 do
        FScanLines[I]:= FBitmap.ScanLine[I];
    end;
     
    function TQuickPixel.GetHeight: Integer;
    begin
      Result:= FBitmap.Height;
    end;
     
    function TQuickPixel.GetPixel(X, Y: Integer): TColor;
    var
      P: PRGBTriple;
    begin
      P:= FScanLines[Y];
      Inc(P, X);
      Result:= (P^.rgbtBlue shl 16) or (P^.rgbtGreen shl 8) or P^.rgbtRed;
    end;
     
    function TQuickPixel.GetWidth: Integer;
    begin
      Result:= FBitmap.Width;
    end;
     
    procedure TQuickPixel.SetPixel(X, Y: Integer; const Value: TColor);
    var
      P: PRGBTriple;
    begin
      P:= FScanLines[Y];
      Inc(P, X);
      P^.rgbtBlue:= (Value and $FF0000) shr 16;
      P^.rgbtGreen:= (Value and $00FF00) shr 8;
      P^.rgbtRed:= Value and $0000FF;
    end;
     
    end.

Ну, надеюсь, вы с ним разобрались, перейдём же к самому проекту.
Свойство окна BorderStyle установите в bsNone, свойство FormStyle - в
fsStayOnTop, а свойству WindowState задайте значение wsMaximized.
Вынесите на форму компонент TImage, его свойство Align выставьте в
alClient, по нажатию на TImage напишите:

    Close;

Затем следующим образом опишите обработчик создания окна [событие
OnCreate()]:

    procedure TForm1.FormCreate(Sender: TObject);
    var
      B: TBitmap;
      Desktop: TDesktopCanvas;
      QP: TQuickPixel;
      X, Y: Integer;
      EndCopyIndex: Integer;
      Temp: TColor;
    begin
      Left:= 0;
      Top:= 0;
      Width:= Screen.Width;
      Height:= Screen.Height;
      B:= nil;
      Desktop:= nil;
      try
        Desktop:= TDesktopCanvas.Create;
        B:= TBitmap.Create;
        B.Width:= Screen.Width;
        B.Height:= Screen.Height;
        B.Canvas.CopyRect(Rect(0, 0, B.Width, B.Height),
        Desktop, Rect(0, 0, B.Width, B.Height));
        B.PixelFormat:= pf24bit;
        QP:= TQuickPixel.Create(B);
        try
          for Y:= 0 to (QP.Height div 2)-1 do
          begin
            EndCopyIndex:= (QP.Height-1)-Y;
            for X:= 0 to QP.Width-1 do
            begin
              Temp:= QP.Pixel[X, Y];
              QP.Pixel[X, Y]:= QP.Pixel[X, EndCopyIndex];
              QP.Pixel[X, EndCopyIndex]:= Temp;
            end;
          end;
        finally
          QP.Free;
        end;
        with Image1.Picture.Bitmap do
        begin
          Width:= Image1.Width;
          Height:= Image1.Height;
          Canvas.CopyRect(Rect(0, 0, Width, Height), B.Canvas,
          Rect(0, 0, Width, Height));
        end;
      finally
        B.Free;
        Desktop.Free;
      end;
    end;

Проверьте, все ли модули у вас подключены. Раздел uses должен выглядеть
так:

    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, ExtCtrls, DesktopCanvas, QuickPixel;


