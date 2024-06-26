---
Title: Информация о AVI файле (разбор заголовка AVI)
Author: Rouse\_
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Информация о AVI файле (разбор заголовка AVI)
=============================================

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls;
     
    type
      TForm1 = class(TForm)
        Memo1: TMemo;
        OpenDialog1: TOpenDialog;
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
      public
        procedure ReadAviInfo(FileName: string);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure TForm1.ReadAviInfo(FileName: string);
    var
      iFileHandle: Integer; // хэндл файла
     
      // Для позмционирования в AVI файле
      Aviheadersize: integer;
      Vheadersize: integer;
      Aviheaderstart: integer;
      Vheaderstart: integer;
      Aheaderstart: integer;
      Astrhsize: integer;
     
      // Временные переменные
      TempTest: String[5];
      TempSize: Integer;
      TempVcodec: String[5];
      TempAcodec: integer;
      TempMicrosec: integer;
      TempLengthInFrames: integer;
      TempAchannels: integer;
      TempAsamplerate: integer;
      TempAbitrate: integer;
     
      //Выходные данные
      Size: double;
      Length: string;
      Vcodec: string;
      Vbitrate: double;
      VWidth: integer;
      VHeight: integer;
      Fps: double;
     
      LengthInSec: double;
      Acodec: string;
      Abitrate: string;
    begin
      // Открываем
      iFileHandle := FileOpen(FileName, fmOpenRead);
     
      // Грубая проверка на подлинность файла
      FileSeek(iFileHandle, 7, 0);
      FileRead(iFileHandle, TempTest, 5);
      if copy(TempTest, 0, 4) <> 'AVI ' then
      begin
        MessageDlg('Could not open ' + FileName + ' because it is not a valid video file', mtError, [mbOk], 0);
        Exit;
      end;
     
      // Размер файла
      FileSeek(iFileHandle,4,0);
      FileRead(iFileHandle, TempSize, 4);
     
      // Размер хедера (needed to locate the audio part)
      FileSeek(iFileHandle,28,0);
      FileRead(iFileHandle, Aviheadersize, 4);
     
      // старт хедера  (needed to locate the video part)
      Aviheaderstart := 32;
     
      // Милисекунды (1000000 / TempMicrosec = fps)
      FileSeek(iFileHandle,Aviheaderstart,0);
      FileRead(iFileHandle, TempMicrosec, 4);
     
      // Размер во фреймах
      FileSeek(iFileHandle,Aviheaderstart + 16,0);
      FileRead(iFileHandle, TempLengthInFrames, 4);
     
      // Ширина
      FileSeek(iFileHandle,Aviheaderstart + 32,0);
      FileRead(iFileHandle, VWidth, 4);
     
      // Высота
      FileSeek(iFileHandle,Aviheaderstart + 36,0);
      FileRead(iFileHandle, VHeight, 4);
     
      FileSeek(iFileHandle,Aviheaderstart + Aviheadersize + 4,0);
      FileRead(iFileHandle, Vheadersize, 4);
     
      Vheaderstart := Aviheaderstart + Aviheadersize + 20;
     
      // кодек
      FileSeek(iFileHandle,Vheaderstart + 3,0);
      FileRead(iFileHandle, TempVCodec, 5);
     
      Aheaderstart := Vheaderstart + Vheadersize + 8;
     
      FileSeek(iFileHandle,Aheaderstart - 4,0);
      FileRead(iFileHandle, Astrhsize, 5);
     
      // Audio codec
      FileSeek(iFileHandle,Aheaderstart + Astrhsize + 8,0);
      FileRead(iFileHandle, TempACodec, 2);
     
      // Audio каналы (1 = mono, 2 = stereo)
      FileSeek(iFileHandle,Aheaderstart + Astrhsize + 10,0);
      FileRead(iFileHandle, TempAchannels, 2);
     
      // Audio samplerate
      FileSeek(iFileHandle,Aheaderstart + Astrhsize + 12,0);
      FileRead(iFileHandle, TempAsamplerate, 4);
     
      // Audio bitrate
      FileSeek(iFileHandle,Aheaderstart + Astrhsize + 16,0);
      FileRead(iFileHandle, TempAbitrate, 4);
     
      // закрываем файл
      FileClose(iFileHandle);
     
      // анализируем видео кодек (можно добавить больше)
      Vcodec := copy(TempVcodec, 0, 4);
      if Vcodec = 'div2' then Vcodec := 'MS MPEG4 v2'
      else if Vcodec = 'DIV2' then Vcodec := 'MS MPEG4 v2'
      else if Vcodec = 'div3' then Vcodec := 'DivX;-) MPEG4 v3'
      else if Vcodec = 'DIV3' then Vcodec := 'DivX;-) MPEG4 v3'
      else if Vcodec = 'div4' then Vcodec := 'DivX;-) MPEG4 v4'
      else if Vcodec = 'DIV4' then Vcodec := 'DivX;-) MPEG4 v4'
      else if Vcodec = 'div5' then Vcodec := 'DivX;-) MPEG4 v5'
      else if Vcodec = 'DIV5' then Vcodec := 'DivX;-) MPEG4 v5'
      else if Vcodec = 'divx' then Vcodec := 'DivX 4'
      else if Vcodec = 'mp43' then Vcodec := 'Microcrap MPEG4 v3';
     
      // тоже с аудио 
      case TempAcodec of
        0: Acodec := 'PCM';
        1: Acodec := 'PCM';
        85: Acodec := 'MPEG Layer 3';
        353: Acodec := 'DivX;-) Audio';
        8192: Acodec := 'AC3-Digital';
      else
        Acodec := 'Unknown (' + IntToStr(TempAcodec) + ')';
      end;
     
      case (Trunc(TempAbitrate / 1024 * 8)) of
        246..260: Abitrate := '128 Kbit/s';
        216..228: Abitrate := '128 Kbit/s';
        187..196: Abitrate := '128 Kbit/s';
        156..164: Abitrate := '128 Kbit/s';
        124..132: Abitrate := '128 Kbit/s';
        108..116: Abitrate := '128 Kbit/s';
        92..100: Abitrate := '128 Kbit/s';
        60..68: Abitrate := '128 Kbit/s';
      else
        Abitrate := FormatFloat('# Kbit/s', TempAbitrate / 1024 * 8);
      end;
     
      // тут некоторые вычисления
      Size := TempSize / 1024 / 1024;
      Fps := 1000000 / TempMicrosec; // FPS
      LengthInSec := TempLengthInFrames / fps; // Length in seconds
      Length := FormatFloat('# min', Int(LengthInSec / 60)) + FormatFloat(' # sec',
        Round(LengthInSec - (Int(LengthInSec / 60) * 60)));
      Vbitrate := (TempSize / LengthInSec - TempABitrate) / 1024 * 8;
     
      // Выводим инфу в мемо
      Memo1.Lines.Add('AVI INFORMATION');
      Memo1.lines.Add('Size: ' + FormatFloat('#.## MB',Size));
      Memo1.Lines.Add('Length: ' + Length);
      Memo1.Lines.Add('');
      Memo1.Lines.Add('VIDEO INFORMATION');
      Memo1.Lines.Add('Codec: ' + Vcodec);
      Memo1.Lines.Add('Bitrate: ' + FormatFloat('# Kbit/s', Vbitrate));
      Memo1.lines.Add('Width: ' + IntToStr(VWidth) + ' px');
      Memo1.lines.Add('Height: ' + IntToStr(VHeight) + ' px');
      Memo1.Lines.Add('FPS: ' + FormatFloat('#.##', fps));
      Memo1.Lines.Add('');
      Memo1.Lines.Add('AUDIO INFORMATION');
      Memo1.Lines.Add('Codec: ' + Acodec);
      Memo1.Lines.Add('Bitrate: ' + Abitrate);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      if OpenDialog1.Execute then ReadAviInfo(OpenDialog1.FileName);
    end;
     
    end.

