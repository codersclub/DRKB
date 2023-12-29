---
Title: Пример работы чтения и сохранении wav-файлов
Date: 01.01.2007
---


Пример работы чтения и сохранении wav-файлов
============================================

::: {.date}
01.01.2007
:::

Сразу оговорюсь, что рассматривать я буду только PCM формат - самый
простой. Wav-файл состоит из заголовка и собственно информации. В
заголовке находится информация о типе файла, частоте, каналах и т.д.
Сама информация состоит из массива чисел по 8 или 16 бит. Если в файле 2
канала, то значения левого и правого каналов записываются поочередно.

Для работы с заголовком удобнее всего использовать запись, расположение
полей в которой будет повторять расположение информации в файле.
Например, первая запись в wav-файле - это символы "RIFF".
Соответственно, первое поле в записи должно быть массивом из четырех
элементов типа char. Вторая запись - длина файла без 8 байт (без первых
двух записей). Длина записана в четырех байтах целым числом. Поэтому
взят тип longint. Так составляется эта запись. Когда нужно целое число
длиной 2 байта - берется smallint.

О создании wav-файлов и хранении самой информации я расскажу в следующем
выпуске.

Эта программа выводит в Memo длину wav-файла, количество каналов,
частоту и количество бит на запись.

Скачать необходимые для компиляции файлы проекта можно на
[program.dax.ru](https://program.dax.ru).

    type
      TWaveHeader = record
        idRiff: array[0..3] of char;
        RiffLen: longint;
        idWave: array[0..3] of char;
        idFmt: array[0..3] of char;
        InfoLen: longint;
        WaveType: smallint;
        Ch: smallint;
        Freq: longint;
        BytesPerSec: longint;
        align: smallint;
        Bits: smallint;
      end;
     
      TDataHeader = record
        idData: array[0..3] of char;
        DataLen: longint;
      end;
     
    // Процедура ?тения заголовка wav-файлов
     
    procedure ReadWaveHeader(Stream: TStream;
      var SampleCount, SamplesPerSec: integer;
      var BitsPerSample, Channeles: smallint);
    var
      WaveHeader: TWaveHeader;
      DataHeader: TDataHeader;
    begin
      Stream.Read(WaveHeader, sizeof(TWaveHeader));
      with WaveHeader do
        begin
          if idRiff <> 'RIFF' then raise EReadError.Create('Wrong idRIFF');
          if idWave <> 'WAVE' then raise EReadError.Create('Wrong idWAVE');
          if idFmt <> 'fmt ' then raise EReadError.Create('Wrong idFmt');
          if WaveType <> 1 then raise EReadError.Create('Unknown format');
          Channeles := Ch;
          SamplesPerSec := Freq;
          BitsPerSample := Bits;
          Stream.Seek(InfoLen - 16, soFromCurrent);
        end;
      Stream.Read(DataHeader, sizeof(TDataHeader));
      if DataHeader.idData = 'fact' then
        begin
          Stream.Seek(4, soFromCurrent);
          Stream.Read(DataHeader, sizeof(TDataHeader));
        end;
      with DataHeader do
        begin
          if idData <> 'data' then raise EReadError.Create('Wrong idData');
          SampleCount := DataLen div (Channeles * BitsPerSample div 8)
        end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      OpenDialog1.Filter := 'Wave files|*.wav';
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      F: TFileStream;
      SampleCount, SamplesPerSec: integer;
      BitsPerSample, Channeles: smallint;
    begin
    // Вызов OpenDialog1:
      if not OpenDialog1.Execute then Exit;
      try
    // Открытие файла:
        F := TFileStream.Create(OpenDialog1.FileName, fmOpenRead);
    // Чтение заголовка:
        ReadWaveHeader(F, SampleCount, SamplesPerSec,
          BitsPerSample, Channeles);
        F.Free;
        Memo1.Clear;
    // Заполнение Memo информацией о файле:
        Memo1.Lines.Add('SampleCount: ' + IntToStr(SampleCount));
        Memo1.Lines.Add(Format('Length: %5.3f sec', [SampleCount / SamplesPerSec]));
        Memo1.Lines.Add('Channeles: ' + IntToStr(Channeles));
        Memo1.Lines.Add('Freq: ' + IntToStr(SamplesPerSec));
        Memo1.Lines.Add('Bits: ' + IntToStr(BitsPerSample));
      except
        raise Exception.Create('Problems with file reading');
      end;
    end;

Даниил Карапетян.

На сайте <https://delphi4all.narod.ru> Вы найдете еще более 100 советов
по Delphi.

Email: <delphi4all@narod.ru>

Взято с Vingrad.ru <https://forum.vingrad.ru>
