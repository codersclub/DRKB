---
Title: Как считать сигнал с микрофона?
Date: 01.01.2007
---


Как считать сигнал с микрофона?
===============================

::: {.date}
01.01.2007
:::

В Windows нет разделения каналов записи по источникам.

CD-ROM \-\-\-\-\-\-\-\-\--\|

                \|             \|\-\-- Динамики

Микрофон \-\-\-\-\-\-\--\|             \|

                \|\-- Windows \--\|\-\-- Записывающие программы

Линейный вход \-\--\|             \|

                \|             \|\-\-- Линейный выход

MIDI \-\-\-\-\-\-\-\-\-\-\--\|

Все поступающие в систему звуки смешиваются, и лишь после этого их
получает программа.

Для получения звукового сигнала нужно воспользоваться WinAPI.

WaveInOpen открывает доступ к микрофону.

Одновременно только одна программа может работать с микрофоном.

Заодно Вы указываете, какая нужна частота, сколько бит на значение и
размер буфера.

От последнего зависит, как часто и в каком объеме информация будет
поступать в программу.

Далее нужно выделить память для буфера и вызвать функцию
WaveInAddBuffer,

которая передаст Windows пустой буфер.

После вызова WaveInStart Windows начнет заполнять буфер,

и, после его заполнения, пошлет сообщение MM\_WIM\_DATA.

В нем нужно обработать полученную информацию и вновь вызвать
WaveInAddBuffer,

тем самым указав, что буфер пуст.

Функции WaveInReset и WaveInClose прекратят поступление информации в
программу и закроют доступ к микрофону.

Эта программа считывает сигнал с микрофона и выводит его на экран.

Частота сигнала - 22050 Гц. Количество бит определяется флажком, размер
буфера TrackBar-ом.

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ExtCtrls, ComCtrls, MMSystem;
     
    type
      TData8 = array [0..127] of byte;
      PData8 = ^TData8;
      TData16 = array [0..127] of smallint;
      PData16 = ^TData16;
      TPointArr = array [0..127] of TPoint;
      PPointArr = ^TPointArr;
      TForm1 = class(TForm)
        Button1: TButton;
        Button2: TButton;
        PaintBox1: TPaintBox;
        TrackBar1: TTrackBar;
        CheckBox1: TCheckBox;
        procedure Button1Click(Sender: TObject);
        procedure Button2Click(Sender: TObject);
        procedure FormDestroy(Sender: TObject);
        procedure CheckBox1Click(Sender: TObject);
        procedure FormCreate(Sender: TObject);
      private
        { Private declarations }
      public
        procedure OnWaveIn(var Msg: TMessage); message MM_WIM_DATA;
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.DFM}
     
    var
      WaveIn: hWaveIn;
      hBuf: THandle;
      BufHead: TWaveHdr;
      bufsize: integer;
      Bits16: boolean;
      p: PPointArr;
      stop: boolean = false;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      header: TWaveFormatEx;
      BufLen: word;
      buf: pointer;
    begin
      BufSize := TrackBar1.Position * 500 + 100; { Размер буфера }
      Bits16 := CheckBox1.Checked;
      with header do begin
        wFormatTag := WAVE_FORMAT_PCM;
        nChannels := 1;  { количество каналов }
        nSamplesPerSec := 22050; { частота }
        wBitsPerSample := integer(Bits16) * 8 + 8; { 8 / 16 бит }
        nBlockAlign := nChannels * (wBitsPerSample div 8);
        nAvgBytesPerSec := nSamplesPerSec * nBlockAlign;
        cbSize := 0;
      end;
      WaveInOpen(Addr(WaveIn), WAVE_MAPPER, addr(header),
        Form1.Handle, 0, CALLBACK_WINDOW);
      BufLen := header.nBlockAlign * BufSize;
      hBuf := GlobalAlloc(GMEM_MOVEABLE and GMEM_SHARE, BufLen);
      Buf := GlobalLock(hBuf);
      with BufHead do begin
        lpData := Buf;
        dwBufferLength := BufLen;
        dwFlags := WHDR_BEGINLOOP;
      end;
      WaveInPrepareHeader(WaveIn, Addr(BufHead), sizeof(BufHead));
      WaveInAddBuffer(WaveIn, addr(BufHead), sizeof(BufHead));
      GetMem(p, BufSize * sizeof(TPoint));
      stop := true;
      WaveInStart(WaveIn);
    end;
     
    procedure TForm1.Button2Click(Sender: TObject);
    begin
      if stop = false then Exit;
      stop := false;
      while not stop do Application.ProcessMessages;
      stop := false;
      WaveInReset(WaveIn);
      WaveInUnPrepareHeader(WaveIn, addr(BufHead), sizeof(BufHead));
      WaveInClose(WaveIn);
      GlobalUnlock(hBuf);
      GlobalFree(hBuf);
      FreeMem(p, BufSize * sizeof(TPoint));
    end;
     
    procedure TForm1.OnWaveIn;
    var
      i: integer;
      data8: PData8;
      data16: PData16;
      h: integer;
      XScale, YScale: single;
    begin
      h := PaintBox1.Height;
      XScale := PaintBox1.Width / BufSize;
      if Bits16 then begin
        data16 := PData16(PWaveHdr(Msg.lParam)^.lpData);
        YScale := h / (1 shl 16);
        for i := 0 to BufSize - 1 do
          p^[i] := Point(round(i * XScale),
            round(h / 2 - data16^[i] * YScale));
      end else begin
        Data8 := PData8(PWaveHdr(Msg.lParam)^.lpData);
        YScale := h / (1 shl 8);
        for i := 0 to BufSize - 1 do
          p^[i] := Point(round(i * XScale),
            round(h - data8^[i] * YScale));
      end;
      with PaintBox1.Canvas do begin
        Brush.Color := clWhite;
        FillRect(ClipRect);
        Polyline(Slice(p^, BufSize));
      end;
      if stop
        then WaveInAddBuffer(WaveIn, PWaveHdr(Msg.lParam),
          SizeOf(TWaveHdr))
        else stop := true;
    end;
     
    procedure TForm1.FormDestroy(Sender: TObject);
    begin
      Button2.Click;
    end;
     
    procedure TForm1.CheckBox1Click(Sender: TObject);
    begin
      if stop then begin
        Button2.Click;
        Button1.Click;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      TrackBar1.OnChange := CheckBox1Click;
      Button1.Caption := 'Start';
      Button2.Caption := 'Stop';
      CheckBox1.Caption := '16 / 8 bit';
    end;
     
    end.

Даниил Карапетян.

На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.

Email: <delphi4all@narod.ru>
