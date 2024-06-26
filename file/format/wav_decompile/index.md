---
Title: Декомпилляция звукового файла формата Wave и получение звуковых данных
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Декомпилляция звукового файла формата Wave и получение звуковых данных
======================================================================

> Интересно, есть ли технология преобразования Wave-формата в обычный
> набор звуковых данных? К примеру, мне необходимо удалить заголовок и
> механизм (метод) сжатия, которые могут компилироваться и сохраняться
> вместе с Wave-файлами.

У меня есть программа под D1/D2, которая читает WAV-файлы и вытаскивает
исходные данные, но она не может их восстановить, используя зашитый
алгоритм сжатия.

    unit LinearSystem;
     
    interface
     
    {============== Тип, описывающий формат WAV ==================}
    type
      WAVHeader = record
     
        nChannels: Word;
        nBitsPerSample: LongInt;
        nSamplesPerSec: LongInt;
        nAvgBytesPerSec: LongInt;
        RIFFSize: LongInt;
        fmtSize: LongInt;
        formatTag: Word;
        nBlockAlign: LongInt;
        DataSize: LongInt;
      end;
     
      {============== Поток данных сэмпла ========================}
    const
      MaxN = 300; { максимальное значение величины сэмпла }
    type
      SampleIndex = 0..MaxN + 3;
    type
      DataStream = array[SampleIndex] of Real;
     
    var
      N: SampleIndex;
     
      {============== Переменные сопровождения ======================}
    type
      Observation = record
     
        Name: string[40]; {Имя данного сопровождения}
        yyy: DataStream; {Массив указателей на данные}
        WAV: WAVHeader; {Спецификация WAV для сопровождения}
        Last: SampleIndex; {Последний доступный индекс yyy}
        MinO, MaxO: Real; {Диапазон значений yyy}
      end;
     
    var
      K0R, K1R, K2R, K3R: Observation;
     
      K0B, K1B, K2B, K3B: Observation;
     
      {================== Переменные имени файла ===================}
    var
      StandardDatabase: string[80];
     
      BaseFileName: string[80];
      StandardOutput: string[80];
      StandardInput: string[80];
     
      {=============== Объявления процедур ==================}
    procedure ReadWAVFile(var Ki, Kj: Observation);
    procedure WriteWAVFile(var Ki, Kj: Observation);
    procedure ScaleData(var Kk: Observation);
    procedure InitAllSignals;
    procedure InitLinearSystem;
     
    implementation
    {$R *.DFM}
    uses VarGraph, SysUtils;
     
    {================== Стандартный формат WAV-файла ===================}
    const
      MaxDataSize: LongInt = (MaxN + 1) * 2 * 2;
    const
      MaxRIFFSize: LongInt = (MaxN + 1) * 2 * 2 + 36;
    const
      StandardWAV: WAVHeader = (
     
        nChannels: Word(2);
        nBitsPerSample: LongInt(16);
        nSamplesPerSec: LongInt(8000);
        nAvgBytesPerSec: LongInt(32000);
        RIFFSize: LongInt((MaxN + 1) * 2 * 2 + 36);
        fmtSize: LongInt(16);
        formatTag: Word(1);
        nBlockAlign: LongInt(4);
        DataSize: LongInt((MaxN + 1) * 2 * 2)
        );
     
      {================== Сканирование переменных сопровождения ===================}
     
    procedure ScaleData(var Kk: Observation);
    var
      I: SampleIndex;
    begin
     
      {Инициализация переменных сканирования}
      Kk.MaxO := Kk.yyy[0];
      Kk.MinO := Kk.yyy[0];
     
      {Сканирование для получения максимального и минимального значения}
      for I := 1 to Kk.Last do
      begin
        if Kk.MaxO < Kk.yyy[I] then
          Kk.MaxO := Kk.yyy[I];
        if Kk.MinO > Kk.yyy[I] then
          Kk.MinO := Kk.yyy[I];
      end;
    end; { ScaleData }
     
    procedure ScaleAllData;
    begin
     
      ScaleData(K0R);
      ScaleData(K0B);
      ScaleData(K1R);
      ScaleData(K1B);
      ScaleData(K2R);
      ScaleData(K2B);
      ScaleData(K3R);
      ScaleData(K3B);
    end; {ScaleAllData}
     
    {================== Считывание/запись WAV-данных ===================}
     
    var
      InFile, OutFile: file of Byte;
     
    type
      Tag = (F0, T1, M1);
    type
      FudgeNum = record
     
        case X: Tag of
          F0: (chrs: array[0..3] of Byte);
          T1: (lint: LongInt);
          M1: (up, dn: Integer);
      end;
    var
      ChunkSize: FudgeNum;
     
    procedure WriteChunkName(Name: string);
    var
      i: Integer;
     
      MM: Byte;
    begin
     
      for i := 1 to 4 do
      begin
        MM := ord(Name[i]);
        write(OutFile, MM);
      end;
    end; {WriteChunkName}
     
    procedure WriteChunkSize(LL: Longint);
    var
      I: integer;
    begin
     
      ChunkSize.x := T1;
      ChunkSize.lint := LL;
      ChunkSize.x := F0;
      for I := 0 to 3 do
        Write(OutFile, ChunkSize.chrs[I]);
    end;
     
    procedure WriteChunkWord(WW: Word);
    var
      I: integer;
    begin
     
      ChunkSize.x := T1;
      ChunkSize.up := WW;
      ChunkSize.x := M1;
      for I := 0 to 1 do
        Write(OutFile, ChunkSize.chrs[I]);
    end; {WriteChunkWord}
     
    procedure WriteOneDataBlock(var Ki, Kj: Observation);
    var
      I: Integer;
    begin
     
      ChunkSize.x := M1;
      with Ki.WAV do
      begin
        case nChannels of
          1: if nBitsPerSample = 16 then
            begin {1..2 Помещаем в буфер одноканальный 16-битный сэмпл}
              ChunkSize.up := trunc(Ki.yyy[N] + 0.5);
              if N < MaxN then
                ChunkSize.dn := trunc(Ki.yyy[N + 1] + 0.5);
              N := N + 2;
            end
            else
            begin {1..4 Помещаем в буфер одноканальный 8-битный сэмпл}
              for I := 0 to 3 do
                ChunkSize.chrs[I]
                  := trunc(Ki.yyy[N + I] + 0.5);
              N := N + 4;
            end;
          2: if nBitsPerSample = 16 then
            begin {2 Двухканальный 16-битный сэмпл}
              ChunkSize.dn := trunc(Ki.yyy[N] + 0.5);
              ChunkSize.up := trunc(Kj.yyy[N] + 0.5);
              N := N + 1;
            end
            else
            begin {4 Двухканальный 8-битный сэмпл}
              ChunkSize.chrs[1] := trunc(Ki.yyy[N] + 0.5);
              ChunkSize.chrs[3] := trunc(Ki.yyy[N + 1] + 0.5);
              ChunkSize.chrs[0] := trunc(Kj.yyy[N] + 0.5);
              ChunkSize.chrs[2] := trunc(Kj.yyy[N + 1] + 0.5);
              N := N + 2;
            end;
        end; {with WAV do begin..}
      end; {четырехбайтовая переменная "ChunkSize" теперь заполнена}
     
      ChunkSize.x := T1;
      WriteChunkSize(ChunkSize.lint); {помещаем 4 байта данных}
    end; {WriteOneDataBlock}
     
    procedure WriteWAVFile(var Ki, Kj: Observation);
    var
      MM: Byte;
     
      I: Integer;
      OK: Boolean;
    begin
     
      {Приготовления для записи файла данных}
      AssignFile(OutFile, StandardOutput); { Файл, выбранный в диалоговом окне }
      ReWrite(OutFile);
      with Ki.WAV do
      begin
        DataSize := nChannels * (nBitsPerSample div 8) * (Ki.Last + 1);
        RIFFSize := DataSize + 36;
        fmtSize := 16;
      end;
     
      {Записываем ChunkName "RIFF"}
      WriteChunkName('RIFF');
     
      {Записываем ChunkSize}
      WriteChunkSize(Ki.WAV.RIFFSize);
     
      {Записываем ChunkName "WAVE"}
      WriteChunkName('WAVE');
     
      {Записываем tag "fmt_"}
      WriteChunkName('fmt ');
     
      {Записываем ChunkSize}
      Ki.WAV.fmtSize := 16; {должно быть 16-18}
      WriteChunkSize(Ki.WAV.fmtSize);
     
      {Записываем  formatTag, nChannels}
      WriteChunkWord(Ki.WAV.formatTag);
      WriteChunkWord(Ki.WAV.nChannels);
     
      {Записываем  nSamplesPerSec}
      WriteChunkSize(Ki.WAV.nSamplesPerSec);
     
      {Записываем  nAvgBytesPerSec}
      WriteChunkSize(Ki.WAV.nAvgBytesPerSec);
     
      {Записываем  nBlockAlign, nBitsPerSample}
      WriteChunkWord(Ki.WAV.nBlockAlign);
      WriteChunkWord(Ki.WAV.nBitsPerSample);
     
      {Записываем метку блока данных "data"}
      WriteChunkName('data');
     
      {Записываем DataSize}
      WriteChunkSize(Ki.WAV.DataSize);
     
      N := 0; {первая запись-позиция}
      while N <= Ki.Last do
        WriteOneDataBlock(Ki, Kj); {помещаем 4 байта и увеличиваем счетчик N}
     
      {Освобождаем буфер файла}
      CloseFile(OutFile);
    end; {WriteWAVFile}
     
    procedure InitSpecs;
    begin
    end; { InitSpecs }
     
    procedure InitSignals(var Kk: Observation);
    var
      J: Integer;
    begin
     
      for J := 0 to MaxN do
        Kk.yyy[J] := 0.0;
      Kk.MinO := 0.0;
      Kk.MaxO := 0.0;
      Kk.Last := MaxN;
    end; {InitSignals}
     
    procedure InitAllSignals;
    begin
      InitSignals(K0R);
      InitSignals(K0B);
      InitSignals(K1R);
      InitSignals(K1B);
      InitSignals(K2R);
      InitSignals(K2B);
      InitSignals(K3R);
      InitSignals(K3B);
    end; {InitAllSignals}
     
    var
      ChunkName: string[4];
     
    procedure ReadChunkName;
    var
      I: integer;
     
      MM: Byte;
    begin
     
      ChunkName[0] := chr(4);
      for I := 1 to 4 do
      begin
        Read(InFile, MM);
        ChunkName[I] := chr(MM);
      end;
    end; {ReadChunkName}
     
    procedure ReadChunkSize;
    var
      I: integer;
     
      MM: Byte;
    begin
     
      ChunkSize.x := F0;
      ChunkSize.lint := 0;
      for I := 0 to 3 do
      begin
        Read(InFile, MM);
        ChunkSize.chrs[I] := MM;
      end;
      ChunkSize.x := T1;
    end; {ReadChunkSize}
     
    procedure ReadOneDataBlock(var Ki, Kj: Observation);
    var
      I: Integer;
    begin
     
      if N <= MaxN then
      begin
        ReadChunkSize; {получаем 4 байта данных}
        ChunkSize.x := M1;
        with Ki.WAV do
          case nChannels of
            1: if nBitsPerSample = 16 then
              begin {1..2 Помещаем в буфер одноканальный 16-битный сэмпл}
                Ki.yyy[N] := 1.0 * ChunkSize.up;
                if N < MaxN then
                  Ki.yyy[N + 1] := 1.0 * ChunkSize.dn;
                N := N + 2;
              end
              else
              begin {1..4 Помещаем в буфер одноканальный 8-битный сэмпл}
                for I := 0 to 3 do
                  Ki.yyy[N + I] := 1.0 * ChunkSize.chrs[I];
                N := N + 4;
              end;
            2: if nBitsPerSample = 16 then
              begin {2 Двухканальный 16-битный сэмпл}
                Ki.yyy[N] := 1.0 * ChunkSize.dn;
                Kj.yyy[N] := 1.0 * ChunkSize.up;
                N := N + 1;
              end
              else
              begin {4 Двухканальный 8-битный сэмпл}
                Ki.yyy[N] := 1.0 * ChunkSize.chrs[1];
                Ki.yyy[N + 1] := 1.0 * ChunkSize.chrs[3];
                Kj.yyy[N] := 1.0 * ChunkSize.chrs[0];
                Kj.yyy[N + 1] := 1.0 * ChunkSize.chrs[2];
                N := N + 2;
              end;
          end;
        if N <= MaxN then
        begin {LastN    := N;}
          Ki.Last := N;
          if Ki.WAV.nChannels = 2 then
            Kj.Last := N;
        end
        else
        begin {LastN    := MaxN;}
          Ki.Last := MaxN;
          if Ki.WAV.nChannels = 2 then
            Kj.Last := MaxN;
     
        end;
      end;
    end; {ReadOneDataBlock}
     
    procedure ReadWAVFile(var Ki, Kj: Observation);
    var
      MM: Byte;
     
      I: Integer;
      OK: Boolean;
      NoDataYet: Boolean;
      DataYet: Boolean;
      nDataBytes: LongInt;
    begin
     
      if FileExists(StandardInput) then
        with Ki.WAV do
        begin { Вызов диалога открытия файла }
          OK := True; {если не изменится где-нибудь ниже}
          {Приготовления для чтения файла данных}
          AssignFile(InFile, StandardInput); { Файл, выбранный в диалоговом окне }
          Reset(InFile);
     
          {Считываем ChunkName "RIFF"}
          ReadChunkName;
          if ChunkName <> 'RIFF' then
            OK := False;
     
          {Считываем ChunkSize}
          ReadChunkSize;
          RIFFSize := ChunkSize.lint; {должно быть 18,678}
     
          {Считываем ChunkName "WAVE"}
          ReadChunkName;
          if ChunkName <> 'WAVE' then
            OK := False;
     
          {Считываем ChunkName "fmt_"}
          ReadChunkName;
          if ChunkName <> 'fmt ' then
            OK := False;
     
          {Считываем ChunkSize}
          ReadChunkSize;
          fmtSize := ChunkSize.lint; {должно быть 18}
     
          {Считываем  formatTag, nChannels}
          ReadChunkSize;
          ChunkSize.x := M1;
          formatTag := ChunkSize.up;
          nChannels := ChunkSize.dn;
     
          {Считываем  nSamplesPerSec}
          ReadChunkSize;
          nSamplesPerSec := ChunkSize.lint;
     
          {Считываем  nAvgBytesPerSec}
          ReadChunkSize;
          nAvgBytesPerSec := ChunkSize.lint;
     
          {Считываем  nBlockAlign}
          ChunkSize.x := F0;
          ChunkSize.lint := 0;
          for I := 0 to 3 do
          begin
            Read(InFile, MM);
            ChunkSize.chrs[I] := MM;
          end;
          ChunkSize.x := M1;
          nBlockAlign := ChunkSize.up;
     
          {Считываем  nBitsPerSample}
          nBitsPerSample := ChunkSize.dn;
          for I := 17 to fmtSize do
            Read(InFile, MM);
     
          NoDataYet := True;
          while NoDataYet do
          begin
            {Считываем метку блока данных "data"}
            ReadChunkName;
     
            {Считываем DataSize}
            ReadChunkSize;
            DataSize := ChunkSize.lint;
     
            if ChunkName <> 'data' then
            begin
              for I := 1 to DataSize do
                {пропуск данных, не относящихся к набору звуковых данных}
                Read(InFile, MM);
            end
            else
              NoDataYet := False;
          end;
     
          nDataBytes := DataSize;
          {Наконец, начинаем считывать данные для байтов nDataBytes}
          if nDataBytes > 0 then
            DataYet := True;
          N := 0; {чтение с первой позиции}
          while DataYet do
          begin
            ReadOneDataBlock(Ki, Kj); {получаем 4 байта}
            nDataBytes := nDataBytes - 4;
            if nDataBytes <= 4 then
              DataYet := False;
          end;
     
          ScaleData(Ki);
          if Ki.WAV.nChannels = 2 then
          begin
            Kj.WAV := Ki.WAV;
            ScaleData(Kj);
          end;
          {Освобождаем буфер файла}
          CloseFile(InFile);
        end
      else
      begin
        InitSpecs; {файл не существует}
        InitSignals(Ki); {обнуляем массив "Ki"}
        InitSignals(Kj); {обнуляем массив "Kj"}
      end;
    end; { ReadWAVFile }
     
    {================= Операции с набором данных ====================}
     
    const
      MaxNumberOfDataBaseItems = 360;
    type
      SignalDirectoryIndex = 0..MaxNumberOfDataBaseItems;
     
    var
      DataBaseFile: file of Observation;
     
      LastDataBaseItem: LongInt; {Номер текущего элемента набора данных}
      ItemNameS: array[SignalDirectoryIndex] of string[40];
     
    procedure GetDatabaseItem(Kk: Observation; N: LongInt);
    begin
     
      if N <= LastDataBaseItem then
      begin
        Seek(DataBaseFile, N);
        Read(DataBaseFile, Kk);
      end
      else
        InitSignals(Kk);
    end; {GetDatabaseItem}
     
    procedure PutDatabaseItem(Kk: Observation; N: LongInt);
    begin
     
      if N < MaxNumberOfDataBaseItems then
        if N <= LastDataBaseItem then
        begin
          Seek(DataBaseFile, N);
          Write(DataBaseFile, Kk);
          LastDataBaseItem := LastDataBaseItem + 1;
        end
        else
          while LastDataBaseItem <= N do
          begin
            Seek(DataBaseFile, LastDataBaseItem);
            Write(DataBaseFile, Kk);
            LastDataBaseItem := LastDataBaseItem + 1;
          end
      else
        ReportError(1); {Попытка чтения MaxNumberOfDataBaseItems}
    end; {PutDatabaseItem}
     
    procedure InitDataBase;
    begin
     
      LastDataBaseItem := 0;
      if FileExists(StandardDataBase) then
      begin
        Assign(DataBaseFile, StandardDataBase);
        Reset(DataBaseFile);
        while not EOF(DataBaseFile) do
        begin
          GetDataBaseItem(K0R, LastDataBaseItem);
          ItemNameS[LastDataBaseItem] := K0R.Name;
          LastDataBaseItem := LastDataBaseItem + 1;
        end;
        if EOF(DataBaseFile) then
          if LastDataBaseItem > 0 then
            LastDataBaseItem := LastDataBaseItem - 1;
      end;
    end; {InitDataBase}
     
    function FindDataBaseName(Nstg: string): LongInt;
    var
      ThisOne: LongInt;
    begin
     
      ThisOne := 0;
      FindDataBaseName := -1;
      while ThisOne < LastDataBaseItem do
      begin
        if Nstg = ItemNameS[ThisOne] then
        begin
          FindDataBaseName := ThisOne;
          Exit;
        end;
        ThisOne := ThisOne + 1;
      end;
    end; {FindDataBaseName}
     
    {======================= Инициализация модуля ========================}
     
    procedure InitLinearSystem;
    begin
     
      BaseFileName := '\PROGRA~1\SIGNAL~1\';
      StandardOutput := BaseFileName + 'K0.wav';
      StandardInput := BaseFileName + 'K0.wav';
     
      StandardDataBase := BaseFileName + 'Radar.sdb';
     
      InitAllSignals;
      InitDataBase;
      ReadWAVFile(K0R, K0B);
      ScaleAllData;
    end; {InitLinearSystem}
     
    begin {инициализируемый модулем код}
     
      InitLinearSystem;
    end. {Unit LinearSystem}

