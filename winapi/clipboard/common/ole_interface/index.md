---
Title: Использование интерфейса OLE
Date: 01.01.2007
---


Использование интерфейса OLE
============================

Значение, которое придается сегодня внедрению интерфейса OLE, трудно
переоценить. Фирма Microsoft извещает о том, что на получение логотипа
"Windows 95 Compatible" будут сертифицированы только те приложения,
которые имеют средства работы с OLE.

Разъяснять суть механизмов OLE с точки зрения пользователя здесь не
имеет смысла; кратко опишем их с точки зрения программиста.

В создаваемый вами документ могут быть добавлены данные, созданные
другим приложением: формулы, таблицы, графические файлы и т. п. Такие
данные, рассматриваемые вместе с приложением, которое умеет их
обрабатывать, будем называть объектом OLE, а такое приложение -
сервером OLE. Дословный перевод аббревиатуры OLE означает "внедренные и
связанные объекты". Разница между внедрением и связыванием состоит в
том, где и как размещаются данные, представляющие объект. Внедренный
объект хранится в самом документе и является его составной частью. Для
связанного объекта хранится только ссылка на данные, которые могут
находиться в другом документе или в другой части этого документа.

Каждый
из способов имеет свои достоинства и недостатки. Наличие внедренных
объектов увеличивает размер документа, зато он обладает переносимостью,
и несколько пользователей могут работать с ним одновременно. Когда
объект связан, то он занимает гораздо меньше места, но такой документ
нужно переносить вместе с данными, на которые он ссылается. Каждое
изменение данных влечет за собой изменение во всех объектах, которые
ссылаются на эти данные.

Возможности реализации OLE в рассматриваемой версии Delphi ограничены
только поддержкой приема объектов. Тем, кто хочет создавать серверы OLE,
придется подождать выпуска 32-разрядной версии Delphi, где возможности
этого программного интерфейса будут реализованы в большей мере. В VCL
имеется специальный компонент-контейнер, в который можно помещать данные
OLE. Вставлять объекты в контейнер можно как на стадии разработки
приложения, так и на стадии его выполнения. Здесь будет рассмотрен
только последний вариант.

**Компонент TOLEContainer**

    TObject=>TPersistent=>TComponent=>TControl=>TWinControl=>
    TCustomControl=>TOLEContainer
    Модуль TOCTRL
    Страница Палитры компонентов System

Загрузить объект OLE в контейнер можно тремя путями:

- созданием нового объекта или связыванием с уже существующим через
вызов диалога InsertOLEObjectDIg;

- "перетаскиванием" объекта из сервера OLE в форму, содержащую
контейнер, с помощью Drag&Drop;

- помещением объекта из буфера обмена (посредством вызова диалога
PasteSpecialDIg).

Общим является то, что во всех трех способах формируется поначалу
определенная структура данных (типа BOLEInitInfo). Она является
"визитной карточкой" сервера OLE и его данных. Как только
значение указателя
на нее присваивается свойству контейнера

    property PInitInfo: Pointer;

происходит процесс внедрения или связывания объекта. При этом может
произойти активизация сервера. Несколько примеров использования этого
свойства рассмотрено ниже.

Сразу после присвоения значения свойству контейнера PInitInfo
потребность в созданной структуре отпадает. Ее можно уничтожить при
помощи процедуры:

    procedure ReleaseOLEInitInfо(PInitInfo: Pointer);

Контейнер, однако, продолжает хранить содержащуюся в этой структуре
информацию. Для доступа к ней нужно воспользоваться свойством:

    property Initlnfo: BOLEInitInfo;

Тип BOLEInitInfo не документирован Borland и его описание здесь не
приводится.

Ниже будут подробнее рассмотрены все три варианта загрузки объекта OLE в
контейнер.

**Создание нового объекта**

Этот способ применяется, когда вы хотите добавить к приложению данные из
уже существующего файла, снабдив их возможностями одного из серверов
OLE, который "умеет" с этими данными работать. Данные можно внедрить
или связать. Можно также внедрить новый (пустой) объект, в этом случае
сразу будет вызван сервер. В основе этого способа лежит вызов функции:

    function InsertOLEObjectDlg(Form: TForm; HelpContext: THelpContext;
             var PInitInfo: Pointer): Boolean;

Она инициализирует диалог, позволяющий создать новый объект OLE. В
случае успешного окончания диалога создается структура типа
BOLEInitInfo. Пример этого достаточно прост:

    procedure TForm1.BitBtn1Click(Sender: Tobject);
      var Thelnfo : Pointer;
    begin
      if InsertOLEObjectDIg(Self, 0, Thelnfo) then
        begin
          OLEContainer1.PInitInfo := Thelnfo;
          ReleaseOLEInitInfо(Thelnfo);
        end;
    end;


**Регистрация форматов**

Два других способа получения данных OLE - через буфер обмена или посредством "перетаскивания" -
требуют выполнения предварительных операций.

Для того чтобы форма могла играть роль получателя данных, нужно сделать
следующее:

1. Объявить ее как приемник объектов OLE.

2. Связать с ней список форматов буфера обмена, получение которых будет
поддерживаться.

Обе этих задачи решает вызов функции:

    procedure RegisterFormAsOLEDropTarget(Form: TForm;
              const Fmts: array of BOLEFormat);

Здесь Form - регистрируемая форма, Fmts - массив форматов. Каждый
элемент массива форматов является записью типа:

    BOLEFormat = Record
        fmtId: Word;
        fmtName: array[0..31] of char;
        fmtResultName: array[0..31] of char;
        fmtMedium: BOLEMedium ;
        fmtIsLinkable: Bool;
    end;

Поля записи имеют следующее назначение:

fmtid - идентификатор формата буфера обмена. Это может быть как
стандартный формат (CF\_TEXT, CF\_BITMAP и др.), так и специальный
формат для объектов OLE. В этом случае он должен быть зарегистрирован
при помощи функции RegisterClipboardFormat (см. пример ниже);

fmtName - имя, которое появится в списке форматов диалога
PasteSpecialDIg;

fmtResultName - имя формата, которое появится в комментариях внутри
этого диалога. Например, если значение fmtResultName равно "Bitmap",
то пользователь получит примерно следующий комментарий: "Inserts the
contents of the Clipboard into your document as Bitmap";

fmtIsLinkable - показывает, могут ли данные в этом формате играть роль
связанных объектов.

fmtMedium - константа, идентифицирующая тип данных в буфере обмена.
Связана со значением поля fmtid следующим образом:

|              |
---------------|--------------------------
BOLEMEDSTREAM  | Связанные объекты OLE.
BOLEMEDSTORAGE | Внедренные объекты OLE.
BOLEMEDMFPICT  | Метафайлы (CF.METAFILEPICT).
BOLEMEDGDI     | Графические данные (CF_BITMAP, CF_SYLK, CF_DIF, CF_TIFF, CF_DIB, CF_PALETTE, CF_PENDATA, CF_RIFF, CF_WAVE).
BOLEMEDHGLOBAL | Все прочие данные.

Специально для вычисления значения поля fmtMedium по формату данных
предусмотрена функция:

    function BOLEMediumCalc(fmtId: Word): BOLEMedium;

Заполнить требуемый массив можно, например, так:

    Var
      FEmbedClipFmt, FLinkClipFmt: Word;
      Pints: array[0..2] of BOLEFormat;

    FEmbedClipFmt := RegisterClipboardFormat('Embedded Obj ect');
    FLinkClipEmt := RegisterClipboardFormat('Link Source');
    Fmts[0].fmtId := FEmbedClipFmt;
    Fmts[0].fmtMedium := BOLEMediumCalc(FEmbedClipFmt);
    Fmts[0].fmtIsLinkable := False;
    StrPCopy (Fmts[0].fmtName, '%s');
    StrPCopy (Fmts[0].fmtResultName, '%s');
    Fmts[l].fmtId := PLinkClipFmt;
    Fmts[1].fmtMedium := BOLEMediumCalc(FLinkClipFmt);
    Fmts[1].fmtIsLinkable := True;
    StrPCopy (Fmts[l].fmtName, '%s');
    StrPCopy (Fmts[1].fmtResultName, '%s');
    Fmts[2].fmtId := CF_BITMAP;
    Fmts[2].frntMedium := BOLEMediumCalc(CF_BITMAP);
    Fmts[2].fmtIsLinkable := False;
    StrPCopy (Fmts[2].fmtName, 'Bitmap');
    StrPCopy (Fmts[2].fmtResultName, 'Device-dependent Bitmap');
    RegisterFormAsOLEDropTarget(Self, Fmts) ;

Для упрощения создания элемента списка форматов есть функция:

    function OLEFormat(AFmtId: Word; AName, AResultName: String;
             AIsLinkable: Bool): BOLEFormat;

Она заполняет структуру типа BOLEFormat переданными ей параметрами и
возвращает указатель на нее. Приведенный выше фрагмент кода можно
преобразовать так:

    FEmbedClipFmt := RegisterClipboardFormat ('Embedded Object');
    FLinkClipFmt := RegisterClipboardFormat ('Link Source');
    RegisterFormAsOLEDropTarget (Self,
      [OLEFormat (PEmbedClipFmt, '%s', '%s', FALSE),
       OLEFormat (PLinkClipFmt, '%s', '%s', TRUE)] ;

Для тех случаев, когда регистрацию формы и установку списка возможных
форматов нужно произвести раздельно, предусмотрены процедуры:

    procedure RegisterFormAsOLEDropTgt(Form: TForm);
    procedure SetFormOLEDropFormats(Form: TForm; const Fmts: array of BOLEFormat);

В паре они делают то же, что и RegisterFormAsOLEDropTarget. Для очистки
списка форматов можно воспользоваться процедурой:

    procedure ClearFormOLEDropFormats(Form: TForm);

**"Перетаскивание" объектов OLE**

Форма может принимать данные, направляемые серверами OLE при помощи
интерфейса Drag&Drop. Обратите внимание, что этот случай представляет
собой исключение из общего правила, разрешающего "перетаскивать"
объекты только в пределах одной формы.

Возможность работы Drag&Drop с OLE реализована, например, в приложениях
из пакета Microsoft Office, однако, далеко не все серверы OLE 2.0 ее
поддерживают.

Для получения данных путем "перетаскивания" нужно, во-первых,
зарегистрировать форму при помощи ReisterFormAsOLEDropTarget. Во-вторых,
для формы нужно создать обработчик события OnDragDrop (будьте
внимательны: именно для формы, а не для контейнера!). При
"перетаскивании" данных OLE этот обработчик получает в параметре
Source объект специального класса TOLEDropNotify:

    TOLEDropNotify = class(TObject)
      public
      procedure Setlnfo(Form: TForm; Rect: TRect; Info: BOLEInitInfo);
      property DropForm: TForm;
      property DropRect: TRect;
      property DataFormat: Word;
      property DataHandle: THandle;
      property PInitInfo: Pointer;
    end;

Его свойства приведены в таблице:

|                                 |
----------------------------------|-----------------
@ property DropForm: TForm;       | Определяет форму, в которую перемещены данные. Значение обычно равно Self.
{Ro} property DropRect: TRect;    | Определяет прямоугольник, в который производилось перемещение. Обычно стягивается в точку, где была отпущена кнопка мыши.
{Ro} property DataFormat: Word;   | Определяет формат перемещенных данных. {Ro} property DataHandle: THandle;   Содержит дескриптор перемещенных данных.
{Ro} property pinitinfo: pointer; | Содержит указатель на структуру для инициализации.

Сброшенные данные могут как представлять объект OLE, так и иметь один из
обычных форматов. Логическая взаимосвязь между тремя последними
свойствами такая:

- если получен объект OLE, то в параметре DataFormat возвращается
значение -1. В этом случает дескриптор DataHandle недействителен, смысл
имеет только свойство PInitInfo;

- если получены данные в одном из обычных форматов, то свойство
DataFormat содержит идентификатор этого формата, DataHandle -
дескриптор соответствующих данных, a PInitInfo имеет значение nil.

Один из примеров обработчиков события OnDragDrop выглядит так:

    procedure TForm1.OLEContainer1DragDrop(Sender, Source: TObject; X, Y: Integer);
    begin
      if Source is TOLEDropNotify then
      with Source as TOLEDropNotify do
      begin
        if (DataFormat = CF_TEXT) then
          begin
            Label1.Caption := StrPas(GlobalLock(DataHandle));
            GlobalUnlock(DataHandle);
            GlobalFree(DataHandle) ;
          end
        else if DataFormat = Word(-1) then
          OLEContainerl.PInitInfo :=TOLEDropNotify(Source).PInitInfo;
      end;
    end;

Обратите внимание, что в этом примере полученную структуру PInitInfo не
нужно освобождать при помощи ReleaseOLEInitInfo.

**Вставка объектов OLE из буфера обмена**

Вставку реализует специальный диалог, вызываемый функцией:

    function PasteSpecialDlg(Form: TForm; const Fmts: array of BOLEFormat;
             HelpContext: THelpContext; var Format: Word; var Handle: THandle;
             var PInitInfo: Pointer ): Boolean;

Параметры этой функции означают следующее:

Form - принимающая данные форма;

Fmts - список поддерживаемых форматов данных;

HelpContext - контекст системы помощи для диалога (в файле с
расширением .HLP, связанном с приложением). Если этот параметр имеет
значение 0, то кнопка Help будет отсутствовать;

Функция присваивает значения трем параметрам:

Format - выбранный пользователем формат (из доступных в диалоге);

Handle - дескриптор данных;

PInitInfo - указатель на структуру данных инициализации.

Функция
возвращает True, если пользователь нажал в диалоге кнопку ОК или клавишу
\<Enter\>.

Логическая взаимосвязь между значениями Format, Handle и
PInitInfo такая:

- если пользователь решил присоединить или встроить имеющийся в буфере
обмена объект, то в параметре Format возвращается значение -1. В этом
случает дескриптор недействителен, а смысл имеет только параметр
PTnitTnfo:

- если вставляются имеющиеся в буфере обмена данные одного из обычных
форматов, то параметр Format содержит его идентификатор, Handle -
дескриптор соответствующих данных, a PInitInfo равен nil.

Перед тем, как вызывать PasteSpecialDlg, нужно убедиться в
целесообразности этого, вызвав функцию:

    function PasteSpecialEnabled(Form: TForm;
             const Pints: array of BOLEFormat) : Boolean;

Она проверяет, есть ли в буфере обмена данные поддерживаемых формой Form
форматов и, если это так, возвращает True. Если вы вызвали
PasteSpecialDIg, не произведя проверку с помощью этой функции, то диалог
появится, но в случае отсутствия данных не произведет никаких действий.

Посмотрите на приведенный ниже пример использования вызова диалога
PasteSpecialDIg:

    procedure TForm1.PasteItemClick(Sender: TObject);
    var
      DataFormat: Word;
      DataHandle: THandle;
      TheInfo: Pointer;
    begin
      if PasteSpecialEnabled(Self, Fmts) then
        if PasteSpecialDlg(Form1, Fmts, 0, DataFormat, DataHandle, Thelnfo) then
          if DataFormat = Word(-l) then
          begin
            OLEContainerl.PInitInfo := Thelnfo;
            ReleaseOLEInitInfo(Thelnfo) ;
          end
          else if DataFormat in [CF_BITMAP, CF_METAFILEPICT] then
            Image1.Picture.Assign(Clipboard) ;
    end;

Если вы хотите ограничиться вставкой из буфера обмена только объектов
OLE, возможно значительно упростить описанный выше механизм. Функции

    function PasteSpecialOLEDlg(Form: TForm; HelpContext: THelpContext;
                   var PInitInfo: Pointer): Boolean;

    function PasteSpecialOLEEnabled(Form: TForm): Boolean;

являются полными аналогами PasteSpecialDIg и PasteSpecialEnabled - но
только в части, касающейся OLE. Список зарегистрированных форматов
по-прежнему необходим, но в нем будут играть роль только форматы для
связанного и внедренного объектов.

Пример вызова диалога PasteSpecialOLEDlg короче предыдущего:

    procedure TForm1.PasteItemClick(Sender: TObject);
    var
      TheInfo: Pointer;
    begin
      if PasteSpecialOLEEnabled(Self, Fmts) then
        if PasteSpecialOLEDlg(Form1, 0, TheInfo) then
        begin
          OLEContainerl.PInitInfo := TheInfo;
          ReleaseOLEInitInfo(TheInfo) ;
        end;
    end;


С помощью переключателей (радиокнопок), имеющихся в диалогах вставки,
пользователь может определить, хочет ли он встроить или связать объект с
вашим приложением.

Если в контейнере содержится связанный объект, то его состояние можно
проверить и изменить, вызвав соответствующий диалог из функции:

    procedure LinksDlg(Form: TForm; HelpContext: THelpContext);

Если связанного объекта нет, то вызов LinksDlg не имеет смысла.
Убедитесь в целесообразности при помощи функции:

    function LinksDlgEnabled(Form: TForm): Boolean;

**Свойства контейнера**

Проверить наличие объекта OLE в контейнере позволяет метод:

    function OLEObjAllocated: Boolean;

Свойство

    {Рb} property AutoSize: Boolean;

означает, что контейнер автоматически принимает размер помещенного в
него объекта OLE. Играет роль оно только в момент внедрения
(связывания).

После того, как в контейнер загружен объект OLE, его можно
идентифицировать при помощи свойств:

    {Рb} property ObjClass: String;
    {Рb} property ObjDoc: Strings;
    {Рb} property ObjItem: String;

Свойство ObjClass представляет собой имя (класс) объектов, поддерживаемых данным сервером OLE, например "Документ Microsoft Word 6.0", "Visio 3.0 Drawing" или "Paintbrush Picture".

Свойства ObjDoc и ObjItem применяются только для связанных объектов. Первое свойство представляет собой имя документа (зачастую имя файла), а второе ? имя его части (если контейнер связан только с частью документа, например, с фрагментом изображения). Вы можете увидеть значения ObjDoc и ObjItem в диалоге LinksDlg: они разделяются восклицательным знаком и в паре составляют имя связи.

Нужно отметить, что правило присвоения этих трех имен ? прерогатива сервера, и подробности этого нужно искать в соответствующей документации.

Редактирование внедренных объектов возможно как в отдельном окне, создаваемом сервером, так и прямо в содержащем его документе ("по месту"). Последняя возможность предусмотрена спецификацией OLE 2.0; при этом могут заменяться главное меню и строка состояния формы.

Контейнер OLE в VCL поддерживает работу с серверами обеих спецификаций. Если же по каким-либо причинам активизация сервера "по месту" нежелательна, то установка в False свойства

    {Рb} property AllowInPlace: Boolean;

позволяет ее запретить. Поскольку загрузка сервера "по месту" подразумевает изменение главного меню, то оно должно быть у приложения, содержащего форму с контейнером.

Загруженный объект OLE можно активизировать (то есть вызвать его сервер) тремя способами:

    {Рb} property AutoActivate: TAutoActivate;
    TAutoActivate = (aaManual, aaGetFocus, aaDoubleClick) ;

Типичным способом (принятым по умолчанию) является двойной щелчок (aaDoubleClick). При установленном aaGetFocus активизация происходит при получении объектом фокуса ввода. Наконец, aaManual обязывает активизировать объект OLE установкой в True одного из свойств:

    property Active: Boolean;
    property InPlaceActive: Boolean;

Различие между ними в том, что второе (по возможности) осуществляет активизацию "по месту".

Запуск и работа сервера OLE может быть длительным процессом. На время, пока объект загружается в сервер, в контейнере устанавливается флаг:

    {Ro} property InActivation: Boolean;

После того, как сервер OLE полностью активизировался, происходит событие

    {Рb} property OnActivate: TNotifyEvent;

и устанавливается в True свойство:

    property Modified: Boolean;

Если при этом вы снова переключитесь на приложение Delphi, то увидите, что на время работы сервера клиентская область контейнера заштриховывается.

Свойство

    {Рb} property Zoom: TZoomFactor;
    TZoomFactor = (z025,z050,z100,z150,z200);

показывает, с каким масштабом отображаются объекты OLE внутри контейнера (при этом размеры самого контейнера остаются неизменными; если при увеличении часть изображения объекта выходит за границы контейнера, она отсекается).

Взаимодействие сервера OLE со строкой состояния осуществляется посредством обработки событий:

    property OnStatusLineEvent: TStatusLineEvent;
    TStatusLineEvent = procedure(Sender: TObject; Msg: String) of object;

Контейнер получает от сервера извещение о наступлении такого события. Он должен обработать это сообщение, например, отобразив где-либо строку Msg.

Инициировать это событие можно также при помощи процедуры:

    procedure DoStatusLineMsg (Msg :String);

Контейнер может выгружать/загружать содержимое в поток и буфер обмена:

    procedure LoadFromFile(const FileName: string);
    procedure LoadFromStream(Stream: TStream);
    procedure SaveToFile(const FileName: string);
    procedure SaveToStream(Stream: TStream);
    procedure CopyToClipboard (Clear : Boolean) ;

Параметр Clear в последней процедуре означает необходимость очистки предыдущего содержимого.

TOLEContainer является оконным элементом управления и поддерживает все соответствующие возможности: обработку сообщений от мыши и клавиатуры, фокус ввода, интерфейс Drag&Drop и т. п.

Наконец, в TOLEContainer есть "выходы" на элементы внутреннего устройства интерфейса OLE. Использование этих возможностей не документировано, и более подробное их обсуждение имеет смысл отложить до выхода следующей версии продукта. Здесь мы их только перечислим:

    function GetContainer: TIBCont;

    property Storage: TStorage;
    property Site: TIBSite;
    property Part: IBPart;
    property PartRect: TRect;
    procedure DeleteSite;
    procedure DeleteStorage;


**Меню OLE**

У каждой формы есть свойство ObjectMenuItem. Оно ссылается на пункт меню, который специально выделяется для того, чтобы сервер OLE мог модифицировать его, разместив на этом месте свое подменю. Каждый сервер может производить над данными те или иные операции; их перечень отражаются в подменю. Оно может быть проанализировано с помощью методов, имеющихся у контейнера:

    function GetObjectMenuItemCount: Integer;
    function GetObjectMenuItem(Index: Integer): string;

Первая функция возвращает число пунктов в подменю, а вторая ? имя заданного пункта. Например, при вставке документа русской версии Microsoft Word первыми двумя будут "Редактировать" и "Открыть". Последними двумя пунктами в добавляемом меню всегда являются разделитель и пункт "Convert...", служащий для преобразования типа объекта OLE. Вы можете определить контекст помощи, предназначенный для этого диалога:

    {Рb} property ConvertDlgHelp: THelpContext;

Вызвав функцию GetObjectMenuItem с параметром -1, можно получить имя самого подменю, например, "Paintbrush Picture Object" или "Документ Word".

Действия сервера, связанные с нужным пунктом меню, можно инициировать из программы путем вызова метода:

    procedure ObjectMenuAction(Index: Integer);

Подменю становится доступным при получении фокуса компонентом TOLEContainer и блокируется при его утере. Также устанавливает состояние меню метод:

    procedure ActivateObjMenuItem(Activate: Boolean);

