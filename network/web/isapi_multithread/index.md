---
Title: Понимание многопоточности в VCL для веб-серверных ISAPI-расширений
Author: Andrew Kachanov (www.arisesoft.com)
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Понимание многопоточности в VCL для веб-серверных ISAPI-расширений
==================================================================

В среде Delphi можно создавать высокоэффективные веб-серверные
ISAPI-расширения на основе технологии WebBroker. Создайте проект с
помощью мастера (New -\> Web Server Application - ISAPI DLL).

Прилагаемая справочная документация, а также демонстрационный пример
"$(DELPHI)\\Demos\\Webserv" позволяют достаточно быстро освоиться в
приемах написания веб-серверных ISAPI-расширений. На выходе у вас
получится обычная DLL (далее по тексту - библиотека).

Сложность заключается в том, что веб-сервер (для ускорения обработки
поступающих запросов) вызывает нашу библиотеку в много-поточном режиме.
В результате чего на разработчика ложиться ответственность за написание
поточно-безопасного кода. Не беспокойтесь, ребята из Borland постарались
упростить вам жизнь настолько, насколько это возможно. Когда я понял
смысл "обертки" TWebApplication и наследника TISAPIApplication, то был
восхищен, и вдохновлен поделиться этими знаниями с вами!

Согласно спецификации ISAPI-расширений, созданная библиотека имеет всего
три экспортируемые функции: GetExtensionVersion, HttpExtensionProc,
TerminateExtension. Нас интересует только HttpExtensionProc, через
которую выполняется вся работа: получение запросов с веб-сервера
(Request), обработка и обратная отправка результата (Response).

Итак, рассмотрим весь путь прохождения данных. Запрос веб-сервера
поступает через экспортируемую библиотекой функцию HttpExtensionProc в
TISAPIApplication через инкапсулированный метод с одноименным названием
(объект Application, как и в любом VCL-приложении другого вида,
присутствует всегда: создается при инициализации и разрушается при
завершении приложения, однако в данном случае имеет тип
TISAPIApplication):

    function TISAPIApplication.HttpExtensionProc(var ECB: TEXTENSION_CONTROL_BLOCK): DWORD;
    var
      HTTPRequest: TISAPIRequest; 
      HTTPResponse: TISAPIResponse;
      { ^ локально объявленные переменные запроса и ответа }
    begin
      try
        HTTPRequest := NewRequest(ECB); 
        { ^ инициализация переменной запроса по структуре ECB, полученной от веб-сервера }
        try
          HTTPResponse := NewResponse(HTTPRequest);
          { ^ инициализация переменной ответа }
          try
            if HandleRequest(HTTPRequest, HTTPResponse) then
            { ^ обработка переходит к TWebApplication.HandleRequest }
              Result := HSE_STATUS_SUCCESS
            else Result := HSE_STATUS_ERROR;
          finally
            HTTPResponse.Free;
          end;
        finally
          HTTPRequest.Free;
        end;
      except
        HandleServerException(Exception(ExceptObject), ECB);
        Result := HSE_STATUS_ERROR;
      end;
    end;

Из приведенного кода видно, что переменные HTTPRequest и HTTPResponse
объявлены локально, и объекты соответствующих типов создаются для
каждого поступающего запроса веб-сервера. После инициализации этих
переменных обработка переходит к TWebApplication.HandleRequest:

    function TWebApplication.HandleRequest(Request: TWebRequest;
      Response: TWebResponse): Boolean;
    var
      DataModule: TDataModule;
      Dispatcher: TCustomWebDispatcher;
      I: Integer;
    begin
      Result := False;
      DataModule := ActivateWebModule; 
      { ^ назначает объект, который не используется другими потоками }
      if DataModule <> nil then
      try
        if DataModule is TCustomWebDispatcher then
          Dispatcher := TCustomWebDispatcher(DataModule)
        else with DataModule do
        begin
          Dispatcher := nil;
          for I := 0 to ComponentCount - 1 do
          begin
            if Components[I] is TCustomWebDispatcher then
            begin
              Dispatcher := TCustomWebDispatcher(Components[I]);
              Break;
            end;
          end;
        end;
        if Dispatcher <> nil then
        begin
          Result := TWebDispatcherAccess(Dispatcher).DispatchAction(Request, Response);
          { ^ обработка переходит к TWebDispatcher.DispatchAction }
          if Result and not Response.Sent then
            Response.SendResponse;
            { ^ отправка ответа веб-серверу }
        end else raise Exception.CreateRes(@sNoDispatcherComponent);
      finally
        DeactivateWebModule(DataModule);
        { ^ переводит в список неиспользуемых объектов - FInactiveWebModules }
      end;
    end;

Тут следующая хитрость: локально объявленная переменная DataModule
получает ссылку на объект от метода TWebApplication.ActivateWebModule.
Для каждого потока предоставляется неиспользуемый в настоящее время
другими потоками объект типа TDataModule, для чего выполняется
перемещение этих объектов между списками FInactiveWebModules и
FActiveWebModules. Если список FInactiveWebModules исчерпан, то
создается новый экземпляр объекта типа TDataModule. В результате этих
манипуляций для каждого потока используется собственный экземпляр
объекта типа TDataModule, и разработчик может быть уверен в
поточно-безопасном объявлении полей данных своего объекта TWebModule! Но
это еще не все.

Локально объявленные в TISAPIApplication.HttpExtensionProc переменные
HTTPRequest и HTTPResponse, о которых говорилось выше, переданы методу
TWebApplication.HandleRequest в качестве параметров Request и Response,
который в свою очередь передает их методу
TCustomWebDispatcher.DispatchAction:

    function TCustomWebDispatcher.DispatchAction(Request: TWebRequest;
      Response: TWebResponse): Boolean;
    var
      I: Integer;
      Action, Default: TWebActionItem;
      Dispatch: IWebDispatch;
    begin
      FRequest := Request;
      FResponse := Response;
      {...}
    end;

Тут выполняется присваивание переменных Request и Response полям объекта
TWebModule (как наследнику TCustomWebDispatcher). А нам уже известно,
что экземпляр объекта TWebModule у каждого потока - собственный. Теперь
посмотрим правде в глаза: у каждого запроса веб-сервера есть собственные
экземпляры объектов TRequest и TResponse в полях TWebModule.Request и
TWebModule.Response; и они поточно-безопасны.

Далее путь лежит через метод TWebActionItem.DispatchAction, который
вызывается в TCustomWebDispatcher.DispatchAction. Тут может вступать в
действие ваш код обработки запроса, после чего подготовленному ответу
предстоит обратная дорога.

Как видно из приведенного выше фрагмента кода
TWebApplication.HandleRequest - DataModule передается в качестве
параметра методу TWebApplication.DeactivateWebModule, в котором может
быть переведен в список FInactiveWebModules, или вовсе разрушен (если
выключено свойство CacheConnections - этим не стоит пользоваться без
необходимости, так как существенно снижается производительность
обработки запросов). После чего обработка возвращается к
TISAPIApplication.HttpExtensionProc и ответ передается веб-серверу
вызовом Response.SendResponse.

Отдельно следует отметить. Мне несколько раз попадались на глаза
рекомендации устанавливать глобальную переменную IsMultiThread к True в
dpr-файл проекта - этого делать не нужно, т.к. в конструкторе
TWebApplication эта работа уже выполняется!

Если вы используете доступ к BDE посредством наследников TBDEDataSet
(TTable, TQuery, TStoredProc) то все что вам нужно сделать для
обеспечения поточно-безопасности, это присвоить в конструкторе
TWebModule: Session.AutoSessionName := True (подробнее смотри в
справочной документации: "Managing multiple sessions").

Реализация инкапсуляции WinSock в компонентах TClientSocket и
TServerSocket, которые вам могут потребоваться, так же
поточно-безопасна.

Конечно, если используется файловый ввод-вывод, а так же прямые вызовы
WinSock, то тогда все же нужно выполнять много-поточную защиту
самостоятельно и вам все же придется прочитать раздел документации
"Programming with Delphi - Using threads". :-)

**Замечание:**
изложенное выше относится к Delphi 5.

