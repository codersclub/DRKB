---
Title: Разработка MDI-приложений в Delphi
Date: 01.01.2007
---


Разработка MDI-приложений в Delphi
==================================

::: {.date}
01.01.2007
:::

перевод одноимённой статьи с delphi.about.com)

  Что такое MDI?

MDI расшифровывается как multiple document interface (многодокументный
интерфейс). В приложениях с MDI, в основном (родительском) окне можно
окрыть более одного дочернего окна. Данная возможность обычно
используется в электронных таблицах или текстовых редакторах.

Каждое MDI приложение имеет три основные составляющие:

Одну (и только одну) родительскую форму MDI, Одну и более (обычно
больше) дочерних форм MDI, и основное меню MDI.

  MDI \"мать\"

Как уже упоминалось, в проекте MDI приложения может присутствовать
только один MDI контейнер (родительская форма) и он должен быть
стартовой формой.

Для создания основного окна MDI приложения проделайте следующие шаги:

Запустите Delphi и выберите File \| New Application\... Delphi создаст
новый проект с одной формой под названием form1 (по умолчанию).

В свойстве Name присвойте форме имя frMain.

Установите свойство FormStyle в fsMDIform.

Сохраните этот проект (имя проекта на Ваше усмотрение, например
prMDIExample), вместе с uMain.pas в только что созданной директории.

Как Вы успели заметить, для создания основной формы MDI, мы установили
свойство FormStyle в fsMDIform. В каждом приложении только одна форма
может иметь свойство fsMDIform.

  MDI \"дети\"

Каждое родительское окно MDI нуждается по крайней мере в одной дочерней
форме. Дочерние формы MDI - это простые формы, за исключением того, что
их видимая часть ограничена размерами родительского окна. Так же при
минимизации такого окна, оно помещается не в панель задач, а остаётся
внутри родительского окна ( на панель задач попадёт только родительское
окно).

Теперь давайте создадим дополнительные формы, а точнее дочерние. Просто
выберите File \| New Form. Будет создан новый объект формы с именем
form1 (по умолчанию). При помощи Object Inspector измените свойство Name
в форме form1 на frChild, а свойство FormStyle на fsMDIChild. Сохраните
эту форму с соответствующим ей файлом как uchild.pas. Обратите внимание,
что при помощи данного свойства мы можем превратить любую существующую
форму в дочернюю форму MDI.

Ваше приложение может включать множество дочерних MDI форм такого же или
другого типа.

Так же хочется обратить Ваше внимание, что MDI приложение может включать
в себя и самые обычные формы, но в отличие от дочерних, они будут
отображаться как обычные модальные диалоговые окна (такие как about box,
или файловый диалог).

Естевственно, что как на родительском так и на дочернем окнах можно
располагать любые элементы управления, однако уже давно сложилась
традиция, что на родительской форме располагается панель статуса (status
bar) и панель инструментов (toolbar), в то время как на дочерних формах
располагаются все остальные контролы, такие как гриды, картинки, поля
вводи и т. д.

Автосодание -\> Доступные

Теперь давайте произведём некоторые настройки нашего проекта. Выберите
Project \| Options, откроется диалог опций проекта (Project Options). В
левой панели выберите frChild (Авто-создание форм (\"Auto-create
forms\")), и переместите её в правую панель (Доступные формы (Available
forms)). Список правой панели содержит те формы, которые используются
Вашим приложением, но которые не созданы автоматически. В MDI
приложении, по умолчанию, все дочерние формы создаются автоматически и
отображаются в родительской форме.

Создание и отображение\...

Как упомянуто выше, настройка не позволяет автоматически создавать
дочерние окна, поэтому нам необходимо добавить некоторый код, который
будет производить создание объекта формы frChild. Следующую функцию
CreateChildForm необходимо поместить внутри основной формы (MDI
родитель) (наряду с заголовком в interface\'s private):

    uses uchild;
    ...
    procedure TfrMain.CreateChildForm
             (const childName : string);
      var Child: TfrChild;
    begin
      Child := TfrChild.Create(Application);
      Child.Caption := childName;
    end;

Данный код создаёт одну дочернюю форму с заголовком childName.

Не забудьте, что этот код находится разделе \"uses uchild\".

На закрытие не минимизировать!

Закрытие дочернего окна в MDI приложении всего навсего минимизирует его
в клиентской области родительского окна. Поэтому мы должны обеспечить
процедуру OnClose, и установить параметр Action в caFree:

    procedure TfrChild.FormClose
          (Sender: TObject; var Action: TCloseAction);
    begin
     Action := caFree;
    end;

Обратите внимание, что если форма является дочерней формой MDI, и её
свойство BorderIcons установлено в biMinimize (по умолчанию), то опять
же по умолчанию параметр Action установлен в caMinimize. Если же в
дочерней форме MDI нет этих установок, то по умолчанию Action установлен
как caNone, означающий, что при закрытии формы ничего не случится.

  MDI родительское меню

Каждое MDI приложение должно иметь основное меню с (если больше ничего
нет), опцией выравнивания окон. Поскольку мы предварительно переместили
дочернюю форму из Авто-создаваемых (Auto-create) в Доступные (Available)
формы, то нам нужен будет код, который (пункт меню) будет создавать
дочерние формы.

Для создания дочерних окон в нашем приложении будет использоваться пункт
меню \"New child\". Второе меню (Window) будет использоваться для
выравнивания дочерних окошек внутри родительского окна-формы.

\...Создать и отобразить

В заключении нам необходимо сделать обработчик для пункта меню \"New
child\". При нажатии на пунк меню File \| New Child нашего приложения,
будет вызываться процедура NewChild1Click которая в свою очередь будет
вызывать процедуру CreateChildForm (приведённую выше), для создания
(следующего) экземпляра формы frChild.

    procedure TfrMain.NewChild1Click(Sender: TObject);
    begin
     CreateChildForm('Child '+IntToStr(MDIChildCount+1));
    end;

Только что созданная дочерняя форма будет иметь заголовок в виде \"Child
x\",  где x представляет количество дочерних форм внутри MDI формы, как
описано ниже.

Закрыть всё

При работе с приложением, имеющим многодокументный интерфейс, всегда
необходимо иметь процедуру, закрывающую все дочерние окна.

    procedure TfrMain.CloseAll1Click(Sender: TObject);
    var i: integer;
    begin
      for i:= 0 to MdiChildCount - 1 do
        MDIChildren[i].Close;
    end;

Вам прийдётся выполнять проверку на предмет наличия несохранённой
информации в каждом дочернем окне. Для решения данной задачи лучше всего
использовать обработчик события OnCloseQuery.

Свойства MdiChildCount и MDIChildren

MdiChildCount свойство read only, содержащее в себе количество созданных
дочерних окошек. Если не создано ни одно дочернее окно, то это свойство
установлено в 0. Нам прийдётся частенько использовать MdiChildCount
наряду с массивом MDIChildren. Массив MDIChildren содержит ссылки на
объекты TForm всех дочерних окошек.

Обратите внимание, что MDIChildCount первого созданного дочернего окна
равен 1.

  Меню Window

Delphi обеспечивает большинство команд, которые можно поместить внутри
пункта меню Window. Далее приведён пример вызова трёх основных методов
для команд, которые мы поместили в наше приложение:

    procedure TfrMain.Cascade1Click(Sender: TObject);
    begin
      Cascade;
    end;
     
    procedure TfrMain.Tile1Click(Sender: TObject);
    begin
      Tile;
    end;
     
    procedure TfrMain.ArrangeAll1Click(Sender: TObject);
    begin
      ArrangeIcons;
    end;

Взято из <https://forum.sources.ru>