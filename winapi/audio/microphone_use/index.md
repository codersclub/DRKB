---
Title: Как можно получить звук с микрофона?
Author: cully
Source: Vingrad.ru <https://forum.vingrad.ru>
Date: 01.01.2007
---


Как можно получить звук с микрофона?
====================================

```delphi
unit receiver;

interface

uses mmsystem, Classes;

const
  samp_per_sec = 44100;
  samp_cnt = samp_per_sec div 5;
  buf_len = samp_cnt * 2;

type
  PSample16M = ^TSample16M;
  TSample16M = SmallInt;
  PArrayOfSample = ^TArrayOfSample;
  TArrayOfSample = array[1..samp_cnt] of TSample16M;

  TReceiver = class
  private
    hwi: Integer;
    fmt: tWAVEFORMATEX;
    whdr1: WAVEHDR;
    buf1: TArrayOfSample;
    whdr2: WAVEHDR;
    buf2: TArrayOfSample;
    FStoped: Boolean;
    FOnChange: TNotifyEvent;
    procedure SetStoped(const Value: Boolean);
  public
    Peak: Integer;
    Buffer: PArrayOfSample;
    destructor Destroy; override;
    procedure Start;
    procedure Stop;
    property Stoped: Boolean read FStoped write SetStoped;
    property OnChange: TNotifyEvent read FOnChange write FOnChange;
  end;

var
  rec: TReceiver;

implementation

procedure waveInProc(const hwi, uMsg, dwInstance: Integer; var hdr: WAVEHDR;
  const dwP2: Integer); stdcall;
const
  divs = samp_cnt div 100;
var
  i, p: Integer;
  buf: PArrayOfSample;
begin
  if rec.Stoped then
    Exit;
  case uMsg of
    WIM_OPEN:
    begin
    end;
    WIM_DATA:
    begin
      rec.Buffer := PArrayOfSample(hdr.lpData);
      buf := PArrayOfSample(hdr.lpData);
      p := 0;
      for i := 0 to samp_cnt div divs do
        p := p + Abs(buf[i * divs]);
      rec.Peak := p div (samp_cnt div divs);
      if Assigned(rec.FOnChange) then
        rec.FOnChange(rec);
      waveInUnprepareHeader(hwi, @hdr, SizeOf(WAVEHDR));
      waveInPrepareHeader(hwi, @hdr, SizeOf(WAVEHDR));
      waveInAddBuffer(hwi, @hdr, SizeOf(WAVEHDR));
    end;
    WIM_CLOSE:
    begin
    end;
  end;
end;

{ TReceiver }

destructor TReceiver.Destroy;
begin
  Stoped := True;
  inherited;
end;

procedure TReceiver.SetStoped(const Value: Boolean);
begin
  FStoped := Value;
  if Value then
  begin
    waveInStop(hwi);
    waveInUnprepareHeader(hwi, @whdr1, SizeOf(WAVEHDR));
    waveInUnprepareHeader(hwi, @whdr2, SizeOf(WAVEHDR));
    waveInReset(hwi);
    waveInClose(hwi);
  end
  else
  begin
    with fmt do
    begin
      wFormatTag := WAVE_FORMAT_PCM;
      nChannels := 1;
      nSamplesPerSec := samp_per_sec;
      nBlockAlign := 2;
      nAvgBytesPerSec := nSamplesPerSec * nBlockAlign;
      wBitsPerSample := 16;
      cbSize := 0;
    end;
    waveInOpen(@hwi, WAVE_MAPPER, @fmt, cardinal(@waveInProc), hInstance, CALLBACK_FUNCTION);
    with whdr1 do
    begin
      lpData := @buf1;
      dwBufferLength := buf_len;
      dwBytesRecorded := 0;
      dwUser := 0;
      dwFlags := 0;
      dwLoops := 0;
      lpNext := nil;
      reserved := 0;
    end;
    waveInPrepareHeader(hwi, @whdr1, SizeOf(WAVEHDR));
    waveInAddBuffer(hwi, @whdr1, SizeOf(WAVEHDR));
    with whdr2 do
    begin
      lpData := @buf2;
      dwBufferLength := buf_len;
      dwBytesRecorded := 0;
      dwUser := 0;
      dwFlags := 0;
      dwLoops := 0;
      lpNext := nil;
      reserved := 0;
    end;
    waveInPrepareHeader(hwi, @whdr2, SizeOf(WAVEHDR));
    waveInAddBuffer(hwi, @whdr2, SizeOf(WAVEHDR));
    waveInStart(hwi);
  end;
end;

procedure TReceiver.Start;
begin
  Stoped := False;
end;

procedure TReceiver.Stop;
begin
  Stoped := True;
end;

initialization
  rec := TReceiver.Create;

finalization
  rec.Free;
end.
```

вот.
отображать уровень можно через поле Peak при событии OnChange, там
же (в этом событии) можно работать с полем Buffer в котором как раз
содержется записанный сигнал.

Вся работа осуществляется через глобальную переменную rec.
Возможно это не лучшая реализация с точки зрения ООП, но работает.
Запись происходит с глубиной 16 бит и частотой 44100 в режиме моно.
После небольшой переделки все это может работать с любыми частотами
и каналами и глубинами.

