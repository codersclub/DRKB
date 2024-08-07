---
Title: Динамические создание объектов в TTabbedNotebook
Date: 01.01.2007
---


Динамические создание объектов в TTabbedNotebook
================================================

Вариант 1:

Source: <https://delphiworld.narod.ru>


    procedure TForm1.TabbedNotebook1Click(Sender: TObject);
    var
      myE: TEdit;
    begin
      with TabbedNotebook1 do
      begin
        if PageIndex = 1 then
        begin
          myE := TEdit.Create(Self);
          myE.Left := 12;
          myE.Top := 12;
          myE.Parent := Pages.Objects[PageIndex] as TWinControl;
          myE.Show;
        end;
      end;
    end;
     
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      Button2:Tbutton;
    begin
      button2:=tbutton.create(self);
      button2.parent:=TabbedNotebook1.Pages.Object[0] as TTabPage;
      button2.setbounds(30,30,60,30);
    end;


------------------------------------------------------------------------

Вариант 2:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

> Как мне поместить кнопку (во время выполнения программы) на страницу
> TabbedNoteBook?

    procedure TForm1.Button1Click(Sender: TObject);
    var
      Button2:Tbutton;
    begin
      button2:=tbutton.create(self);
      button2.parent:=TabbedNotebook1.Pages.Object[0] as TTabPage;
      button2.setbounds(30,30,60,30);
    end;



------------------------------------------------------------------------

Вариант 3:

Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>

Я несколько раз видел в конференциях вопросы типа "как мне добавить
элементы управления в TTabbedNotebook или TNotebook во время выполнения
программы?". Теперь, когда у меня выдалось несколько свободных минут, я
попытаюсь осветить этот вопрос как можно подробнее:

**TTabbedNotebook**

Добавление элементов управления в TTabbedNotebook во время
проектирования - красивая и простая задача. Все, что Вам нужно - это
установить свойство PageIndex или ActivePage на необходимую страницу и
начать заполнять ее элементами управления.

Добавление элементов управление во время выполнения приложения также
очень просто. Тем не менее, в прилагаемой документации по Delphi вы не
найдете рецептов типа Что-и-Как. Видимо для того, чтобы окончательно
запутать начинающих программистов, фирма-изготовитель даже не
удосужилась включить исходный код TTabbedNotebook в VCL-библиотеку.
Таким образом, TTabbedNotebook остается для некоторых тайной за семью
печатями. К счастью, я имею некоторый опыт, коим и хочу поделиться.

Первым шагом к раскрытию тайны послужит просмотр файла
\\DELPHI\\DOC\\TABNOTBK.INT, интерфейсной секции модуля TABNOTBK.PAS, в
котором определен класс TTabbedNotebook. Беглый просмотр позволяет
обнаружить класс TTabPage, описанный как хранилище элементов управления
отдельной страницы TTabbedNotebook.

Вторым шагом в исследовании TTabbedNotebook может стать факт наличия
свойством Pages типа TStrings. В связи с этим отметим, что Delphi-классы
TStrings и TStringList соорганизуются с двумя свойствами: Strings и
Objects. Другими словами, для каждой строки в TStrings есть указатель на
соответствующий Objects. Во многих случаях этот дополнительный указатель
игнорируется, нам же он очень пригодится.

После небольшого эксперимента выясняем, что свойство Objects указывает
на нашу копию TTabPage и ссылается на имя страницы в свойстве Strings.
Блестяще! Всегда полезно знать что ищешь. Теперь посмотрим что мы можем
сделать:

     
     
    { Данная процедура добавляет кнопку в случайной позиции на }
    { текущей странице данного TTabbedNotebook.                }
     
    procedure AddButton(tabNotebook: TTabbedNotebook);
    var
      tabpage: TTabPage;
      button: TButton;
    begin
      with tabNotebook do
        tabpage := TTabPage(Pages.Objects[PageIndex]);
      button := TButton.Create(tabpage);
      try
        with button do
        begin
          Parent := tabpage;
          Left := Random(tabpage.ClientWidth - Width);
          Top := Random(tabpage.ClientHeight - Height);
        end;
      except
        button.Free;
      end;
    end;

**TNotebook**

Операция по заполнению элементами управления компонента TNotebook почти
такая же, как и в TTabbedNotebook - разница лишь в типе класса - TPage
вместо TTabPage. Тем не менее, если вы заглянете в
DELPHI\\DOC\\EXTCTRLS.INT, декларацию класса TPage вы там не найдете. По
неизвестной причине Borland не включил определение TPage и в DOC-файлы,
поставляемые с Delphi. Декларация TPage в EXTCTRLS.PAS (можно найти в
библиотеке VCL-исходников), правда, расположена в интерфейсной части
модуля. Мы восполним пропущенную информацию о классе TPage:

    TPage = class(TCustomControl)
    private
      procedure WMNCHitTest(var Message: TWMNCHitTest); message WM_NCHITTEST;
    protected
      procedure ReadState(Reader: TReader); override;
      procedure Paint; override;
    public
      constructor Create(AOwner: TComponent); override;
    published
      property Caption;
      property Height stored False;
      property TabOrder stored False;
      property Visible stored False;
      property Width stored False;
    end;

Теперь, по аналогии с вышеприведенной процедурой, попробуем добавить
кнопку на TNotebook. Все, что мы должны сделать - заменить
"TTabbedNotebook" на "TNotebook" и "TTabPage" на "TPage". Вот
что должно получиться:

    { Данная процедура добавляет кнопку в случайной позиции на }
    { текущей странице данного TNotebook.                      }
     
    procedure AddButton(Notebook1: TNotebook);
    var
      page: TPage;
      button: TButton;
    begin
      with Notebook1 do
        page := TPage(Pages.Objects[PageIndex]);
      button := TButton.Create(page);
      try
        with button do
        begin
          Parent := page;
          Left := Random(page.ClientWidth - Width);
          Top := Random(page.ClientHeight - Height);
        end;
      except
        button.Free;
      end;
    end;


