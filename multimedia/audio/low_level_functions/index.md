---
Title: Низкоуровневые процедуры обработки звука
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Низкоуровневые процедуры обработки звука
========================================

Ниже приведен код, обрабатывающий аудиосигнал, получаемый со входа
звуковой карты (SoundBlaster). Надеюсь он поможет разобраться вам с этой
сложной темой.

Включенный в код модуль RECUNIT делает всю изнурительную работу по
извлечению звука со входа звуковой карты.

    var
      WaveRecorder: TWaveRecorder;
     
    ...
     
    WaveRecorder := TwaveRecorder(2048, 4); // 4 размером 2048 байт
     
    { Устанавливает параметры дискретизации }
    with WaveRecorder.pWavefmtEx do
    begin
      wFormatTag := WAVE_FORMAT_PCM;
      nChannels := 1;
      nSamplesPerSec := 20000;
      wBitsPerSample := 16;
      nAvgBytesPerSec := nSamplesPerSec * (wBitsPerSample div 8) * nChannels;
    end;
     
    // Затем используем вариантную запись, поскольку я не знаю
    // как получить адрес самого объекта
     
    WaveRecorder.SetupRecord(@WaveRecorder);
     
    // Начинаем запись
    WaveRecorder.StartRecord;
     
    //...При каждом заполнении буфера вызывается
    //  процедура WaveRecorder.Processbuffer.
     
    //  Заканчиваем запись
    WaveRecorder.StopRecord;
    WaveRecorder.Destroy;

    {
    Имя файла: RECUNIT.PAS  V 1.01
    Создан: Авг 19 1996 в 21:56 на IBM ThinkPad
    Ревизия #7: Авг 22 1997, 15:01 на IBM ThinkPad
    -John Mertus
     
    Данный модуль содержит необходимые процедуры для записи звука.
     
    Версия 1.00 - первый релиз
    1.01 - добавлен TWaveInGetErrorText
    }
     
    {-----------------Unit-RECUNIT---------------------John Mertus---Авг 96---}
     
    unit RECUNIT;
     
    {*************************************************************************}
     
    interface
     
    uses
     
      Windows, MMSystem, SysUtils, MSACM;
     
    {  Ниже определен класс TWaveRecorder для обслуживания входа звуковой    }
    {  карты. Ожидается, что новый класс будет производным от TWaveRecorder  }
    {  и перекроет TWaveRecorder.ProcessBuffer. После начала записи данная   }
    {  процедура вызывается каждый раз при наличии в буфере аудио-данных.    }
     
    const
     
      MAX_BUFFERS = 8;
     
    type
     
      PWaveRecorder = ^TWaveRecorder;
      TWaveRecorder = class(TObject)
        constructor Create(BfSize, TotalBuffers: Integer);
        destructor Destroy; override;
        procedure ProcessBuffer(uMsg: Word; P: Pointer; n: Integer);
          virtual;
     
        private
         
        fBufferSize: Integer; // Размер буфера
        BufIndex: Integer;
        fTotalBuffers: Integer;
     
        pWaveHeader: array[0..MAX_BUFFERS - 1] of PWAVEHDR;
        hWaveHeader: array[0..MAX_BUFFERS - 1] of THANDLE;
        hWaveBuffer: array[0..MAX_BUFFERS - 1] of THANDLE;
        hWaveFmtEx: THANDLE;
        dwByteDataSize: DWORD;
        dwTotalWaveSize: DWORD;
     
        RecordActive: Boolean;
        bDeviceOpen: Boolean;
     
        { Внутренние функции класса }
        function InitWaveHeaders: Boolean;
        function AllocPCMBuffers: Boolean;
        procedure FreePCMBuffers;
     
        function AllocWaveFormatEx: Boolean;
        procedure FreeWaveFormatEx;
     
        function AllocWaveHeaders: Boolean;
        procedure FreeWaveHeader;
     
        function AddNextBuffer: Boolean;
        procedure CloseWaveDeviceRecord;
     
        public
        
        { Public declarations }
        pWaveFmtEx: PWaveFormatEx;
        WaveBufSize: Integer; // Размер поля nBlockAlign
        InitWaveRecorder: Boolean;
        RecErrorMessage: string;
        QueuedBuffers,
          ProcessedBuffers: Integer;
        pWaveBuffer: array[0..MAX_BUFFERS - 1] of lpstr;
        WaveIn: HWAVEIN; { Дескриптор Wav-устройства }
     
        procedure StopRecord;
        function 477576218068 StartRecord: Boolean;
        Function477576218068 SetupRecord(P: PWaveRecorder): Boolean;
     
      end;
     
    {*************************************************************************}
     
    implementation
     
    {-------------TWaveInGetErrorText-----------John Mertus---14-Июнь--97--}
     
    function TWaveInGetErrorText(iErr: Integer): string;
     
    { Выдает сообщения об ошибках WaveIn в формате Pascal                  }
    { iErr - номер ошибки                                                  }
    {                                                                      }
    {**********************************************************************}
    var
      PlayInErrorMsgC: array[0..255] of Char;
     
    begin
      waveInGetErrorText(iErr, PlayInErrorMsgC, 255);
      TWaveInGetErrorText := StrPas(PlayInErrorMsgC);
    end;
     
    {-------------InitWaveHeaders---------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.AllocWaveFormatEx: Boolean;
     
    { Распределяем формат большого размера, требуемый для инсталляции ACM-в}
    {                                                                      }
    {**********************************************************************}
    var
     
      MaxFmtSize: UINT;
     
    begin
     
      { maxFmtSize - сумма sizeof(WAVEFORMATEX) + pwavefmtex.cbSize }
      if (acmMetrics(0, ACM_METRIC_MAX_SIZE_FORMAT, maxFmtSize) <> 0) > then
      begin
        RecErrorMessage := 'Ошибка получения размера формата максимального сжатия';
        AllocWaveFormatEx := False;
        Exit;
      end;
     
      { распределяем структуру WAVEFMTEX }
      hWaveFmtEx := GlobalAlloc(GMEM_MOVEABLE, maxFmtSize);
      if (hWaveFmtEx = 0) then
      begin
        RecErrorMessage := 'Ошибка распределения памяти для структуры WaveFormatEx';
        AllocWaveFormatEx := False;
        Exit;
      end;
     
      pWaveFmtEx := PWaveFormatEx(GlobalLock(hWaveFmtEx));
      if (pWaveFmtEx = nil) then
      begin
        RecErrorMessage := 'Ошибка блокировки памяти WaveFormatEx';
        AllocWaveFormatEx := False;
        Exit;
      end;
     
      { инициализация формата в стандарте PCM }
      ZeroMemory(pwavefmtex, maxFmtSize);
      pwavefmtex.wFormatTag := WAVE_FORMAT_PCM;
      pwavefmtex.nChannels := 1;
      pwavefmtex.nSamplesPerSec := 20000;
      pwavefmtex.nBlockAlign := 1;
      pwavefmtex.wBitsPerSample := 16;
      pwavefmtex.nAvgBytesPerSec := pwavefmtex.nSamplesPerSec *
        (pwavefmtex.wBitsPerSample div 8) * pwavefmtex.nChannels;
      pwavefmtex.cbSize := 0;
     
      { Все успешно, идем домой }
      AllocWaveFormatEx := True;
    end;
     
    {-------------InitWaveHeaders---------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.InitWaveHeaders: Boolean;
     
    { Распределяем память, обнуляем заголовок wave и инициализируем        }
    {                                                                      }
    {**********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      { делаем размер буфера кратным величине блока... }
      WaveBufSize := fBufferSize - (fBufferSize mod pwavefmtex.nBlockAlign);
     
      { Устанавливаем wave-заголовки }
      for i := 0 to fTotalBuffers - 1 do
        with pWaveHeader[i]^ do
        begin
          lpData := pWaveBuffer[i]; // адрес буфера waveform
          dwBufferLength := WaveBufSize; // размер, в байтах, буфера
          dwBytesRecorded := 0; // смотри ниже
          dwUser := 0; // 32 бита данных пользователя
          dwFlags := 0; // смотри ниже
          dwLoops := 0; // смотри ниже
          lpNext := nil; // зарезервировано; должен быть ноль
          reserved := 0; // зарезервировано; должен быть ноль
        end;
     
      InitWaveHeaders := TRUE;
    end;
     
    {-------------AllocWaveHeader----------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.AllocWaveHeaders: Boolean;
     
    { Распределяем и блокируем память заголовка                             }
    {                                                                       }
    {***********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      for i := 0 to fTotalBuffers - 1 do
      begin
        hwaveheader[i] := GlobalAlloc(GMEM_MOVEABLE or GMEM_SHARE or
          GMEM_ZEROINIT, sizeof(TWAVEHDR));
     
        if (hwaveheader[i] = 0) then
        begin
          { Примечание: Это может привести к утечке памяти, надеюсь скоро исправить }
          RecErrorMessage := 'Ошибка распределения памяти для wave-заголовка';
          AllocWaveHeaders := FALSE;
          Exit;
        end;
     
        pwaveheader[i] := GlobalLock(hwaveheader[i]);
        if (pwaveheader[i] = nil) then
        begin
          { Примечание: Это может привести к утечке памяти, надеюсь скоро исправить }
          RecErrorMessage := 'Не могу заблокировать память заголовка для записи';
          AllocWaveHeaders := FALSE;
          Exit;
        end;
     
      end;
     
      AllocWaveHeaders := TRUE;
    end;
     
    {---------------FreeWaveHeader---------------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.FreeWaveHeader;
     
    { Просто освобождаем распределенную AllocWaveHeaders память.            }
    {                                                                       }
    {***********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      for i := 0 to fTotalBuffers - 1 do
      begin
        if (hWaveHeader[i] <> 0) then
        begin
          GlobalUnlock(hwaveheader[i]);
          GlobalFree(hwaveheader[i]);
          hWaveHeader[i] := 0;
        end
      end;
    end;
     
    {-------------AllocPCMBuffers----------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.AllocPCMBuffers: Boolean;
     
    { Распределяем и блокируем память waveform.                             }
    {                                                                       }
    {***********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      for i := 0 to fTotalBuffers - 1 do
      begin
        hWaveBuffer[i] := GlobalAlloc(GMEM_MOVEABLE or GMEM_SHARE, fBufferSize);
        if (hWaveBuffer[i] = 0) then
        begin
          { Здесь возможна утечка памяти }
          RecErrorMessage := 'Ошибка распределения памяти wave-буфера';
          AllocPCMBuffers := False;
          Exit;
        end;
     
        pWaveBuffer[i] := GlobalLock(hWaveBuffer[i]);
        if (pWaveBuffer[i] = nil) then
        begin
          { Здесь возможна утечка памяти }
          RecErrorMessage := 'Ошибка блокирования памяти wave-буфера';
          AllocPCMBuffers := False;
          Exit;
        end;
        pWaveHeader[i].lpData := pWaveBuffer[i];
      end;
     
      AllocPCMBuffers := TRUE;
    end;
     
    {--------------FreePCMBuffers----------------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.FreePCMBuffers;
     
    { Освобождаем использованную AllocPCMBuffers память.                    }
    {                                                                       }
    {***********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      for i := 0 to fTotalBuffers - 1 do
      begin
        if (hWaveBuffer[i] <> 0) then
        begin
          GlobalUnlock(hWaveBuffer[i]);
          GlobalFree(hWaveBuffer[i]);
          hWaveBuffer[i] := 0;
          pWaveBuffer[i] := nil;
        end;
      end;
    end;
     
    {--------------FreeWaveFormatEx--------------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.FreeWaveFormatEx;
     
    { Просто освобождаем заголовки ExFormat headers                         }
    {                                                                       }
    {***********************************************************************}
    begin
     
      if (pWaveFmtEx = nil) then
        Exit;
      GlobalUnlock(hWaveFmtEx);
      GlobalFree(hWaveFmtEx);
      pWaveFmtEx := nil;
    end;
     
    {-------------TWaveRecorder.Create------------John Mertus-----Авг--97--}
     
    constructor TWaveRecorder.Create(BFSize, TotalBuffers: Integer);
     
    { Устанавливаем wave-заголовки, инициализируем указатели данных и      }
    { и распределяем буферы дискретизации                                  }
    { BFSize - размер буфера в байтах                                      }
    {                                                                      }
    {**********************************************************************}
    var
     
      i: Integer;
    begin
     
      inherited Create;
      for i := 0 to fTotalBuffers - 1 do
      begin
        hWaveHeader[i] := 0;
        hWaveBuffer[i] := 0;
        pWaveBuffer[i] := nil;
        pWaveFmtEx := nil;
      end;
      fBufferSize := BFSize;
     
      fTotalBuffers := TotalBuffers;
      { распределяем память для структуры wave-формата }
      if (not AllocWaveFormatEx) then
      begin
        InitWaveRecorder := FALSE;
        Exit;
      end;
     
      { ищем устройство, совместимое с доступными wave-характеристиками }
      if (waveInGetNumDevs < 1) then
      begin
        RecErrorMessage := 'Не найдено устройств, способных записывать звук';
        InitWaveRecorder := FALSE;
        Exit;
      end;
     
      { распределяем память wave-заголовка }
      if (not AllocWaveHeaders) then
      begin
        InitWaveRecorder := FALSE;
        Exit;
      end;
     
      { распределяем память буфера wave-данных }
      if (not AllocPCMBuffers) then
      begin
        InitWaveRecorder := FALSE;
        Exit;
      end;
     
      InitWaveRecorder := TRUE;
     
    end;
     
    {---------------------Destroy----------------John Mertus---14-Июнь--97--}
     
    destructor TWaveRecorder.Destroy;
     
    { Просто освобождаем всю память, распределенную InitWaveRecorder.       }
    {                                                                       }
    {***********************************************************************}
     
    begin
     
      FreeWaveFormatEx;
      FreePCMBuffers;
      FreeWaveHeader;
      inherited Destroy;
    end;
     
    {------------CloseWaveDeviceRecord-----------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.CloseWaveDeviceRecord;
     
    { Просто освобождаем (закрываем) waveform-устройство.                   }
    {                                                                       }
    {***********************************************************************}
    var
     
      i: Integer;
     
    begin
     
      { если устройство уже закрыто, то выходим }
      if (not bDeviceOpen) then
        Exit;
     
      { работа с заголовками - unprepare }
      for i := 0 to fTotalBuffers - 1 do
        if (waveInUnprepareHeader(WaveIn, pWaveHeader[i], sizeof(TWAVEHDR)) <> 0)
          then
     
          RecErrorMessage := 'Ошибка в waveInUnprepareHeader';
     
      { сохраняем общий объем записи и обновляем показ }
      dwTotalwavesize := dwBytedatasize;
     
      { закрываем входное wave-устройство }
      if (waveInClose(WaveIn) <> 0) then
        RecErrorMessage := 'Ошибка закрытия входного устройства';
     
      { сообщаем вызвавшей функции, что устройство закрыто }
      bDeviceOpen := FALSE;
     
    end;
     
    {------------------StopRecord-----------------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.StopRecord;
     
    { Останавливаем запись и устанавливаем некоторые флаги.                 }
    {                                                                       }
    {***********************************************************************}
    var
     
      iErr: Integer;
     
    begin
     
      RecordActive := False;
      iErr := waveInReset(WaveIn);
      { прекращаем запись и возвращаем стоящие в очереди буферы }
      if (iErr <> 0) then
      begin
        RecErrorMessage := 'Ошибка в waveInReset';
      end;
     
      CloseWaveDeviceRecord;
    end;
     
    {--------------AddNextBuffer------------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.AddNextBuffer: Boolean;
     
    { Добавляем буфер ко входной очереди и переключаем буферный индекс.     }
    {                                                                       }
    {***********************************************************************}
    var
     
      iErr: Integer;
     
    begin
     
      { ставим буфер в очередь для получения очередной порции данных }
      iErr := waveInAddBuffer(WaveIn, pwaveheader[bufindex], sizeof(TWAVEHDR));
      if (iErr <> 0) then
      begin
        StopRecord;
        RecErrorMessage := 'Ошибка добавления буфера' + TWaveInGetErrorText(iErr);
        AddNextBuffer := FALSE;
        Exit;
      end;
     
      { переключаемся на следующий буфер }
      bufindex := (bufindex + 1) mod fTotalBuffers;
      QueuedBuffers := QueuedBuffers + 1;
     
      AddNextBuffer := TRUE;
    end;
     
    {--------------BufferDoneCallBack------------John Mertus---14-Июнь--97--}
     
    procedure BufferDoneCallBack(
      hW: HWAVE; // дескриптор waveform-устройства
      uMsg: DWORD; // посылаемое сообщение
      dwInstance: DWORD; // экземпляр данных
      dwParam1: DWORD; // определяемый приложением параметр
      dwParam2: DWORD; // определяемый приложением параметр
      ); stdcall;
     
    { Вызывается при наличии у wave-устройства какой-либо информации,       }
    { например при заполнении буфера                                        }
    {                                                                       }
    {***********************************************************************}
    var
     
      BaseRecorder: PWaveRecorder;
    begin
     
      BaseRecorder := Pointer(DwInstance);
      with BaseRecorder^ do
      begin
        ProcessBuffer(uMsg, pWaveBuffer[ProcessedBuffers mod fTotalBuffers],
          WaveBufSize);
     
        if (RecordActive) then
          case uMsg of
            WIM_DATA:
              begin
                BaseRecorder.AddNextBuffer;
                ProcessedBuffers := ProcessedBuffers + 1;
              end;
          end;
      end;
    end;
     
    {------------------StartRecord---------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.StartRecord: Boolean;
     
    { Начало записи.                                                        }
    {                                                                       }
    {***********************************************************************}
    var
     
      iErr, i: Integer;
     
    begin
     
      { начало записи в первый буфер }
      iErr := WaveInStart(WaveIn);
      if (iErr <> 0) then
      begin
        CloseWaveDeviceRecord;
        RecErrorMessage := 'Ошибка начала записи wave: ' +
          TWaveInGetErrorText(iErr);
     
      end;
     
      RecordActive := TRUE;
     
      { ставим в очередь следующие буферы }
      for i := 1 to fTotalBuffers - 1 do
        if (not AddNextBuffer) then
        begin
          StartRecord := FALSE;
          Exit;
        end;
     
      StartRecord := True;
    end;
     
    {-----------------SetupRecord---------------John Mertus---14-Июнь--97--}
     
    function TWaveRecorder.SetupRecord(P: PWaveRecorder): Boolean;
     
    { Данная функция делает всю работу по созданию waveform-"записывателя". }
    {                                                                       }
    {***********************************************************************}
    var
     
      iErr, i: Integer;
     
    begin
     
      dwTotalwavesize := 0;
      dwBytedatasize := 0;
      bufindex := 0;
      ProcessedBuffers := 0;
      QueuedBuffers := 0;
     
      { открываем устройство для записи }
      iErr := waveInOpen(@WaveIn, WAVE_MAPPER, pWaveFmtEx,
        Integer(@BufferDoneCallBack),
     
        Integer(P), CALLBACK_FUNCTION + WAVE_ALLOWSYNC);
      if (iErr <> 0) then
      begin
        RecErrorMessage := 'Не могу открыть входное устройство для записи: ' + ^M
          +
     
        TWaveInGetErrorText(iErr);
        SetupRecord := FALSE;
        Exit;
      end;
     
      { сообщаем CloseWaveDeviceRecord(), что устройство открыто }
      bDeviceOpen := TRUE;
     
      { подготавливаем заголовки }
     
      InitWaveHeaders();
     
      for i := 0 to fTotalBuffers - 1 do
      begin
        iErr := waveInPrepareHeader(WaveIn, pWaveHeader[I], sizeof(TWAVEHDR));
        if (iErr <> 0) then
        begin
          CloseWaveDeviceRecord;
          RecErrorMessage := 'Ошибка подготовки заголовка для записи: ' + ^M +
            TWaveInGetErrorText(iErr);
          SetupRecord := FALSE;
          Exit;
        end;
      end;
     
      { добавляем первый буфер }
      if (not AddNextBuffer) then
      begin
        SetupRecord := FALSE;
        Exit;
      end;
     
      SetupRecord := TRUE;
    end;
     
    {-----------------ProcessBuffer---------------John Mertus---14-Июнь--97--}
     
    procedure TWaveRecorder.ProcessBuffer(uMsg: Word; P: Pointer; n:
      Integer);
     
    { Болванка процедуры, вызываемой при готовности буфера.                 }
    {                                                                       }
    {***********************************************************************}
    begin
    end;
     
    end.

