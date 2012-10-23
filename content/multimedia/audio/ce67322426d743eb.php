<h1>TDXSound. AudioStream, стерео эффекты</h1>
<div class="date">01.01.2007</div>

<p>TDXSound. AudioStream, стерео эффекты. </p>
<p>Основные принципы:<br>
С помощью TDXSound вы можете создавать звуковые эффекты в вашей программе.<br>
Все что Вам понадобится это поставить на форму 2 компонента: DXSound и DXWaveList. Последний является "коллекцией wav файлов". В который вы будете заносить wav файлы. Установите DxWaveList1.DXSound := DXSound1. В этот DXSound будет воспроизводиться звук.<br>
Чтобы проиграть звук вам надо в DxWaveList1 добавить какой нибудь wav файл. После чего вызвать dxwavelist1.items[0].play(false); Будет проигран звук, который находится в списке нулевым. Можно и так: dxwavelist1.Items.Find('somewave1').Play(False);<br>
Добавление дополнительных эффектов:<br>
Добавить можно следущие эффекты: изменение frequensy, pan, volume.<br>
Pan - ориентация звука (левый правый канал). <br>
dxwavelist1.Items.Find('somewave1').Pan := 0; - Центр.<br>
dxwavelist1.Items.Find('somewave1').Pan := -10000; - Максимально слева.<br>
dxwavelist1.Items.Find('somewave1').Pan := 10000; - Максимально справа.<br>
После чего вызвать dxwavelist1.Items.Find('somewave1').Play(False);.<br>
Frequency - частота звука.<br>
Назначается это значение так: dxwavelist1.Items.Find('somewave1').Frequency. Минимальное значение 4410, а максимальное 44100.<br>
Volume - громкость звука.<br>
Назначается это значение так: dxwavelist1.Items.Find('somewave1').volume. Минимальное значение -10000, а максимальное 0.<br>
Looped. У звука есть еще параметр .Looped : boolean который означает будет ли звук проигрываться "покругу". Что бы остановить такое проигрывание используйте .looped := false;<br>
Загрузка wav файлов:<br>
Загружать звуки в программу можно непосредственно через dxwavelist1 (просто вручную добавить файлы и все).<br>
А можно через отдельные *.dxw файлы - это контейнеры wav'ов. Создавать которые можно специальными программами. Dxwavelist1.items.LoadFromFile ('sounds.dxw'); Это полезно для того чтобы ехе файл занимал меньше размера.<br>
<p>Загрузка wav файлов в "realtime"Ниже указанная процедура загружает wav, и автоматически добавляет в Dxwavelist1: </p>

<pre>procedure LoadSound (Filename, SoundName : String);
begin
dxwavelist1.Items.Add;
with dxwavelist1.Items[dxwavelist1.Items.Count-1] do
begin;
Wave.LoadFromFile(filename);
Name := SoundName;
restore;
end;
end;
</pre>
<p>NOTE: не забудьте поставить with form1 do. или declarations.<br>
Вызывайте эту процедуру до dxsound1.initialize;<br>
<p>Если после, то выполните код: </p>
<pre>dxsound1.Finalize;
dxsound1.Initialize;
</pre>
<p>Загрузка всех wav файлов из директории. Собственно использование findfirst. не более того:</p>
<pre>var sr: TSearchRec;
begin
chdir('sounds'); //директория в которой звуки лежат
if FindFirst('*.wav', faAnyFile, sr) = 0 then begin
LoadSound(sr.name, sr.name); //имя звука будет идентично имени файла.
while FindNext(sr)=0 do
LoadSound(sr.name, sr.name); //заметьте что в имени звука учитывается регистр
end;
</pre>
<p>Использование AudioStream: </p>
<pre>var
Audio: TAudioFileStream;
WaveFormat: TWaveFormatEx;
Audio := TAudioFileStream.Create(DXSound1.DSound);
Audio.AutoUpdate := True;
Audio.BufferLength := 1000;
Audio.FileName := 'somefile.wav';
Audio.Looped := FALSE;
MakePCMWaveFormatEx(WaveFormat, 44100, Audio.Format.wBitsPerSample, 2);
DXSound1.Primary.SetFormat(WaveFormat);
Audio.Play;
</pre>


<p>NOTE: Вам надо в uses занести MMSystem, Wave;<br>
Я заметил что этот метод поджирает память (проверял по тестам).<br>
&nbsp;<br>
<p>И на последок классная процедура автоматического расчета звука по каналам:Эта процедура автоматически расчитывает стерео для разрешения экрана 640х480. Вызывается так: playsound('somesound1',320); - центр. playsound('somesound1',0); - слева. etc. </p>
<pre>const
OPT_SOUND : boolean = true ; //наличие звук
OPT_STEREO : boolean = true ; //стерео
OPT_CHANNELAPPROACH : word = 10 ; //степень смешения каналов
OPT_REVERSESTEREO : boolean = false ; //реверсировать стерео
OPT_VOLUME : integer = 0 ; //громкость (-10000 | 0).
 
 
 
procedure PlaySound(soundname : shortstring; x : word);
var PanFactor, PanValue : Double;
begin
if OPT_SOUND = false then exit;
if OPT_STEREO = true then begin
PanFactor := 31.25; // 10000 is the panning range
PanValue := ((X * PanFactor)-10000) / OPT_CHANNELAPPROACH;
if OPT_REVERSESTEREO then PanValue := -panvalue;
end else panvalue := 0;
try
WaveLst.Items.Find(soundname).Pan := round(Panvalue);
WaveLst.Items.Find(soundname).Play(False);
WaveLst.Items.Find(soundame).Volume := OPT_VOLUME;
except
ShowMessage('Error playing sound "'+soundname+'"');
end;
end;
</pre>


<div class="author">Автор: 3d[Power]</div>
<p><a href="https://www.mirgames.ru" target="_blank">https://www.mirgames.ru</a></p>

