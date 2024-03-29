---
Title: Реализация CallBack вызовов MapInfo
Author: Дмитрий Кузан
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Реализация CallBack вызовов MapInfo
===================================

Доброе время суток !

Краткое примечание

Немного об отзывах - хочу сообщить и повторить снова - в данных циклах
статей не будет информации об ActiveX компоненте MapX (о работе с ней,
отзывы о ней и т.п.) по причине отсутствия у меня оной (может кто
поделится J).

Использование уведомляющих вызовов (Callbacks) для получения информации
из Maplnfo - краткий учебный курс.

Вы можете построить Ваше приложение так, чтобы Maplnfo автоматически
посылало информацию Вашей клиентской программе. Например, можно сделать
так, чтобы всякий раз при открытии и смене диалоговых окон сообщать
ID-номер текущего окна.

Такой тип уведомления известен как обратный вызов или уведомление
(callback).

Уведомления используються в следующих случаях:

Пользователь применяет инструмент в окне. Например, если пользователь
производит перемещение объекта мышкой в окне Карты, MapInfo может
вызвать Вашу клиентскую программу, чтобы сообщить х- и у-координаты.

Пользователь выбирает команду меню. Например, предположим, что Ваше
приложение настраивает "быстрое" меню MapInfo (меню, возникающее при
нажатии правой кнопки мышки). Когда пользователь выбирает команду из
этого меню, MapInfo может вызвать Вашу клиентскую программу, чтобы
сообщить ей о выборе.

Изменяется окно Карты. Если пользователь изменяет содержание окна Карты
(например, добавляя или передвигая слои), MapInfo может послать Вашей
клиентской программе идентификатор этого окна.

Изменяется текст в строке сообщений MapInfo. Строка состояния MapInfo не
появляется автоматически в приложениях Интегрированной Картографии. Если
Вы хотите, чтобы Ваша клиентская программа эмулировала строку состояния
MapInfo, то Вы должны построить приложение так, чтобы MapInfo сообщало
вашей клиентской программе об изменениях текста в строке состояния.

Требования к функциям уведомления

Программа должна быть способна функционировать, как DDE-сервер или как
сервер Автоматизации OLE.

Предопределенные процедуры SetStatusText, WindowContentsChanged.

Если Вы хотите имитировать строку состояния MapInfo, создайте метод,
называемый SetStatusText. Определите этот метод так, чтобы у него был
один аргумент: строка.

метод WindowContentsChanged, MapInfo посылает четырехбайтовое целое
число (ID окна MapInfo), чтобы указать, какое из окон Карты изменилось.
Напишите код, делающий необходимую обработку.

Возможно так-же и регистрация пользовательских событий. но это отложим
пока на третью часть.

Переинсталяция компонента TKDMapInfoServer

Удалите старый компонент

Зарегистрируете в системе библиотеку MICallBack.dll, для этого откройте
MICallBack.dpr и в меню Run Delphi выбирите Register ActiveX
Server.После этого скопируйте саму DLL в каталог Windows

Установите пакет KDPack.dpk в Delphi

Вот в принципе и все.

Cервер автоматизации OLE для обработки CallBack

Данный сервер я разместил в ActiveX DLL.(данная DLL называется
MICallBack.dll) в виде Automation Object.-а.

Что-бы вам просмотреть методы и свойства данногоAutomation Object.-а.
откройте MICallBack.dpr и в меню Run Delphi выбирите TypeLibrary

Откроется окно - Где я реализовал CallBack методы MapInfo и создал
сервер автоматизации MICallBack. Обратите внимание, что у данного
сервера помимо присутствия интерфейса IMapInfoCallBack присутствует и
еще интерфейс ImapInfoCallBackEvents (он нам нужен будет для
перенаправления событий в компонент и далее в обработчик).

Листинг интерфейсного модуля

    unit Call;
     
    {$WARN SYMBOL_PLATFORM OFF}
     
    interface
     
    uses
      ComObj, ActiveX, Dialogs, AxCtrls, Classes, MICallBack_TLB, StdVcl;
     
    type
      TMapInfoCallBack = class(TAutoObject, IConnectionPointContainer, IMapInfoCallBack)
      private
        { Private declarations }
        FConnectionPoints: TConnectionPoints;
        FConnectionPoint: TConnectionPoint;
        FEvents: IMapInfoCallBackEvents;
        { note: FEvents maintains a *single* event sink. For access to more
        than one event sink, use FConnectionPoint.SinkList, and iterate
        through the list of sinks. }
      public
        procedure Initialize; override;
      protected
        { Protected declarations }
        property ConnectionPoints: TConnectionPoints read FConnectionPoints
        implements IConnectionPointContainer;
        procedure EventSinkChanged(const EventSink: IUnknown); override;
        procedure SetStatusText(const Status: WideString); safecall;
        procedure WindowContentsChanged(ID: Integer); safecall;
        procedure MyEvent(const Info: WideString); safecall;
      end;
     
    var
      FDLLCall: THandle;
     
    implementation
    uses ComServ;
     
    procedure TMapInfoCallBack.EventSinkChanged(const EventSink: IUnknown);
    begin
      FEvents := EventSink as IMapInfoCallBackEvents;
    end;
     
    procedure TMapInfoCallBack.Initialize;
    begin
      inherited Initialize;
      FConnectionPoints := TConnectionPoints.Create(Self);
      if AutoFactory.EventTypeInfo <> nil then
        FConnectionPoint := FConnectionPoints.CreateConnectionPoint(
        AutoFactory.EventIID, ckSingle, EventConnect)
      else
        FConnectionPoint := nil;
    end;
     
     
    procedure TMapInfoCallBack.SetStatusText(const Status: WideString);
    begin
      if FEvents <> nil then
        FEvents.OnChangeStatusText(Status);
    end;
     
    procedure TMapInfoCallBack.WindowContentsChanged(ID: Integer);
    begin
      if FEvents <> nil then
        FEvents.OnChangeWindowContentsChanged(ID);
    end;
     
    procedure TMapInfoCallBack.MyEvent(const Info: WideString);
    begin
      if FEvents <> nil then
        FEvents.OnChangeMyEvent(Info);
    end;
     
    initialization
      TAutoObjectFactory.Create(ComServer, TMapInfoCallBack, Class_MapInfoCallBack,
      ciMultiInstance, tmApartment);
     
    end.

Обратите внимание на присутствие двух предопределенных методов MapInfo
SetStatusText и WindowContentsChanged.

Метод MyEvent я пока зарезервировал для реализации своих сообщений
(более подробно будет изложено в 3 части цикла)

И так что мы видим.

    // если есть обработчик
    if FEvents <> nil then
    begin
      // Отправка сообщения далее - в данном случае в компонент
      FEvents.OnChangeStatusText(Status);

Как заставить MapInfo пересылать CallBack данному OLE серверу и как нам
обрабатывать сообщения в компоненте от OLE сервера.

Итак представляю переработанный компонент -

    unit KDMapInfoServer;
     
    interface
     
    uses
      Stdctrls, Dialogs, ComObj, Controls, Variants, ExtCtrls, Windows, ActiveX,
      Messages, SysUtils, Classes, MICallBack_TLB; // - сгенерировано из DLL
     
    type
      // запись "типа" Variant
      TEvalResult = record
        AsVariant: OLEVariant;
        AsString: string;
        AsInteger: Integer;
        AsFloat: Extended;
        AsBoolean: Boolean;
      end;
     
      type
      // Событие на изменение SetStatusText // генерируется при обратном вызове
      TSetStatusTextEvent = procedure(Sender : TObject; StatusText: WideString) of object;
      // WindowContentsChanged
      TWindowContentsChanged = procedure(Sender : TObject; ID : Integer) of object;
      // Для собственных событий
      TMyEvent = procedure(Sender : TObject; Info : WideString) of object;
     
      TEvent = class(TInterfacedObject,IUnknown,IDispatch)
      private
        FAppConnection : Integer;
        FAppDispatch : IDispatch;
        FAppDispIntfIID : TGUID;
      protected
        function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;
        function _AddRef: Integer; stdcall;
        function _Release: Integer; stdcall;
        function GetTypeInfoCount(out Count: Integer): HResult; stdcall;
        function GetTypeInfo(index, LocaleID: Integer; out TypeInfo): HResult; stdcall;
        function GetIDsOfNames(const IID: TGUID; Names: Pointer; NameCount,
        LocaleID: Integer; DispIDs: Pointer): HResult; stdcall;
        function Invoke(dispid: Integer; const IID: TGUID; LocaleID: Integer;
        Flags: Word; var Params; VarResult, ExcepInfo, ArgErr: Pointer): HResult; stdcall;
      public
        constructor Create( AnAppDispatch : IDispatch; const AnAppDispIntfIID : TGUID);
        destructor Destroy ; override;
      end;
     
     
      TKDMapInfoServer = class(TComponent)
      private
        { Private declarations }
        FOwner : TWinControl; // Владелец
        Responder : Variant;  // Для OLE Disp
     
        FServer : Variant;
        FHandle : THandle;    // Зарезервировано
        FActive : Boolean;    // Запущен/незапущен
        FPanel : TPanel;      // Панель вывода
     
        srv_OLE : OLEVariant;
        srv_disp : IMapInfoCallBackDisp;
        srv_vTable : IMapInfoCallBack;
     
        FEvent : TEvent;
     
        FSetStatusTextEvent : TSetStatusTextEvent; // события компонента
        FWindowContentsChanged : TWindowContentsChanged;
        FMyEvent : TMyEvent;
     
        Connected : Boolean; // Установлено ли соединение
        MapperID : Cardinal; // ИД окна
     
        procedure SetActive(const Value: Boolean);
        procedure SetPanel(const Value: TPanel);
        procedure CreateMapInfoServer;
        procedure DestroyMapInfoServer;
      protected
        { Protected declarations }
      public
        { Public declarations }
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
        // Данная процедура выполеняет метод сервера MapInfo - Do
        procedure ExecuteCommandMapBasic(Command: string; const Args: array of const);
        function Eval(Command: string; const Args: array of const): TEvalResult; virtual;
        procedure WindowMapDef;
        procedure OpenMap(Path : string);
        procedure RepaintWindowMap;
        // Дополнил для генерации события SetStatus при изменении строки состояния
        // в MapInfo
        procedure DoSetStatus(StatusText: WideString);
        // Дополнил.для генерации события WindowContentsChanged при изменении окна
        // в MapInfo
        procedure DoWindowContentsChanged(ID : Integer);
        // Дополнил для генерации собственно события в MapInfo
        procedure DoMyEvent(Info: WideString);
      published
        { Published declarations }
        // Создает соединение с сервером MapInfo
        property Active: Boolean read FActive write SetActive;
        property PanelMap : TPanel read FPanel write SetPanel;
     
        // Событие возникающее при изменении строки состояния MapInfo
        property StatusTextChange : TSetStatusTextEvent read FSetStatusTextEvent
        write FSetStatusTextEvent;
        property WindowContentsChanged : TWindowContentsChanged read FWindowContentsChanged
        write FWindowContentsChanged;
     
        property MyEventChange : TMyEvent read FMyEvent write FMyEvent;
      end;
     
    var
      // О это вообще хитрость - используеться для определения созданного компонента
      // TKDMapInfoServer (см. SetStatusText и Create
      KDMapInfoServ : TKDMapInfoServer;
     
    procedure register;
     
    implementation
     
    // Вот тут то и хитрость если сервер создан то тогда и вызываем SetStatus
    //// IF KDMapInfoServ <> nil Then
    /// KDMapInfoServ.SetStatus(StatusText);
     
    procedure register;
    begin
      RegisterComponents('Kuzan', [TKDMapInfoServer]);
    end;
     
    { TKDMapInfoServer }
     
    constructor TKDMapInfoServer.Create(AOwner: TComponent);
    begin
      inherited Create(AOwner);
      FOwner := AOwner as TWinControl;
     
      KDMapInfoServ := Self; // **** Вот тут и указываеться созданный компонент
      // TKDMapInfoServer
      FHandle := 0;
      FActive := False;
      Connected := False;
    end;
     
    destructor TKDMapInfoServer.Destroy;
    begin
      DestroyMapInfoServer;
      inherited Destroy;
    end;
     
    procedure TKDMapInfoServer.CreateMapInfoServer;
    begin
      try
        FServer := CreateOleObject('MapInfo.Application');
      except
        FServer := Unassigned;
      end;
      // Скрываем панели управления MapInfo
      ExecuteCommandMapBasic('Alter ButtonPad ID 4 ToolbarPosition (0, 0) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 3 ToolbarPosition (0, 2) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 1 ToolbarPosition (1, 0) Show Fixed', []);
      ExecuteCommandMapBasic('Alter ButtonPad ID 2 ToolbarPosition (1, 1) Show Fixed', []);
      ExecuteCommandMapBasic('Close All', []);
      ExecuteCommandMapBasic('Set ProgressBars Off', []);
      ExecuteCommandMapBasic('Set Application Window %D', [FOwner.Handle]);
      ExecuteCommandMapBasic('Set Window Info Parent %D', [FOwner.Handle]);
     
      FServer.Application.Visible := True;
      if IsIconic(FOwner.Handle)then ShowWindow(FOwner.Handle, SW_Restore);
      BringWindowToTop(FOwner.Handle);
     
      srv_ole := CreateOleObject('MICallBack.MapInfoCallBack') as IDispatch;
      srv_vtable := CoMapInfoCallBack.Create;
      srv_disp := CreateComObject(CLASS_MapInfoCallBack) as IMapInfoCallBackDisp;
      FEvent := TEvent.Create(srv_disp,IMapInfoCallBackEvents);
     
      // Указываем MapInfo что нужно передовать обратные вызовы нашему OLE
      // а тм далее по цепочке (см.начало)
      FServer.SetCallBack(srv_disp);
    end;
     
    procedure TKDMapInfoServer.DestroyMapInfoServer;
    begin
      ExecuteCommandMapBasic('End MapInfo', []);
      FServer := Unassigned;
    end;
     
    procedure TKDMapInfoServer.ExecuteCommandMapBasic(Command: string;
    const Args: array of const);
    begin
      if Connected then
        try
          FServer.do(Format(Command, Args));
        except
          on E: Exception do MessageBox(FOwner.Handle,
          PChar(Format('Ошибка выполнения () - %S', [E.message])),
          'Warning', MB_ICONINFORMATION or MB_OK);
        end;
    end;
     
    function TKDMapInfoServer.Eval(Command: string;
    const Args: array of const): TEvalResult;
     
      function IsInt(Str : string): Boolean;
      var
        Pos : Integer;
      begin
        Result := True;
        for Pos := 1 to Length(Trim(Str)) do
        begin
          if (Str[Pos] <> '0') and (Str[Pos] <> '1') and
          (Str[Pos] <> '2') and (Str[Pos] <> '3') and
          (Str[Pos] <> '4') and (Str[Pos] <> '5') and
          (Str[Pos] <> '6') and (Str[Pos] <> '7') and
          (Str[Pos] <> '8') and (Str[Pos] <> '9') and
          (Str[Pos] <> '.') then
          begin
            Result := False;
            Exit;
          end;
        end;
      end;
     
    var
      ds_save: Char;
    begin
      if Connected then
      begin
        Result.AsVariant := FServer.Eval(Format(Command, Args));
        Result.AsString := Result.AsVariant;
        Result.AsBoolean := (Result.AsString = 'T') or (Result.AsString = 't');
     
        if IsInt(Result.AsVariant) then
        begin
          try
            ds_save := DecimalSeparator;
            try
              DecimalSeparator := '.';
              Result.AsFloat := StrToFloat(Result.AsString);
            finally
              DecimalSeparator := ds_save;
            end;
          except
            Result.AsFloat := 0.00;
          end;
     
          try
            Result.AsInteger := Trunc(Result.AsFloat);
          except
            Result.AsInteger := 0;
          end;
        end
        else
        begin
          Result.AsInteger := 0;
          Result.AsFloat := 0.00;
        end;
      end;
    end;
     
    procedure TKDMapInfoServer.SetActive(const Value: Boolean);
    begin
      FActive := Value;
     
      if FActive then
      begin
        CreateMapInfoServer;
        WindowMapDef;
        Connected := True;
      end
      else
      begin
        if Connected then
        begin
          DestroyMapInfoServer;
          Connected := False;
        end;
      end;
    end;
     
    procedure TKDMapInfoServer.SetPanel(const Value: TPanel);
    begin
      FPanel := Value;
    end;
     
    procedure TKDMapInfoServer.WindowMapDef;
    begin
      ExecuteCommandMapBasic('Set Next Document Parent %D Style 1', [FPanel.Handle]);
      RepaintWindowMap;
    end;
     
    procedure TKDMapInfoServer.OpenMap(Path: string);
    begin
      ExecuteCommandMapBasic('Run Application "%S"', [Path]);
      MapperID := Eval('WindowInfo(FrontWindow(),%D)',[12]).AsInteger;
      RepaintWindowMap;
    end;
     
    procedure TKDMapInfoServer.DoSetStatus(StatusText: WideString);
    begin
      if Assigned(FSetStatusTextEvent) then
        FSetStatusTextEvent(Self,StatusText);
    end;
     
    procedure TKDMapInfoServer.DoWindowContentsChanged(ID: Integer);
    begin
      if Assigned(FWindowContentsChanged) then
        FWindowContentsChanged(Self,ID);
    end;
     
    procedure TKDMapInfoServer.DoMyEvent(Info: WideString);
    begin
      if Assigned(FWindowContentsChanged) then
        FMyEvent(Self,Info);
    end;
     
    procedure TKDMapInfoServer.RepaintWindowMap;
    begin
      with PanelMap do
        MoveWindow(MapperID, 0, 0, FPanel.ClientWidth, FPanel.ClientHeight, True);
    end;
     
    { TEvent }
     
    function TEvent._AddRef: Integer;
    begin
      Result := 2; // Заглушка
    end;
     
    function TEvent._Release: Integer;
    begin
      Result := 1; // Заглушка
    end;
     
    constructor TEvent.Create(AnAppDispatch: IDispatch;
    const AnAppDispIntfIID: TGUID);
    begin
      inherited Create;
      FAppDispatch := AnAppDispatch;
      FAppDispIntfIID := AnAppDispIntfIID;
      // Передадим серверу
      InterfaceConnect(FAppDispatch,FAppDispIntfIID,self,FAppConnection);
    end;
     
    destructor TEvent.Destroy;
    begin
      InterfaceDisConnect(FAppDispatch,FAppDispIntfIID,FAppConnection);
      inherited;
    end;
     
    function TEvent.GetIDsOfNames(const IID: TGUID; Names: Pointer; NameCount,
    LocaleID: Integer; DispIDs: Pointer): HResult;
    begin
      // Заглушка не реализовано
      Result := E_NOTIMPL;
    end;
     
    function TEvent.GetTypeInfo(index, LocaleID: Integer;
    out TypeInfo): HResult;
    begin
      // Заглушка не реализовано
      Result := E_NOTIMPL;
    end;
     
    function TEvent.GetTypeInfoCount(out Count: Integer): HResult;
    begin
      // Заглушка не реализовано
      Count := 0;
      Result := S_OK;
    end;
     
    function TEvent.Invoke(dispid: Integer; const IID: TGUID;
    LocaleID: Integer; Flags: Word; var Params; VarResult, ExcepInfo,
    ArgErr: Pointer): HResult;
    var
      Info,Status : string;
      IDWin : Integer;
    begin
      case dispid of
        1 :
        begin
          Status := TDispParams(Params).rgvarg^[0].bstrval;
          if KDMapInfoServ <> nil then
            KDMapInfoServ.DoSetStatus(Status);
        end;
        2 :
        begin
          IDWin := TDispParams(Params).rgvarg^[0].bval;
          if KDMapInfoServ <> nil then
            KDMapInfoServ.DoWindowContentsChanged(IDWin);
        end;
        3 :
        begin
          Info := TDispParams(Params).rgvarg^[0].bstrval;
          if KDMapInfoServ <> nil then
            KDMapInfoServ.DoMyEvent(Info);
        end;
      end;
      Result := S_OK;
    end;
     
    function TEvent.QueryInterface(const IID: TGUID; out Obj): HResult;
    begin
      Result := E_NOINTERFACE;
      if GetInterface(IID,Obj) then
        Result := S_OK;
      if IsEqualGUID(IID,FAppDispIntfIID) and GetInterface(IDispatch,Obj) then
        Result := S_OK;
    end;
     
    end.

И так что добавилось - Метод CreateMapInfoServer;

      // Создаем наш сервер OLE
      srv_ole := CreateOleObject('MICallBack.MapInfoCallBack') as IDispatch;
      srv_vtable := CoMapInfoCallBack.Create;
      // Получаем Idispatch созданного сервера
      srv_disp := CreateComObject(CLASS_MapInfoCallBack) as IMapInfoCallBackDisp;
      FEvent := TEvent.Create(srv_disp,IMapInfoCallBackEvents);
      // Указываем MapInfo что нужно передовать обратные вызовы нашему OLE серверу
      // а там далее по цепочке (см.начало)
      FServer.SetCallBack(srv_disp);
    end;

Здесь мы столкнулись с еще одним методом MapInfo помимо рассмотренных
ранее методов Do и Eval - Метод SetCallBack(IDispatch). Описание -
Регистрирует объект механизма-управления объектами OLE (OLE Automation)
как получатель уведомлений, генерируемых программой MapInfo. Только одна
функция уведомления может быть зарегистрирована в каждый данный момент.
Параметр интерфейс Idispatch объекта OLE (COM)

Реализация FServer.SetCallBack(srv\_disp); - данным кодом мы заставили
MapInfo уведомлять наш OLE сервер.

Хорошо, скажете вы, ну заставили но он то уведомляет сервер OLE а не
нашу программу, для этого я ввел следующий код (прим. Реализацию
использования интерфейса событий OLE сервера я подробно расписывать не
стану - для этого читайте в книгах главы по COM)

Я сделал так: ввел класс отвечающий за принятие событий от COM(OLE)
объекта

    TEvent = class(TInterfacedObject,IUnknown,IDispatch)
    private
      FAppConnection : Integer;
      FAppDispatch : IDispatch;
      FAppDispIntfIID : TGUID;
    protected
      function QueryInterface(const IID: TGUID; out Obj): HResult; stdcall;
      function _AddRef: Integer; stdcall;
      function _Release: Integer; stdcall;
      function GetTypeInfoCount(out Count: Integer): HResult; stdcall;
      function GetTypeInfo(index, LocaleID: Integer; out TypeInfo): HResult; stdcall;
      function GetIDsOfNames(const IID: TGUID; Names: Pointer;
      NameCount, LocaleID: Integer; DispIDs: Pointer): HResult; stdcall;
      function Invoke(dispid: Integer; const IID: TGUID; LocaleID: Integer;
      Flags: Word; var Params; VarResult, ExcepInfo, ArgErr: Pointer): HResult; stdcall;
    public
      constructor Create( AnAppDispatch : IDispatch;
      const AnAppDispIntfIID : TGUID);
      destructor Destroy ; override;
    end;

создание этого класса в компоненте реализовано так

FEvent := TEvent.Create(srv\_disp,IMapInfoCallBackEvents);

В методе Invoke и происходит прием и получение сообщений и пересылка их
в обработчик моего компонента.

Еще раз на последующие вопросы касательно COM (OLE) серверов отвечу:
данная тема выходит за рамки данной статьи - советую почитать книгу
Александроского А.Д - Delphi 5 разработка корпоративных приложений.

Напоследок --- модуль MICallBack\_TLB.pas импортирован из DLL командой
меню DELPHI Import Type Libray.

Примечание:

при импорте данный сервер инсталировать не нужно, нет смысла он нам
нужен только для приема сообщений из MapInfo.



