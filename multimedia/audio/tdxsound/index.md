---
Title: TDXSound. AudioStream, стерео эффекты
Author: 3d\[Power\]
Date: 01.01.2007
---


TDXSound. AudioStream, стерео эффекты
=====================================

::: {.date}
01.01.2007
:::

TDXSound. AudioStream, стерео эффекты.

Основные принципы:

С помощью TDXSound вы можете создавать звуковые эффекты в вашей программе.
Все что Вам понадобится это поставить на форму 2 компонента: DXSound и
DXWaveList. Последний является \"коллекцией wav файлов\". В который вы
будете заносить wav файлы. Установите DxWaveList1.DXSound := DXSound1. В
этот DXSound будет воспроизводиться звук.
Чтобы проиграть звук вам надо в DxWaveList1 добавить какой нибудь wav
файл. После чего вызвать dxwavelist1.items\[0\].play(false); Будет
проигран звук, который находится в списке нулевым. Можно и так:
dxwavelist1.Items.Find(\'somewave1\').Play(False);

Добавление дополнительных эффектов:
Добавить можно следущие эффекты: изменение frequensy, pan, volume.
Pan - ориентация звука (левый правый канал).
dxwavelist1.Items.Find(\'somewave1\').Pan := 0; - Центр.
dxwavelist1.Items.Find(\'somewave1\').Pan := -10000; - Максимально
слева.
dxwavelist1.Items.Find(\'somewave1\').Pan := 10000; - Максимально
справа.
После чего вызвать dxwavelist1.Items.Find(\'somewave1\').Play(False);.
Frequency - частота звука.
Назначается это значение так:
dxwavelist1.Items.Find(\'somewave1\').Frequency. Минимальное значение
4410, а максимальное 44100.
Volume - громкость звука.
Назначается это значение так:
dxwavelist1.Items.Find(\'somewave1\').volume. Минимальное значение
-10000, а максимальное 0.
Looped. У звука есть еще параметр .Looped : boolean который означает
будет ли звук проигрываться \"покругу\". Что бы остановить такое
проигрывание используйте .looped := false;
Загрузка wav файлов:
Загружать звуки в программу можно непосредственно через dxwavelist1
(просто вручную добавить файлы и все).
А можно через отдельные *.dxw файлы - это контейнеры wav\'ов. Создавать
которые можно специальными программами. Dxwavelist1.items.LoadFromFile
(\'sounds.dxw\'); Это полезно для того чтобы ехе файл занимал меньше
размера.

Загрузка wav файлов в \"realtime\"Ниже указанная процедура загружает
wav, и автоматически добавляет в Dxwavelist1:

    procedure LoadSound (Filename, SoundName : String);
    begin
    dxwavelist1.Items.Add;
    with dxwavelist1.Items[dxwavelist1.Items.Count-1] do
    begin;
    Wave.LoadFromFile(filename);
    Name := SoundName;
    restore;
    end;
    end;

NOTE: не забудьте поставить with form1 do. или declarations.
Вызывайте эту процедуру до dxsound1.initialize;

Если после, то выполните код:

    dxsound1.Finalize;
    dxsound1.Initialize;

Загрузка всех wav файлов из директории. Собственно использование
findfirst. не более того:

    var sr: TSearchRec;
    begin
    chdir('sounds'); //директория в которой звуки лежат
    if FindFirst('*.wav', faAnyFile, sr) = 0 then begin
    LoadSound(sr.name, sr.name); //имя звука будет идентично имени файла.
    while FindNext(sr)=0 do
    LoadSound(sr.name, sr.name); //заметьте что в имени звука учитывается регистр
    end;

Использование AudioStream:

    var
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

NOTE: Вам надо в uses занести MMSystem, Wave;
Я заметил что этот метод поджирает память (проверял по тестам).


И на последок классная процедура автоматического расчета звука по
каналам:Эта процедура автоматически расчитывает стерео для разрешения
экрана 640х480. Вызывается так: playsound(\'somesound1\',320); - центр.
playsound(\'somesound1\',0); - слева. etc.

    const
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

Автор: 3d\[Power\]

<https://www.mirgames.ru>
