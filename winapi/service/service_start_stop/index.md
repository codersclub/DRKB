---
Title: Как запустить и остановить сервис (или получить его статус)?
Date: 01.01.2007
---

Как запустить и остановить сервис (или получить его статус)?
============================================================

::: {.date}
01.01.2007
:::

Здесь представлены две функции ServiceStart и ServiceStop, которые
показывают, как пользоваться API функциями OpenSCManager, OpenService и
т.д.:

    function ServiceStart(aMachine, aServiceName : string ) : boolean; 
    // aMachine это UNC путь, либо локальный компьютер если пусто
    var 
      h_manager,h_svc: SC_Handle; 
      svc_status: TServiceStatus; 
      Temp: PChar; 
      dwCheckPoint: DWord; 
    begin 
      svc_status.dwCurrentState := 1; 
      h_manager := OpenSCManager(PChar(aMachine), Nil, 
                                 SC_MANAGER_CONNECT); 
      if h_manager > 0 then 
      begin 
        h_svc := OpenService(h_manager, PChar(aServiceName), 
                             SERVICE_START or SERVICE_QUERY_STATUS); 
        if h_svc > 0 then 
        begin 
          temp := nil; 
          if (StartService(h_svc,0,temp)) then 
            if (QueryServiceStatus(h_svc,svc_status)) then 
            begin 
              while (SERVICE_RUNNING <> svc_status.dwCurrentState) do 
              begin 
                dwCheckPoint := svc_status.dwCheckPoint; 
     
                Sleep(svc_status.dwWaitHint); 
     
                if (not QueryServiceStatus(h_svc,svc_status)) then 
                  break; 
     
                if (svc_status.dwCheckPoint < dwCheckPoint) then 
                begin 
                  // QueryServiceStatus не увеличивает dwCheckPoint 
                  break; 
                end; 
              end; 
            end; 
          CloseServiceHandle(h_svc); 
        end; 
        CloseServiceHandle(h_manager); 
      end; 
      Result := SERVICE_RUNNING = svc_status.dwCurrentState; 
    end; 

    function ServiceStop(aMachine,aServiceName : string ) : boolean; 
    // aMachine это UNC путь, либо локальный компьютер если пусто
    var 
      h_manager,h_svc   : SC_Handle; 
      svc_status     : TServiceStatus; 
      dwCheckPoint : DWord; 
    begin 
      h_manager:=OpenSCManager(PChar(aMachine),nil, 
                               SC_MANAGER_CONNECT); 
      if h_manager > 0 then 
      begin 
        h_svc := OpenService(h_manager,PChar(aServiceName), 
                             SERVICE_STOP or SERVICE_QUERY_STATUS); 
     
        if h_svc > 0 then 
        begin 
          if(ControlService(h_svc,SERVICE_CONTROL_STOP, 
                            svc_status))then 
          begin 
            if(QueryServiceStatus(h_svc,svc_status))then 
            begin 
              while(SERVICE_STOPPED <> svc_status.dwCurrentState)do 
              begin 
                dwCheckPoint := svc_status.dwCheckPoint; 
                Sleep(svc_status.dwWaitHint); 
     
                if(not QueryServiceStatus(h_svc,svc_status))then 
                begin 
                  // couldn't check status 
                  break; 
                end; 
     
                if(svc_status.dwCheckPoint < dwCheckPoint)then 
                  break; 
     
              end; 
            end; 
          end; 
          CloseServiceHandle(h_svc); 
        end; 
        CloseServiceHandle(h_manager); 
      end; 
     
      Result := SERVICE_STOPPED = svc_status.dwCurrentState; 
    end; 

Чтобы узнать состояние сервиса, используйте следующую функцию:

    function ServiceGetStatus(sMachine, sService: string ): DWord; 
    var 
      h_manager,h_service: SC_Handle; 
      service_status     : TServiceStatus; 
      hStat : DWord; 
    begin 
      hStat := 1; 
      h_manager := OpenSCManager(PChar(sMachine),Nil, 
                                 SC_MANAGER_CONNECT); 
     
      if h_manager > 0 then 
      begin 
        h_svc := OpenService(h_manager,PChar(sService), 
                          SERVICE_QUERY_STATUS); 
     
        if h_svc > 0 then 
        begin 
          if(QueryServiceStatus(h_svc, service_status)) then 
            hStat := service_status.dwCurrentState; 
     
          CloseServiceHandle(h_svc); 
        end; 
        CloseServiceHandle(h_manager); 
      end; 
     
      Result := hStat; 
    end; 
     

Она возвращает одну из следующих констант:

SERVICE\_STOPPED

SERVICE\_RUNNING

SERVICE\_PAUSED

SERVICE\_START\_PENDING

SERVICE\_STOP\_PENDING

SERVICE\_CONTINUE\_PENDING

или

SERVICE\_PAUSE\_PENDING

Всё что, что Вам нужно, это unit WinSvc !

Взято из <https://forum.sources.ru>
