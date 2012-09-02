<h1>Как проиграть wave-ресурс?</h1>
<div class="date">01.01.2007</div>


<p>Сначала делаешь файл SOUND.RC, в нем строка вида: MY_WAV RCDATA TEST.WAV</p>
<p> Компилишь чем-нибyдь в *.RES</p>

<p> Далее в тексте:</p>
<pre>
{$R полное_имя_файла_с_ресурсом}
 
var WaveHandle: THandle;
  WavePointer: pointer;
  ...
    WaveHandle := FindResource(hInstance, 'MY_WAV', RT_RCDATA);
  if WaveHandle &lt;&gt; 0 then
    begin
      WaveHandle := LoadResource(hInstance, WaveHandle);
      if WaveHandle &lt;&gt; 0 then
        begin;
          WavePointer := LockResource(WaveHandle);
 
          PlayResourceWave := sndPlaySound(WavePointer, snd_Memory or
            SND_ASYNC);
          UnlockResource(WaveHandle);
          FreeResource(WaveHandle);
        end;
    end;
</pre>


<p>Serg Vostrikov</p>
<p>(2:5053/15.3)</p>

<p>Взято с сайта <a href="https://blackman.wp-club.net/" target="_blank">https://blackman.wp-club.net/</a></p>
