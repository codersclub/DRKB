---
Title: Изменить громкость
Date: 01.01.2007
Tag: sound
---


Изменить громкость
==================

Вариант 1:

ID: 03610

Эта программа увеличивает громкость выбранного канала на 1000:

```delphi
uses MMSystem;

procedure TForm1.Button1Click(Sender: TObject);
var
  vol: LongInt;
  LVol, RVol: Integer;
begin
  AuxGetVolume(ListBox1.ItemIndex, @Vol);
  LVol := Vol shr 16;
  if LVol < MaxWord - 1000 then
    LVol := LVol + 1000
  else
    LVol := MaxWord;
  RVol := (Vol shl 16) shr 16;
  if RVol < MaxWord - 1000 then
    RVol := RVol + 1000
  else
    RVol := MaxWord;
  AuxSetVolume(ListBox1.ItemIndex, LVol shl 16 + RVol);
end;

procedure TForm1.FormCreate(Sender: TObject);
var
  i: Integer;
  cap: TAuxCaps;
begin
  for i := 0 to auxGetNumDevs - 1 do
  begin
    auxGetDevCaps(i, Addr(cap), SizeOf(cap));
    ListBox1.Items.Add(cap.szPname)
  end;
end;
```

------------------------------------------------------------------------

Вариант 2:

ID: 03611

```delphi
procedure SetVolume(X: Word);
var
  iErr: Integer;
  i: Integer;
  a: TAuxCaps;
begin
  for i := 0 to auxGetNumDevs do
  begin
    auxGetDevCaps(i, Addr(a), SizeOf(a));
    if a.wTechnology = AUXCAPS_CDAUDIO then
      break;
  end;

  // Устанавливаем одинаковую громкость для левого и правого каналов.
  // VOLUME := LEFT*$10000 + RIGHT*1

  iErr := auxSetVolume(i, (X * $10001));
  if (iErr <> 0) then
    ShowMessage('No audio devices are available!');
end;

function GetVolume: Word;
var
  iErr: Integer;
  i: Integer;
  a: TAuxCaps;
  vol: Word;
begin
  for i := 0 to auxGetNumDevs do
  begin
    auxGetDevCaps(i, Addr(a), SizeOf(a));
    if a.wTechnology = AUXCAPS_CDAUDIO then
      break;
  end;
  iErr := auxGetVolume(i, Addr(vol));
  GetVolume := vol;
  if (iErr <> 0) then
    ShowMessage('No audio devices are available!');
end;
```


------------------------------------------------------------------------

Вариант 3:

ID: 03612

```delphi
unit Volumes;

interface

uses
  Windows, Messages, Classes, ExtCtrls, ComCtrls, MMSystem;

const
  CDVolume       = 0;
  WaveVolume     = 1;
  MidiVolume     = 2;

type
  TVolumeControl = class(TComponent)
  private
    FDevices: array[0..2] of Integer;
    FTrackBars: array[0..2] of TTrackBar;
    FTimer: TTimer;
    function GetInterval: Integer;
    procedure SetInterval(AInterval: Integer);
    function GetVolume(AIndex: Integer): Byte;
    procedure SetVolume(AIndex: Integer; aVolume: Byte);
    procedure InitVolume;
    procedure SetTrackBar(AIndex: Integer; ATrackBar: TTrackBar);
    { Private declarations }
    procedure Update(Sender: TObject);
    procedure Changed(Sender: TObject);
  protected
    { Protected declarations }
    procedure Notification(AComponent: TComponent; AOperation: TOperation); override;
  public
    { Public declarations }
    constructor Create(AOwner: TComponent); override;
    destructor Destroy; override;
  published
    { Published declarations }
    property Interval: Integer read GetInterval write SetInterval default 500;
    property CDVolume: Byte index 0 read GetVolume write SetVolume stored False;
    property CDTrackBar: TTrackBar index 0 read FTrackBars[0] write SetTrackBar;
    property WaveVolume: Byte index 1 read GetVolume write SetVolume stored False;
    property WaveTrackBar: TTrackBar index 1 read FTrackBars[1] write SetTrackBar;
    property MidiVolume: Byte index 2 read GetVolume write SetVolume stored False;
    property MidiTrackBar: TTrackBar index 2 read FTrackBars[2] write SetTrackBar;
  end;

procedure Register;

implementation

procedure Register;
begin
  RegisterComponents('Any', [TVolumeControl]);
end;

type
  TVolumeRec = record
  case Integer of
    0: (LongVolume: Longint);
    1: (LeftVolume, RightVolume: Word);
  end;

function TVolumeControl.GetInterval: Integer;
begin
  Result := FTimer.Interval;
end;

procedure TVolumeControl.SetInterval(AInterval: Integer);
begin
  FTimer.Interval := AInterval;
end;

function TVolumeControl.GetVolume(AIndex: Integer): Byte;
var
  Vol: TVolumeRec;
begin
  Vol.LongVolume := 0;
  if FDevices[AIndex] <> -1 then
  begin
    case AIndex of
      0: auxGetVolume(FDevices[AIndex], @Vol.LongVolume);
      1: waveOutGetVolume(FDevices[AIndex], @Vol.LongVolume);
      2: midiOutGetVolume(FDevices[AIndex], @Vol.LongVolume);
    end;
  end;
  Result := (Vol.LeftVolume + Vol.RightVolume) shr 9;
end;

procedure TVolumeControl.SetVolume(aIndex: Integer; aVolume: Byte);
var
  Vol: TVolumeRec;
begin
  if FDevices[AIndex] < >  -1 then
  begin
    Vol.LeftVolume := aVolume shl 8;
    Vol.RightVolume := Vol.LeftVolume;
    case AIndex of
      0: auxSetVolume(FDevices[AIndex], Vol.LongVolume);
      1: waveOutSetVolume(FDevices[AIndex], Vol.LongVolume);
      2: midiOutSetVolume(FDevices[AIndex], Vol.LongVolume);
    end;
  end;
end;

procedure TVolumeControl.SetTrackBar(AIndex: Integer; ATrackBar: TTrackBar);
begin
  if ATrackBar < >  FTrackBars[AIndex] then
  begin
    FTrackBars[AIndex] := ATrackBar;
    Update(Self);
  end;
end;

procedure TVolumeControl.Notification(AComponent: TComponent; AOperation: TOperation);
var
  I: Integer;
begin
  inherited Notification(AComponent, AOperation);
  if (AOperation = opRemove) then
  begin
    for I := 0 to 2 do
    begin
      if (AComponent = FTrackBars[I]) then
        FTrackBars[I] := Nil;
    end;
  end;
end;

procedure TVolumeControl.Update(Sender: TObject);
var
  I: Integer;
begin
  for I := 0 to 2 do
  begin
    if Assigned(FTrackBars[I]) then
    with FTrackBars[I] do
    begin
      Min := 0;
      Max := 255;
      if Orientation = trVertical then
        Position := 255 - GetVolume(I)
      else
        Position := GetVolume(I);
      OnChange := Self.Changed;
    end;
  end;
end;

constructor TVolumeControl.Create(AOwner: TComponent);
begin
  inherited Create(AOwner);
  FTimer := TTimer.Create(Self);
  FTimer.OnTimer := Update;
  FTimer.Interval := 500;
  InitVolume;
end;

destructor TVolumeControl.Destroy;
var
  I: Integer;
begin
  FTimer.Free;
  for I := 0 to 2 do
  begin
    if Assigned(FTrackBars[I]) then
      FTrackBars[I].OnChange := nil;
  end;
  inherited Destroy;
end;

procedure TVolumeControl.Changed(Sender: TObject);
var
  I: Integer;
begin
  for I := 0 to 2 do
  begin
    if Sender = FTrackBars[I] then
    with FTrackBars[I] do
    begin
      if Orientation = trVertical then
        SetVolume(I, 255 - Position)
      else
        SetVolume(I, Position);
    end;
  end;
end;

procedure TVolumeControl.InitVolume;
var
  AuxCaps: TAuxCaps;
  WaveOutCaps: TWaveOutCaps;
  MidiOutCaps: TMidiOutCaps;
  I, J: Integer;
begin
  FDevices[0] := -1;
  for I := 0 to auxGetNumDevs - 1 do
  begin
    auxGetDevCaps(I, @AuxCaps, SizeOf(AuxCaps));
    if (AuxCaps.dwSupport and AUXCAPS_VOLUME) < >  0 then
    begin
      FTimer.Enabled := True;
      FDevices[0] := I;
      break;
    end;
  end;
  FDevices[1] := -1;
  for I := 0 to waveOutGetNumDevs - 1 do
  begin
    waveOutGetDevCaps(I, @WaveOutCaps, SizeOf(WaveOutCaps));
    if (WaveOutCaps.dwSupport and WAVECAPS_VOLUME) <> 0 then
    begin
      FTimer.Enabled := True;
      FDevices[1] := I;
      break;
    end;
  end;
  FDevices[2] := -1;
  for I := 0 to midiOutGetNumDevs - 1 do
  begin
    MidiOutGetDevCaps(I, @MidiOutCaps, SizeOf(MidiOutCaps));
    if (MidiOutCaps.dwSupport and MIDICAPS_VOLUME) <> 0 then
    begin
      FTimer.Enabled := True;
      FDevices[2] := I;
      break;
    end;
  end;
end;

end.
```


------------------------------------------------------------------------

Вариант 4:

ID: 03613

Source: <https://delphiworld.narod.ru>

Выставь на форму 2 тракбара и двигай их. Если у тебя звучит музыка, ты
должен услышать изменения громкости правого и левого каналов.

```delphi
procedure TForm1.TrackBar1Change(Sender: TObject);
var
  s: DWord;
  a, b: Word;
  h: hWnd;
begin
  a := trackbar1.Position;
  b := trackbar2.Position;
  s := (a shl 16) or b;
  waveOutSetVolume(h, s);
end;
```

свойство Max в каждом TrackBar'e должно равняться 65535 (то есть MaxWord)

