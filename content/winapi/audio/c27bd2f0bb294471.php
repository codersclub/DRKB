<h1>Как сделать регулятор громкости?</h1>
<div class="date">01.01.2007</div>


<p>ВОТ нашел в Интернете:</p>
<p>Эта программа увеличивает громкость выбранного канала на 1000.</p>
<pre>
uses MMSystem;
 
procedure TForm1.Button1Click(Sender: TObject);
var
  vol: longint;
  LVol, RVol: integer;
begin
  AuxGetVolume(ListBox1.ItemIndex, @Vol);
  LVol := Vol shr 16;
  if LVol &lt; MaxWord - 1000
    then LVol := LVol + 1000
    else LVol := MaxWord;
  RVol := (Vol shl 16) shr 16;
  if RVol &lt; MaxWord - 1000
    then RVol := RVol + 1000
    else RVol := MaxWord;
  AuxSetVolume(ListBox1.ItemIndex, LVol shl 16 + RVol);
end;
 
procedure TForm1.FormCreate(Sender: TObject);
var
  i: integer;
  cap: TAuxCaps;
begin
  for i := 0 to auxGetNumDevs - 1 do begin
    auxGetDevCaps(i, Addr(cap), SizeOf(cap));
    ListBox1.Items.Add(cap.szPname)
  end;
end; 
</pre>
<p>Второй вариант:</p>
<pre>uses mmsystem;
function GetWaveVolume: DWord;
var
Woc : TWAVEOUTCAPS;
Volume : DWord;
begin
result:=0;
if WaveOutGetDevCaps(WAVE_MAPPER, @Woc, sizeof(Woc)) = MMSYSERR_NOERROR then
if Woc.dwSupport and WAVECAPS_VOLUME = WAVECAPS_VOLUME then
begin
WaveOutGetVolume(WAVE_MAPPER, @Volume);
Result := Volume;
end;
end;
procedure SetWaveVolume(const AVolume: DWord);
var Woc : TWAVEOUTCAPS;
begin
if WaveOutGetDevCaps(WAVE_MAPPER, @Woc, sizeof(Woc)) = MMSYSERR_NOERROR then
if Woc.dwSupport and WAVECAPS_VOLUME = WAVECAPS_VOLUME then WaveOutSetVolume(WAVE_MAPPER, AVolume);
end;
procedure TForm1.Button1Click(Sender: TObject);
begin
Beep;
end;
procedure TForm1.Button2Click(Sender: TObject);
var
LeftVolume: Word;
RightVolume: Word;
begin
LeftVolume := StrToInt(Edit1.Text);
RightVolume := StrToInt(Edit2.Text);
SetWaveVolume(MakeLong(LeftVolume, RightVolume));
end;
procedure TForm1.Button3Click(Sender: TObject);
begin
Caption := IntToStr(GetWaveVolume);
end;
</pre>

<div class="author">Автор: MMM</div>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
