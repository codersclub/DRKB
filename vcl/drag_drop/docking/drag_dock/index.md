---
Title: Интерфейс присоединения Drag & Dock
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---


Интерфейс присоединения Drag & Dock
===================================

Эта возможность появилась в Delphi 4. Она "подсмотрена" опять-таки у
разработчиков из Microsoft, внедривших плавающие панели инструментов в
MS Office, Internet Explorer и другие продукты (рис. 27.2).

Речь идет о том, что ряд элементов управления (а конкретно --- потомки
класса xwinControl) могут служить носителями (доками) для других
элементов управления с возможностью их динамического перемещения из
одного дока в другой при помощи мыши. Перетаскивать можно практически
все - от статического текста до форм включительно. Пример
использования техники Drag-and-Dock дает сама среда разработки Delphi -
с ее помощью можно объединять на экране различные инструменты, такие
как Инспектор объектов и Менеджер проекта.

Как и в случае с технологией перетаскивания Drag-and-Drop, возможны два
варианта реализации техники Drag-and-Dock: автоматический и ручной. В
первом случае дело сводится к установке нужных значений для нескольких
свойств, а остальную часть работы берет на себя код VCL; во втором, как
следует из названия, вся работа возлагается на программиста.

Итак, что же нужно сделать для внедрения Drag-and-Dock? В Инспекторе
объектов необходимо изменить значение свойства DragKind на dkDock, a
свойства DragMode - на dmAutomatic. Теперь этот элемент управления
можно перетаскивать с одного носителя-дока на другой.

Носителем других компонентов (доком) может служить потомок TwinControl.
У него есть свойство Docksite, установка которого в True разрешает
перенос на него других компонентов. Если при этом еще и установить
свойство AutoSize в True, док будет автоматически масштабироваться в
зависимости от того, что на нем находится. В принципе, этими тремя
операциями исчерпывается минимальный обязательный набор.

Естественно, для программиста предусмотрены возможности контроля за этим
процессом. Каждый переносимый элемент управления имеет два события,
возникающие в моменты начала и конца переноса:

    type
      TStartDockEvent = procedure(Sender: TObject;
        var DragObject: TDragDockObject) of object;
     
      TEndDragEvent = procedure(Sender, Target: TObject;
        X, Y: Integer) of object;

В первом из методов sender - это переносимый объект, a DragObject -
специальный объект, создаваемый на время процесса переноса и содержащий
его свойства. Во втором sender - это также переносимый объект, a
Target - объект-док.

Док тоже извещается о событиях во время переноса:

    type
      TGetSitelnfoEvent = procedure(Sender: TObject; DockClient: TControl;
        var InfluenceRect: TRect; MousePos: TPoint; var CanDock: Boolean) of object;
     
      TDockOverEvent = procedure(Sender: TObject; Source: TDragDockObject;
        X, Y: Integer; State: TDragState; var Accept: Boolean) of object;
     
      TDockDropEvent = procedure(Sender: TObject;
        Source: TDragDockObject; X, Y: Integer) of object;
     
      TUnDockEvent = procedure(Sender: TObject; Client: TControl;
        NewTarget: TWinControl; var Allow: Boolean) of object;

Как только пользователь нажал кнопку мыши над переносимым компонентом и
начал сдвигать его с места, всем потенциальным докам (компонентам,
свойство которых Docksite установлено в True) рассылается событие
onGetsiteinfo. С ним передаются параметры: кто хочет "приземлиться"
(параметр Dockclient) и где (MousePos). В ответ док должен сообщить
решение, принимает он компонент (параметр CanDock) и предоставляемый
прямоугольник (infiuenceRect) или нет. При помощи этого события можно
принимать только определенные элементы управления, как показано в
примере:

    procedure TForml.PanellGetSitelnfо(Sender: TObject; DockClient: TControl;
      var InfiuenceRect: TRect; MousePos: TPoint; var CanDock: Boolean);
    begin
      if DockClient is TBitBtn then
        CanDock := False;
    end;

Два последующих события в точности соответствуют своим аналогам из
механизма переноса Drag-and-Drop). Событие onDockOver происходит при
перемещении перетаскиваемого компонента над доком, OnDockDrop - в
момент его отпускания. Наконец, onUnDock сигнализирует об уходе
компонента с дока и происходит в момент его "приземления" в другом
месте.

Между доком и содержащимися на нем элементами управления есть
двусторонняя связь. Все "припаркованные" элементы управления
содержатся в векторном свойстве Dockclients, а их количество можно
узнать из свойства

    DockClientCount:
    s: = ' ';
    for i := 0 to Panell.DockClientCount - 1 do
      AppendStr(s, Panell.DockClients[i].Name + #0$D#0$A);
    ShowMessage(s);

С другой стороны, если элемент управления находится на доке, то ссылка
на док располагается в свойстве HostDocksite. С ее помощью можно
установить, где находится элемент, и даже поменять свойства дока:

    procedure TMyForm.ButtonlEndDock(Sender, Target: TObject; X, Y: Integer);
    begin
      (Sender as TControl).HostDockSite.SetTextBuf(pChar((Sender as TControl).Name));
    end;

Компоненты можно не только переносить с одного дока на другой, но и
отпускать в любом месте. Хотя сам по себе компонент TControl и его
потомки не являются окнами Windows, но специально для этого случая
создается окно-носитель. Свойство FloatingDockSiteClass как раз и
определяет класс создаваемого окна. По умолчанию для большинства
компонентов значение этого свойства равно TCustomDockForm. Это -
форма, которая обладает свойствами дока и создается в момент отпускания
элемента управления вне других доков. Внешне она ничем не отличается от
обычной стандартной формы. Если вы хотите, чтобы ваша плавающая панель
инструментов выглядела по-особенному, нужно породить потомка от класса
TCustomDockForm и связать свойство FloatingDockSiteCiass с этим
порожденным классом:

    TMyCustomFloatingForm = class(TCustomDockForm)
    public
      constructor Create(AOwner: TComponent); override;
    end;
     
    constructor TMyCustomFloatingForm.Create(AOwner: TComponent};
    begin
      inherited Create(AOwner);
      BorderStyle := bsNone;
    end;
     
    procedure TForml.FormCreate(Sender: TObject);
    begin
      ToolBarl.FioatingDockSiteCiass := TMyCustomFloatingForm;
    end;

В этом примере решена типовая задача - сделать так, чтобы несущее окно
плавающей панели инструментов не содержало заголовка. Внешний вид таких
панелей приведен на рис. 27.3.

Переносить компоненты можно не только с помощью мыши, но и программно.
Для этого есть пара методов ManualDock и ManualFioat. В приводимом ниже
примере нажатие кнопки с именем BitBtnl переносит форму custForm на док
MainForm.Paneil и размещает ее по всей доступной площади (параметр
выравнивания alclient). Нажатие кнопки BitBtn2 снимает эту форму с дока
и выравнивает ее по центру экрана. В свойствах UndockHeight и
undockwidth хранятся высота и ширина элемента управления на момент,
предшествующий помещению на док:

    procedure TMainForm.BitBtnlClick(Sender: TObject);
    begin
      GustForm.ManualDock(MainForm.Pane11, nil, alClient);
    end;
     
    procedure TMainForm.BitBtn2Click(Sender: TObject);
    begin
      with CustForm do
      begin
        ManualFloat(Rect((Screen.Width - UndockWidth) div 2,
          (Screen.Height - UndockHeight) div 2, (Screen.Width + UndockWidth) div 2,
          (Screen.Height + UndockHeight) div 2));
      end;
    end;

Полное рассмотрение внутреннего устройства механизмов Drag-and-Dock
потребовало бы расширения объема этой главы. Тем, кто хочет использовать
их на все 100%, рекомендуем обратиться к свойствам useDockManager и
DockManager. Последнее представляет собой СОМ-интерфейс, позволяющий
расширить возможности дока, вплоть до записи его состояния в поток
(класс TStream).



 
