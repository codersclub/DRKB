---
Title: Как проиграть wave-ресурс?
Date: 01.01.2007
Author: Serg Vostrikov (2:5053/15.3)
Source: <https://blackman.wp-club.net/>
---


Как проиграть wave-ресурс?
==========================

Сначала делаешь файл SOUND.RC, в нем строка вида: MY\_WAV RCDATA
TEST.WAV

Компилишь чем-нибyдь в *.RES

Далее в тексте:

    {$R полное_имя_файла_с_ресурсом}
     
    var WaveHandle: THandle;
      WavePointer: pointer;
      ...
        WaveHandle := FindResource(hInstance, 'MY_WAV', RT_RCDATA);
      if WaveHandle <> 0 then
        begin
          WaveHandle := LoadResource(hInstance, WaveHandle);
          if WaveHandle <> 0 then
            begin;
              WavePointer := LockResource(WaveHandle);
     
              PlayResourceWave := sndPlaySound(WavePointer, snd_Memory or
                SND_ASYNC);
              UnlockResource(WaveHandle);
              FreeResource(WaveHandle);
            end;
        end;

