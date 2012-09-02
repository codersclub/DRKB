<h1>Как получить / изменить громкость?</h1>
<div class="date">01.01.2007</div>


<pre>
procedure GetVolume(var volL, volR: Word);
var
  hWO: HWAVEOUT;
  waveF: TWAVEFORMATEX;
  vol: DWORD;
begin
  volL := 0;
  volR := 0;
  // init TWAVEFORMATEX
  FillChar(waveF, SizeOf(waveF), 0);
  // open WaveMapper = std output of playsound
  waveOutOpen(@hWO, WAVE_MAPPER, @waveF, 0, 0, 0);
  // get volume
  waveOutGetVolume(hWO, @vol);
  volL := vol and $FFFF;
  volR := vol shr 16;
  waveOutClose(hWO);
end;
 
procedure SetVolume(const volL, volR: Word);
var
  hWO: HWAVEOUT;
  waveF: TWAVEFORMATEX;
  vol: DWORD;
begin
  // init TWAVEFORMATEX
  FillChar(waveF, SizeOf(waveF), 0);
  // open WaveMapper = std output of playsound
  waveOutOpen(@hWO, WAVE_MAPPER, @waveF, 0, 0, 0);
  vol := volL + volR shl 16;
  // set volume
  waveOutSetVolume(hWO, vol);
  waveOutClose(hWO);
end;
</pre>

<p>Взято с Delphi Knowledge Base: <a href="https://www.baltsoft.com/" target="_blank">https://www.baltsoft.com/</a></p>
