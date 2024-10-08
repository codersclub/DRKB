---
Title: Перечисление служб
Author: Александр (Rouse_) Багель
Date: 01.01.2007
Source: <https://forum.sources.ru>
---

Перечисление служб
==================

    ////////////////////////////////////////////////////////////////////////////////
    //
    //  ****************************************************************************
    //  * Project   : Project1
    //  * Unit Name : Unit1
    //  * Purpose   : Демо получения информации по сервисам
    //  * Author    : Александр (Rouse_) Багель
    //  * Version   : 1.00
    //  ****************************************************************************
    //
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, ComCtrls, StdCtrls, ExtCtrls, WinSvc;
     
    type
      TfrmMain = class(TForm)
        lvReport: TListView;
        rgServiceState: TRadioGroup;
        sbCount: TStatusBar;
        OpenDialog1: TOpenDialog;
        procedure FormCreate(Sender: TObject);
        procedure rgServiceStateClick(Sender: TObject);
      private
        procedure EnumServices(const State: DWORD);
      end;
     
    var
      frmMain: TfrmMain;
     
    implementation
     
    {$R *.dfm}
     
    procedure TfrmMain.EnumServices(const State: DWORD);
    var
      hSCObject, hService: SC_HANDLE;
      lpServices, TmpEnum: PEnumServiceStatus;
      lpServiceConfig: PQueryServiceConfig;
      I, cbBuffSize, pcbBytesNeeded,
      lpServicesReturned, lpResumeHandle: DWORD;
    begin
      lvReport.Items.BeginUpdate;
      try
        lvReport.Items.Clear;
        // Открываем менеджер сервисов
        hSCObject := OpenSCManager(nil, nil, SC_MANAGER_ENUMERATE_SERVICE);
        if hSCObject <> 0 then
        try
          lpResumeHandle := 0;
          lpServices := nil;
          // Смотрим сколько нужно памяти чтобы получить информацию
          EnumServicesStatus(hSCObject, SERVICE_WIN32, State,
            lpServices^, 0, pcbBytesNeeded, lpServicesReturned, lpResumeHandle);
          if GetLastError = ERROR_MORE_DATA then
          begin
            // Выделяем нужную память
            GetMem(lpServices, pcbBytesNeeded);
            try
              cbBuffSize := pcbBytesNeeded;
              // Получаем требуемую информацию по установленным сервисам
              if EnumServicesStatus(hSCObject, SERVICE_WIN32, State,
                lpServices^, cbBuffSize, pcbBytesNeeded, lpServicesReturned, lpResumeHandle) then
              begin
                TmpEnum := lpServices;
                // Бежим в цикле по записям
                for I := 0 to lpServicesReturned - 1 do
                begin
                  // Выводим данные на экран
                  with lvReport.Items.Add do
                  begin
                    // Наименование сервиса
                    Caption := TmpEnum^.lpServiceName;
                    // Описание сервиса
                    SubItems.Add(TmpEnum^.lpDisplayName);
                    // Состояние
                    case TmpEnum^.ServiceStatus.dwCurrentState of
                      SERVICE_RUNNING: SubItems.Add('Работает');
                      SERVICE_STOPPED: SubItems.Add('Остановлен');
                    else
                      SubItems.Add('Неизвестно');
                    end;
                    // Для дополнительной информаци по сервису получаем описатель сервиса
                    hService := OpenService(hSCObject, TmpEnum^.lpServiceName,
                      SERVICE_QUERY_CONFIG);
                    if hService <> 0 then
                    try
                      // Смотрим сколько нужно памяти
                      QueryServiceConfig(hService, nil, 0, pcbBytesNeeded);
                      if GetLastError = ERROR_INSUFFICIENT_BUFFER then
                      begin
                        cbBuffSize := pcbBytesNeeded;
                        // Берем память
                        GetMem(lpServiceConfig, pcbBytesNeeded);
                        try
                          // Получаем расширенную информацию по сервису
                          if QueryServiceConfig(hService, lpServiceConfig,
                            cbBuffSize, pcbBytesNeeded) then
                          begin
                            // Путь к сервису
                            SubItems.Add(lpServiceConfig^.lpBinaryPathName);
                            // Доступ к рабочему столу
                            if (lpServiceConfig^.dwServiceType and SERVICE_INTERACTIVE_PROCESS) =
                              SERVICE_INTERACTIVE_PROCESS then
                            begin
                              SubItems.Add('Да');
                              lpServiceConfig^.dwServiceType :=
                                lpServiceConfig^.dwServiceType - SERVICE_INTERACTIVE_PROCESS;
                            end
                            else
                              SubItems.Add('Нет');
                            // Тип сервиса
                            case lpServiceConfig^.dwServiceType of
                              SERVICE_WIN32_OWN_PROCESS:
                                SubItems.Add('Одиночный');
                              SERVICE_WIN32_SHARE_PROCESS:
                                SubItems.Add('Не одиночный');
                            else
                                SubItems.Add('Неизвестный тип службы');
                            end;
                            // Группа
                            SubItems.Add(lpServiceConfig^.lpLoadOrderGroup);
                            // Тип запуска
                            case lpServiceConfig^.dwStartType of
                              SERVICE_AUTO_START:
                                SubItems.Add('Автоматический');
                              SERVICE_DEMAND_START:
                                SubItems.Add('Вручную');
                              SERVICE_DISABLED:
                                SubItems.Add('Отключен');
                            end;
                          end;
                        // Завершающее освобождение памяти
                        finally
                          FreeMem(lpServiceConfig);
                        end;
                      end;
                    finally
                      CloseServiceHandle(hService);
                    end;
                  end;
                  Inc(TmpEnum);
                end;
              end;
            finally
              FreeMem(lpServices);
            end;
          end;
        finally
          CloseServiceHandle(hSCObject);
        end;
      finally
        lvReport.Items.EndUpdate;
        sbCount.Panels.Items[0].Text := ' Общее количество: ' +
          IntToStr(lvReport.Items.Count);
      end;
    end;
     
    procedure TfrmMain.FormCreate(Sender: TObject);
    begin
      rgServiceState.OnClick(nil);
    end;
     
    procedure TfrmMain.rgServiceStateClick(Sender: TObject);
    begin
      // В зависимости от выбранного RadioItem перечисляем -
      // все сервисы, только активные или неактивные
      if rgServiceState.ItemIndex = 0 then
        EnumServices(SERVICE_STATE_ALL)
      else
        EnumServices(rgServiceState.ItemIndex);
    end;
     
    end.

