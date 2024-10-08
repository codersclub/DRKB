---
Title: Преобразование иконок в Gliph-ы
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---

Преобразование иконок в Gliph-ы
===============================

Вот небольшой пример того, как можно загрузить иконку, содержащуюся в
файле EXE, в Glyph у SpeedButton, и как очистить этот самый Glyph.

Огорчен, но комментарии в исходном коде на испанском языке.

    unit Procs;
     
    interface
    
    uses
      SysUtils, WinTypes, WinProcs, Messages, Classes, Graphics, Controls,
      Forms, StdCtrls, Buttons, ExtCtrls, ShellAPI;
     
    procedure LlenaBoton(boton: TSpeedButton; Programa: string);
    procedure LimpiaBoton(boton: TSpeedButton);
     
    var
      {Botones de programas}
      Pic: TPicture;
      Fname: string;
      TempFile: array[0..255] of Char;
      Icon: TIcon;
     
    implementation
    uses ttotro;
     
    procedure LlenaBoton(boton: TSpeedButton; Programa: string);
     
    var
      NumFiles, NameLength: integer;
      nIconsInFile: word;
      rBoton: TRect;
      oBitmap: TBitmap;
      oBitmap2: TBitmap;
      NombreBitmap: string;
     
    begin
      try
        screen.cursor := crHourglass;
     
        {Extrae el Icono}
        Icon := TIcon.Create;
        StrPCopy(TempFile, Programa);
        Icon.Handle := ExtractIcon(HInstance, TempFile, 0);
     
        {Crea una instancia de TPicture}
        Pic := TPicture.Create;
        {Asigna el icon.handle a la propiedad Pic.icon}
     
        Pic.Icon := Icon;
     
        {Configura el tamano del bitmap como el del icono y el del segundo
        bitmap con el tamano del boton}
        oBitmap := TBitMap.create;
        oBitmap2 := TBitMap.create;
        oBitmap2.Width := Icon.Width;
        oBitmap2.Height := Icon.Height;
        oBitmap.Width := boton.Width - 4;
        oBitmap.Height := boton.Height - 4;
     
        { Dibuja el icono en el bitmap }
        oBitmap2.Canvas.Draw(0, 0, Pic.Graphic);
        rBoton.left := 1;
        rBoton.Top := 1;
        rBoton.right := boton.Width - 6;
        rBoton.Bottom := boton.Height - 6;
        oBitmap.Canvas.StretchDraw(rBoton, oBitmap2);
     
        Boton.Hint := Programa;
     
        NombreBitmap := Copy(programa, 1, Length(programa) - 3) + 'BMP';
        {Salva el bitmap en un fichero}
        if not FileExists(NombreBitmap) then
        begin
          oBitmap.SaveToFile(ExtractFilePath(Application.ExeName) +
            ExtractFileName(NombreBitmap));
          Boton.Glyph := oBitmap;
        end
        else
          {Carga el BMP en el boton}
          Boton.Glyph.LoadFromFile(ExtractFilePath(Application.ExeName) +
            ExtractFileName(NombreBitmap));
     
      finally
        Icon.Free;
        oBitmap.Free;
        oBitmap2.Free;
        screen.cursor := crDefault;
     
      end; {main begin}
    end; {llenaboton}
     
    procedure LimpiaBoton(boton: TSpeedButton);
    var
      oBitmap: TBitmap;
      rBoton: TRect;
    begin
      try
        {Configuara el tamano del bitmap como el del icono y el del segundo
        bitmap con el tamano del boton}
        oBitmap := TBitMap.create;
        oBitmap.Width := boton.Width - 4;
        oBitmap.Height := boton.Height - 4;
        Boton.Glyph := oBitmap;
     
      finally
        oBitmap.Free;
      end; {main begin}
    end; {limpiaboton}
     
    end.

