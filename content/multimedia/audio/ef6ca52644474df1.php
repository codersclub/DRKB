<h1>Как вывести звук через звуковую карту?</h1>
<div class="date">01.01.2007</div>


<pre>
uses 
  MMSystem; 
 
type 
  TVolumeLevel = 0..127; 
 
procedure MakeSound(Frequency{Hz}, Duration{mSec}: Integer; Volume: TVolumeLevel); 
  {writes tone to memory and plays it} 
var 
  WaveFormatEx: TWaveFormatEx; 
  MS: TMemoryStream; 
  i, TempInt, DataCount, RiffCount: integer; 
  SoundValue: byte; 
  w: double; // omega ( 2 * pi * frequency) 
const 
  Mono: Word = $0001; 
  SampleRate: Integer = 11025; // 8000, 11025, 22050, or 44100 
  RiffId: string = 'RIFF'; 
  WaveId: string = 'WAVE'; 
  FmtId: string = 'fmt '; 
  DataId: string = 'data'; 
begin 
  if Frequency &gt; (0.6 * SampleRate) then 
  begin 
    ShowMessage(Format('Sample rate of %d is too Low to play a tone of %dHz', 
      [SampleRate, Frequency])); 
    Exit; 
  end; 
  with WaveFormatEx do 
  begin 
    wFormatTag := WAVE_FORMAT_PCM; 
    nChannels := Mono; 
    nSamplesPerSec := SampleRate; 
    wBitsPerSample := $0008; 
    nBlockAlign := (nChannels * wBitsPerSample) div 8; 
    nAvgBytesPerSec := nSamplesPerSec * nBlockAlign; 
    cbSize := 0; 
  end; 
  MS := TMemoryStream.Create; 
  with MS do 
  begin 
    {Calculate length of sound data and of file data} 
    DataCount := (Duration * SampleRate) div 1000; // sound data 
    RiffCount := Length(WaveId) + Length(FmtId) + SizeOf(DWORD) + 
      SizeOf(TWaveFormatEx) + Length(DataId) + SizeOf(DWORD) + DataCount; // file data 
    {write out the wave header} 
    Write(RiffId[1], 4); // 'RIFF' 
    Write(RiffCount, SizeOf(DWORD)); // file data size 
    Write(WaveId[1], Length(WaveId)); // 'WAVE' 
    Write(FmtId[1], Length(FmtId)); // 'fmt ' 
    TempInt := SizeOf(TWaveFormatEx); 
    Write(TempInt, SizeOf(DWORD)); // TWaveFormat data size 
    Write(WaveFormatEx, SizeOf(TWaveFormatEx)); // WaveFormatEx record 
    Write(DataId[1], Length(DataId)); // 'data' 
    Write(DataCount, SizeOf(DWORD)); // sound data size 
    {calculate and write out the tone signal} // now the data values 
    w := 2 * Pi * Frequency; // omega 
    for i := 0 to DataCount - 1 do 
    begin 
      SoundValue := 127 + trunc(Volume * sin(i * w / SampleRate)); // wt = w * i / SampleRate 
      Write(SoundValue, SizeOf(Byte)); 
    end; 
    {now play the sound} 
    sndPlaySound(MS.Memory, SND_MEMORY or SND_SYNC); 
    MS.Free; 
  end; 
end; 
 
// How to call the function: 
 
procedure TForm1.Button1Click(Sender: TObject); 
begin 
  MakeSound(1200, 1000, 60); 
end;
</pre>

<p>Взято с сайта <a href="https://www.swissdelphicenter.ch/en/tipsindex.php" target="_blank">https://www.swissdelphicenter.ch/en/tipsindex.php</a></p>
