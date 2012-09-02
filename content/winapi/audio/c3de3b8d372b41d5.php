<h1>Как определить уровень звука в данный момент?</h1>
<div class="date">01.01.2007</div>


<p>Единственное, что удалось найти это компонент на Дельфи (с исходным кодом) на <a href="https://www.torry.net/mixer.htm " target="_blank">https://www.torry.net/mixer.htm </a>компонент называется Vumeter v.1.0. Я его не разбирал, но похоже что он опрашивает Audio Mixer Driver (или что-то подобное). </p>
<p class="author">Автор: Vit</p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
<hr /><p>Я построил диограмму так:</p>
<p>Назначил F:= TFileStream.Create(OpenDialog1.FileName, fmOpenRead );</p>
<p>Затем считал заголовок Wav- SampleCount, SamplesPerSec, BitsPerSample, Channeles.</p>
<p>Затем считал данные- GetMem(buf, SampleCount * Channeles * BitsPerSample);</p>
<p>Описал массив Volume- SetLength(Volume, SampleCount);</p>
<p>Затем - F.Read(buf^, SampleCount*2); F.Free;</p>
<p>Затем заполнил массив - </p>
<pre>
buf16 := buf;
for h := 0 to SampleCount - 1 do
  begin
    Volume[h] := abs(buf16^);
    inc(buf16);
  end;
FreeMem(buf);
</pre>

<p>Затем строил график(в экранных координатах) - по горизонтальной оси откладывал значения SampleCount, по вертикальной значения Volume[h].</p>
<p>График получается точно такой же как в SoundForge. </p>
<p>Единственно, я писал программу для конкретного случая - у меня файлы по 10 минут, моно, 11025 Гц., 16 бит. Так что программа у меня не универсальная. Но работает нормально. По времени: обработка файла и построение графика около 4 -5 секунд. </p>
<p class="author">Автор ответа: TPavel </p>
<p>Взято с Vingrad.ru <a href="https://forum.vingrad.ru" target="_blank">https://forum.vingrad.ru</a></p>
