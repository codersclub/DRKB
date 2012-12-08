---
Title: Снятие звука с микрофона, отображение звуковые данных в виде графика
Author: Rouse\_
Date: 01.01.2007
---


Снятие звука с микрофона, отображение звуковые данных в виде графика
====================================================================

::: {.date}
01.01.2007
:::

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Forms,
      Dialogs, MMSystem;
     
    type
      TWavArrayBuf = array[0..1023]of byte;
      PWavArrayBuf = ^TWavArrayBuf;
     
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
        procedure FormClose(Sender: TObject; var Action: TCloseAction);
      private
        WaveFormat: TWaveFormatEx;
        WaveIn: PHWaveIn;
        procedure WndProc(var Msg: TMessage); override;
        function InitWaveIn: Boolean;
        procedure CloseWaveIn;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    uses Math;
     
    {$R *.dfm}
     
    function TForm1.InitWaveIn: Boolean;
    var
      I, Err: Integer;
      WaveHdr: PWaveHdr;
      WavBuff: PWavArrayBuf;
     
      procedure FreeData;
      begin
        if WavBuff <> nil then Dispose(WavBuff);
        if WaveHdr <> nil then Dispose(WaveHdr);
        if WaveIn <> nil then Dispose(WaveIn);
      end;
     
    begin
      Result := False;
      WaveFormat.wFormatTag := WAVE_FORMAT_PCM;
      WaveFormat.nChannels := 1; 
      WaveFormat.nSamplesPerSec := 44100;
      WaveFormat.nAvgBytesPerSec := 44100;
      WaveFormat.nBlockAlign := 4;
      WaveFormat.wBitsPerSample := 8;
      WaveIn := New(PHWaveIn);
      Err := WaveInOpen(WaveIn, 0, @WaveFormat, Handle, 0, CALLBACK_WINDOW);
      if Err <> 0 then Exit;
      for i:=1 to 8 do
      begin
        WavBuff := New(PWavArrayBuf);
        WaveHdr := New(PWaveHdr);
        with WaveHdr^ do
        begin
          lpData := Pointer(WavBuff);
          dwBufferLength := SizeOf(WavBuff);
          dwBytesRecorded := 0;
          dwUser := 0;
          dwFlags := 0;
          dwLoops := 0;
        end;
        Err := WaveInPrepareHeader(WaveIn^, WaveHdr, SizeOf(TWaveHdr));
        if Err <> 0 then
        begin
          FreeData;
          Exit;
        end;
        Err := WaveInAddBuffer(WaveIn^, WaveHdr, Sizeof(TWaveHdr));
        if Err <> 0 then
        begin
          FreeData;
          Exit;
        end;
      end;
      Err := WaveInStart(WaveIn^);
      if Err <> 0 then
      begin
        FreeData;
        Exit;
      end;
      Result := True;
    end;
     
    Procedure Tform1.WndProc(var Msg: TMessage);
    var
      Hdr: PWaveHdr;
      I: Integer;
      R: Real;
    begin
      inherited;
      case Msg.Msg of
        MM_WIM_DATA:
        begin
          Hdr := PWaveHdr(Msg.LParam);
          if Hdr^.dwBytesRecorded = 0 then Exit;
          R := IfThen(Hdr^.dwBytesRecorded > 0,
            ClientWidth / Hdr^.dwBytesRecorded, 0);
          PatBlt(Canvas.Handle, 0, 0, ClientWidth,  ClientHeight, PATCOPY);
          Canvas.Pen.Color:=clRed;
          Canvas.MoveTo(0, 127);
          Canvas.LineTo(ClientWidth, 127);
          Canvas.Pen.Color := clMaroon;
          for I := 1 to 12 do
          begin
            Canvas.MoveTo(Round(R * (I * 100)), 0);
            Canvas.LineTo(Round(R * (I * 100)), 255);
          end;
          Canvas.Pen.Color:=clLime;
          Canvas.MoveTo(0, PWavArrayBuf(Hdr.lpData)^[0]);
          for I := 0 to Hdr^.dwBytesRecorded - 1 do
            Canvas.LineTo(Round(R * I), PWavArrayBuf(Hdr.lpData)^[I]);
     
          WaveInUnprepareHeader(WaveIn^, Hdr, Sizeof(TWaveHdr));
          Dispose(hdr.lpData);
          DisPose(hdr);
     
          Hdr := New(PWaveHdr);
          Hdr^.lpData := Pointer(New(PWavArrayBuf));
          Hdr^.dwBufferLength := 1024;
          Hdr^.dwBytesRecorded := 0;
          Hdr^.dwUser := 0;
          Hdr^.dwFlags := 0;
          Hdr^.dwLoops := 0;
     
          WaveInPrepareHeader(WaveIn^, Hdr, Sizeof(TWaveHdr));
          WaveInAddBuffer(WaveIn^, Hdr, Sizeof(TWaveHdr));
        end;
      end;
    end;
     
    procedure TForm1.CloseWaveIn;
    begin
      WaveInStop(WaveIn^);
      if WaveIn <> nil then
      begin
        WaveInReset(WaveIn^);
        WaveInClose(WaveIn^);
      end;
      Dispose(WaveIn);
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      DoubleBuffered := True;
      Height := 282;
      Width := 1000;
      Color := clBlack;
      if not InitWaveIn then ShowMessage(SysErrorMessage(GetLastError));
    end;
     
    procedure TForm1.FormClose(Sender: TObject; var Action: TCloseAction);
    begin
      CloseWaveIn;
    end;
     
    end.

 \
 \

Автор: Rouse\_

Взято из <https://forum.sources.ru>
