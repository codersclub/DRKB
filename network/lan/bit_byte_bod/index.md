---
Title: Формулы передачи данных для начинающих
Author: Jason Pierce
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Формулы передачи данных для начинающих
======================================

Данным примером я попытаюсь дать ответы на следующие вопросы:

Каково различие между `KBps` и `Kbps`? В чём заключается отличие битов,
байтов и бодов? Как определить скорость передачи данных? Как выяснить,
насколько долго будет загружаться файл с определённой скоростью? Как
посчитать время, оставшее до окончания загрузки?

Для начала хотелось бы навести порядок с некоторой неразберихой по поводу
`KBps` и `Kbps` (буква `b` в нижнем регистре). `KBps` это обозначение для
килобайт в секунду, в то время как `Kbps` обозначает килобиты в секунду. 1
килобайт (KB) = 8 килобитам (Kb).

Когда речь идёт о скорости передачи, то применяется Kbps. Таким образом
модем со скорость передачи 33.6K (33600 bps) передаёт данные со
скоростью 4.2 KBps (4.2 килобайта в секунду). Как мы видим, разница
между KB и Kb довольно ощутима. В этом кроется причина того, что
некоторые пользователи модемов по своему незнанию не могут понять,
почему данные передаются так медленно. На самом деле данные объёмом
33.6K передаются не за 1 секунду, а за 8, соответственно за одну секунду
будет передано 33.6 Kb / 8 = 4.2.

Так же хотелось бы дать некоторые разъяснения по поводу слова "бод"
(baud). Обычно для модема "боды" расшифровываются как бит в секунду.
На самом деле это не так. Бод (Baud) означает частоту звука в телефонной
линии. Т. е. в зависимости от модема, который Вы используете, количество
бит, которые могут быть переданы зависит от частоты звука, необходимой
для обеспечения нужной скорости передачи.

Обратите внимание: Приведённый ниже пример, использует компонент
NetMasters TNMHTTP. Однако, если Вы "прикипели" к какому-то другому
компоненту TCP/IP, то переделать пример под этот компонент не составит
большого труда.

Используемые обозначения:

`bps` = байт, переданных за 1 секунду  
`KBps` (KB/Sec) = bps / 1024  
`Kbps` (Kb/Sec) = KBps x 8

Краткий алгоритм приведённого ниже примера:

1. Сохраняем в переменной время начала загрузки: `nStartTime := GetTickCount;`

2. Сохраняем в переменной размер файла (KB): `nFileSize := "File Size";`

3. Начало передачи данных.

4. Обновляем количество переданных байт: `Inc(nBytesTransferred, nNewBytes);`

5. Получаем оставшееся время: `nTimeElapsed := (GetTickCount - nStartTime) / 1000;`

6. Вычисляем bps: `nBps := BytesTransferred / nTimeElapsed;`

7. Вычисляем KBps: `nKBps := nBps / 1024;`

Используемые данные:

`Общее время скачивания (секунд) := nFileSize / nKBps;`

`bps := FloatToStr(nBps);`

`KB/Sec (KBps) := FloatToStr(nKBps);`

`Осталось секунд := FloatToStr(((nFileSize - BytesTransferred) / 1024) / KBps);`

Рабочий пример:

    unit Main; 
     
    interface 
     
    uses 
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs, 
      StdCtrls, Gauges, Psock, NMHttp; 
     
    type 
      TfMain = class(TForm) 
        Label1: TLabel; 
        eURL: TEdit; 
        bGet: TButton; 
        lbMessages: TListBox; 
        gbDetails: TGroupBox; 
        lEstimate: TLabel; 
        lKBps: TLabel; 
        lReceived: TLabel; 
        lRemaining: TLabel; 
        gProgress: TGauge; 
        NMHTTP1: TNMHTTP; 
        lbps: TLabel; 
        bCancel: TButton; 
        procedure NMHTTP1PacketRecvd(Sender: TObject); 
        procedure bGetClick(Sender: TObject); 
        procedure bCancelClick(Sender: TObject); 
        procedure NMHTTP1Connect(Sender: TObject); 
        procedure NMHTTP1ConnectionFailed(Sender: TObject); 
        procedure NMHTTP1Disconnect(Sender: TObject); 
        procedure NMHTTP1Failure(Cmd: CmdType); 
        procedure NMHTTP1HostResolved(Sender: TComponent); 
        procedure NMHTTP1InvalidHost(var Handled: Boolean); 
        procedure NMHTTP1Status(Sender: TComponent; Status: String); 
        procedure NMHTTP1Success(Cmd: CmdType); 
      private 
        { Private declarations } 
        function ss2nn(Seconds: Integer): String; 
      public 
        { Public declarations } 
      end; 
     
    var 
      fMain: TfMain; 
      nFileSize: Double; 
      nStartTime: DWord; 
     
    implementation 
     
    {$R *.DFM} 
     
    {Цель этой функции состоит в том, чтобы определить, сколько минут и секунд там находятся в данном количестве секунд} 
    function TfMain.ss2nn(Seconds: Integer): String; 
    var 
      nMin, nSec: Integer; 
    begin 
      {Проверяем, меньше чем 1/Min} 
      if Seconds < 60 then Result := '0 minutes ' + IntToStr(Seconds) + ' seconds' 
      else begin 
        {Определяем минуты} 
        nMin := Seconds div 60; 
        {Определяем секунды} 
        nSec := Seconds - (nMin * 60); 
        {Возвращаем результат} 
        Result := IntToStr(nMin) + ' minutes ' + IntToStr(nSec) + ' seconds'; 
      end; 
    end; 
     
    procedure TfMain.NMHTTP1PacketRecvd(Sender: TObject); 
    var 
      nBytesReceived, nTimeElapsed, nBps, nKBps: Double; 
    begin 
      {Следующий код выполняется только однажды, при приёме первого пакета}
      if nFileSize <> NMHTTP1.BytesTotal then 
      begin 
        {Получаем размер файла} 
        nFileSize := NMHTTP1.BytesTotal; 
        {Вычисляем время передачи, исходя из скорости соединения 33.6 Kbps} 
        lEstimate.Caption := 'Estimated download time at 33.6 Kbps: ' + ss2nn(Round( 
          (nFileSize / 1024) / 4.2)); 
        {Получаем время начала} 
        nStartTime := GetTickCount; 
      end; 
     
      {Обновляем nBytesReceived} 
      nBytesReceived := NMHTTP1.BytesRecvd; 
     
      {Вычисляем количество секунд прошедших с момента начала передачи} 
      nTimeElapsed := (GetTickCount - nStartTime) / 1000; 
      {Проверяем на 0/Sec, если так, то устанавливаем 1, чтобы предотвратить деления на ноль} 
      if nTimeElapsed = 0 then nTimeElapsed := 1; 
     
      {Вычисляем байт в секунду} 
      nBps := nBytesReceived / nTimeElapsed; 
      {Вычисляем килобайт в секунду} 
      nKBps := nBps / 1024; 
     
      {Обновляем контролы} 
      gProgress.Progress := Round((nBytesReceived * 100) / nFileSize); 
      lbps.Caption := IntToStr(Round(nBps * 8)) + ' bits per second'; 
      lKBps.Caption := IntToStr(Round(nKBps)) + ' KB/Sec (KBps)'; 
      lReceived.Caption := FloatToStr(nBytesReceived) + ' of ' + FloatToStr( 
        nFileSize) + ' bytes received'; 
      lRemaining.Caption := ss2nn(Round(((nFileSize - nBytesReceived) / 1024) / 
        nKBps)) + ' remaining'; 
    end; 
     
    procedure TfMain.bGetClick(Sender: TObject); 
    begin 
      {Сбрасываем переменные} 
      nFileSize := 0; 
     
      {Обнуляем контролы} 
      lbMessages.Clear; 
      gProgress.Progress := 0; 
      lEstimate.Caption := 'Estimated download time at 33.6 Kbps: 0 minutes 0 ' + 
        'seconds'; 
      lbps.Caption := '0 bits per second'; 
      lKBps.Caption := '0 KB/Sec (KBps)'; 
      lReceived.Caption := '0 of 0 bytes received'; 
      lRemaining.Caption := '0 minutes 0 seconds remaining'; 
     
      {Получаем файл} 
      NMHTTP1.Get(eURL.Text); 
    end; 
     
    procedure TfMain.bCancelClick(Sender: TObject); 
    begin 
      {Разрываем соединение с сервером} 
      NMHTTP1.Disconnect; 
     
      {Обновляем lbMessages} 
      lbMessages.Items.Append('Get Canceled'); 
      lbMessages.Items.Append('Disconnected'); 
    end; 
     
    procedure TfMain.NMHTTP1Connect(Sender: TObject); 
    begin 
      {Запрещаем/Разрешаем контролы} 
      bGet.Enabled := False; 
      bCancel.Enabled := True; 
     
      {Работаем с lbMessages} 
      with lbMessages.Items do 
      begin 
        Append('Connected'); 
        Append('Local Address: ' + NMHTTP1.LocalIP); 
        Append('Remote Address: ' + NMHTTP1.RemoteIP); 
      end; 
    end; 
     
    procedure TfMain.NMHTTP1ConnectionFailed(Sender: TObject); 
    begin 
      ShowMessage('Connection Failed.'); 
    end; 
     
    procedure TfMain.NMHTTP1Disconnect(Sender: TObject); 
    begin 
      {Запрещаем/Разрешаем контролы} 
      bCancel.Enabled := False; 
      bGet.Enabled := True; 
     
      {Обновляем lbMessages} 
      if NMHTTP1.Connected then lbMessages.Items.Append('Disconnected'); 
    end; 
     
    procedure TfMain.NMHTTP1Failure(Cmd: CmdType); 
    begin 
      case Cmd of 
        CmdGET    : lbMessages.Items.Append('Get Failed'); 
        CmdOPTIONS: lbMessages.Items.Append('Options Failed'); 
        CmdHEAD   : lbMessages.Items.Append('Head Failed'); 
        CmdPOST   : lbMessages.Items.Append('Post Failed'); 
        CmdPUT    : lbMessages.Items.Append('Put Failed'); 
        CmdPATCH  : lbMessages.Items.Append('Patch Failed'); 
        CmdCOPY   : lbMessages.Items.Append('Copy Failed'); 
        CmdMOVE   : lbMessages.Items.Append('Move Failed'); 
        CmdDELETE : lbMessages.Items.Append('Delete Failed'); 
        CmdLINK   : lbMessages.Items.Append('Link Failed'); 
        CmdUNLINK : lbMessages.Items.Append('UnLink Failed'); 
        CmdTRACE  : lbMessages.Items.Append('Trace Failed'); 
        CmdWRAPPED: lbMessages.Items.Append('Wrapped Failed'); 
      end; 
    end; 
     
    procedure TfMain.NMHTTP1HostResolved(Sender: TComponent); 
    begin 
      lbMessages.Items.Append('Host Resolved'); 
    end; 
     
    procedure TfMain.NMHTTP1InvalidHost(var Handled: Boolean); 
    begin 
      ShowMessage('Invalid Host. Please specify a new URL.'); 
    end; 
     
    procedure TfMain.NMHTTP1Status(Sender: TComponent; Status: String); 
    begin 
      if NMHTTP1.ReplyNumber = 404 then ShowMessage('Object Not Found.'); 
    end; 
     
    procedure TfMain.NMHTTP1Success(Cmd: CmdType); 
    begin 
      case Cmd of 
        {Удостоверяемся, что процедура получения не была прервана} 
        CmdGET: if NMHTTP1.Connected then lbMessages.Items.Append('Get Succeeded'); 
     
        CmdOPTIONS: lbMessages.Items.Append('Options Succeeded'); 
        CmdHEAD   : lbMessages.Items.Append('Head Succeeded'); 
        CmdPOST   : lbMessages.Items.Append('Post Succeeded'); 
        CmdPUT    : lbMessages.Items.Append('Put Succeeded'); 
        CmdPATCH  : lbMessages.Items.Append('Patch Succeeded'); 
        CmdCOPY   : lbMessages.Items.Append('Copy Succeeded'); 
        CmdMOVE   : lbMessages.Items.Append('Move Succeeded'); 
        CmdDELETE : lbMessages.Items.Append('Delete Succeeded'); 
        CmdLINK   : lbMessages.Items.Append('Link Succeeded'); 
        CmdUNLINK : lbMessages.Items.Append('UnLink Succeeded'); 
        CmdTRACE  : lbMessages.Items.Append('Trace Succeeded'); 
        CmdWRAPPED: lbMessages.Items.Append('Wrapped Succeeded'); 
      end; 
    end; 
     
    end.

