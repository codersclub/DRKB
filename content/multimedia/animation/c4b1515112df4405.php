<h1>Информация об AVI-файле (разбор заголовка AVI)</h1>
<div class="date">01.01.2007</div>


<pre>
unit Unit1;
 
interface
 
uses
  Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
  Dialogs, StdCtrls;
 
Type
  TForm1 = class(TForm)
    Memo1: TMemo;
    OpenDialog1: TOpenDialog;
    Button1: TButton;
    procedure Button1Click(Sender: TObject);
  Public
    procedure ReadAviInfo(FileName: String);
  End;
 
var
  Form1: TForm1;
 
implementation
 
{$R *.dfm}
 
procedure TForm1.ReadAviInfo(FileName: String);
var
  iFileHandle: Integer; // хэндл файла
 
  // Для позмционирования в AVI файле
  Aviheadersize: Integer;
  Vheadersize: Integer;
  Aviheaderstart: Integer;
  Vheaderstart: Integer;
  Aheaderstart: Integer;
  Astrhsize: Integer;
 
  // Временные переменные
  TempTest: String[5];
  TempSize: Integer;
  TempVcodec: String[5];
  TempAcodec: Integer;
  TempMicrosec: Integer;
  TempLengthInFrames: Integer;
  TempAchannels: Integer;
  TempAsamplerate: Integer;
  TempAbitrate: Integer;
 
  //Выходные данные
  Size: Double;
  Length: String;
  Vcodec: String;
  Vbitrate: Double;
  VWidth: Integer;
  VHeight: Integer;
  Fps: Double;
 
  LengthInSec: Double;
  Acodec: String;
  Abitrate: String;
begin
  // Открываем
  iFileHandle := FileOpen(FileName, fmOpenRead);
 
  // Грубая проверка на подлинность файла
  FileSeek(iFileHandle, 7, 0);
  FileRead(iFileHandle, TempTest, 5);
  If copy(TempTest, 0, 4) &lt;&gt; 'AVI ' then
  begin
    MessageDlg('Could not open ' + FileName + ' because it is not a valid video file', mtError, [mbOk], 0);
    Exit;
  End;
 
  // Размер файла
  FileSeek(iFileHandle,4,0);
  FileRead(iFileHandle, TempSize, 4);
 
  // Размер хедера (needed To locate the audio part)
  FileSeek(iFileHandle,28,0);
  FileRead(iFileHandle, Aviheadersize, 4);
 
  // старт хедера  (needed To locate the video part)
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
  If Vcodec = 'div2' then Vcodec := 'MS MPEG4 v2'
  Else If Vcodec = 'DIV2' then Vcodec := 'MS MPEG4 v2'
  Else If Vcodec = 'div3' then Vcodec := 'DivX;-) MPEG4 v3'
  Else If Vcodec = 'DIV3' then Vcodec := 'DivX;-) MPEG4 v3'
  Else If Vcodec = 'div4' then Vcodec := 'DivX;-) MPEG4 v4'
  Else If Vcodec = 'DIV4' then Vcodec := 'DivX;-) MPEG4 v4'
  Else If Vcodec = 'div5' then Vcodec := 'DivX;-) MPEG4 v5'
  Else If Vcodec = 'DIV5' then Vcodec := 'DivX;-) MPEG4 v5'
  Else If Vcodec = 'divx' then Vcodec := 'DivX 4'
  Else If Vcodec = 'mp43' then Vcodec := 'Microcrap MPEG4 v3';
 
  // тоже с аудио 
  Case TempAcodec of
    0: Acodec := 'PCM';
    1: Acodec := 'PCM';
    85: Acodec := 'MPEG Layer 3';
    353: Acodec := 'DivX;-) Audio';
    8192: Acodec := 'AC3-Digital';
  Else
    Acodec := 'Unknown (' + IntToStr(TempAcodec) + ')';
  End;
 
  Case (Trunc(TempAbitrate / 1024 * 8)) of
    246..260: Abitrate := '128 Kbit/s';
    216..228: Abitrate := '128 Kbit/s';
    187..196: Abitrate := '128 Kbit/s';
    156..164: Abitrate := '128 Kbit/s';
    124..132: Abitrate := '128 Kbit/s';
    108..116: Abitrate := '128 Kbit/s';
    92..100: Abitrate := '128 Kbit/s';
    60..68: Abitrate := '128 Kbit/s';
  Else
    Abitrate := FormatFloat('# Kbit/s', TempAbitrate / 1024 * 8);
  End;
 
  // тут некоторые вычисления
  Size := TempSize / 1024 / 1024;
  Fps := 1000000 / TempMicrosec; // FPS
  LengthInSec := TempLengthInFrames / fps; // Length In seconds
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
End;
 
procedure TForm1.Button1Click(Sender: TObject);
begin
  If OpenDialog1.Execute Then ReadAviInfo(OpenDialog1.FileName);
End;
 
end.
</pre>
<p class="author">Автор Rouse_</p>
<p>Взято из <a href="https://forum.sources.ru" target="_blank">https://forum.sources.ru</a></p>
