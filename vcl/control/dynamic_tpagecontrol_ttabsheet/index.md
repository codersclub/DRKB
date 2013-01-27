---
Title: Динамические TPageControl и TTabSheet
Date: 01.01.2007
---


Динамические TPageControl и TTabSheet
=====================================

::: {.date}
01.01.2007
:::

    var
      T: TTabSheet;
      P: TPageControl;
    begin
      // Создаем PageControl
      // При создании получаем ссылку на PageControl, чтобы в дальнейшем на него ссылаться.
      P := TPageControl.Create(application);
      with P do
      begin
        Parent := Form1; // устанавливаем его как элемент управления формы.
        Top := 30;
        Left := 30;
        Width := 200;
        Height := 150;
      end; // with TPageControl
     
      // Создаем 3 страницы
      T := TTabSheet.Create(P);
      with T do
      begin
        Visible := True;
          // Это необходимо, или форма не будет корректно перерисовываться
        Caption := 'Страница 1';
        PageControl := P; // Назначаем Tab в Page Control
      end; // with
     
      T := TTabSheet.Create(P);
      with T do
      begin
        Visible := True;
          // Это необходимо, или форма не будет корректно перерисовываться
        Caption := 'Страница 2';
        PageControl := P; // Назначаем Tab в Page Control
      end; // with
     
      T := TTabSheet.Create(P);
      with T do
      begin
        Visible := True;
          // Это необходимо, или форма не будет корректно перерисовываться
        Caption := 'Страница 3';
        PageControl := P; // Назначаем Tab в Page Control
      end; // with
     
      // Создаем 3 кнопки, 1 на страницу
      with tbutton.create(application) do
      begin
        Parent := P.Pages[0]; // "Указываем" кнопке родительскую страницу
        Caption := 'Привет, страница 1';
        Left := 0;
        Top := 0;
      end; // with
     
      with tbutton.create(application) do
      begin
        Parent := P.Pages[1]; // "Указываем" кнопке родительскую страницу
        Caption := 'Привет, страница 2';
        Left := 50;
        Top := 50;
      end; // with
     
      with tbutton.create(application) do
      begin
        Parent := P.Pages[2]; // "Указываем" кнопке родительскую страницу
        Caption := 'Привет, страница 3';
        Left := 100;
        Top := 90;
      end; // with
     
      // Это должно быть сделано, или Tab первоначально не синхронизируется
      // с правильной страницей. Только в случае, если у вас более чем одна страница.
      P.ActivePage := P.Pages[1];
      P.ActivePage := P.Pages[0]; // Реально показываемая страница
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

------------------------------------------------------------------------

В данном документе показана технология динамического добавления страниц
компонента PageControl (объектов TTabSheet) к элементу управления
Windows 95/NT PageControl (объект TPageControl). Оба этих объекта
объявлены в модуле ComCtrls. Поэтому убедитесь в том, что ComCtrls
указан в списке используемых модулей.

Как динамически создать PageControl

Прежде, чем мы приступим к динамическому созданию страниц, давайте
динамически создадим PageControl (если он еще не на форме). Это делается
посредством вызова конструктора TPageControl Create с параметром owner,
равным Self. Конструктор Create возвращает объектную ссылку на вновь
созданный объект PageControl и назначает его переменной \'PageControl\'.
Вторым шагом будет установка свойства PageControl Parent в Self.
Свойство Parent определяет где должен быть отображен новый PageControl;
в нашем случае это будет сама форма. Вот кусок кода, демонстрирующий
вышесказанное:

    var
     
    PageControl : TPageControl;
     
    PageControl := TPageControl.Create(Self);
    PageControl.Parent := Self;

Примечание

При разрушении формы разрушаются также PageControl и ее закладки,
поскольку они принадлежат форме.

Как динамически создавать закладки

Существует два основных способа добавления новых страниц к PageControl.
Сначала вы должны динамически создать TTabSheet следующим образом:

    var
    TabSheet : TTabSheet;
    TabSheet := TTabSheet.Create(Self);

Затем ему необходимо присвоить заголовок следующей командой:

TabSheet.Caption := \'Закладка 1\';

И, наконец, самая важное действие заключается в том, что новой странице
необходимо сообщить, какому объекту PageControl она принадлежит. Это
делается с помощью присваивания свойством TTabSheet PageControl
переменной-ссылки TPageControl, типа той, которую мы создали выше
(PageControl). Вот кусок кода, демонстрирующий вышесказанное:

TabSheet.PageControl := PageControl;

Как динамически добавлять к страницам элементы управления

Ключевым моментом при создании и размещении элемента управления на
странице TabSheet является назначение свойства Parent на
переменную-ссылку класса TTabSheet. Вот пример:

    var
     
    Button : TButton;
     
    Button := TButton.Create(Self);
    Button.Caption := 'Кнопка 1';
    Button.Parent := TabSheet;

Более подробно об объектах TPageControl и TTabSheet вы можете узнать в
онлайн-документации, или посмотреть код файла ComCtrls.pas,
расположенного в вашем каталоге ..\\Delphi 2.0\\SOURCE\\VCL.

Полный код примера

    // Код использует форму с единственной на ней кнопкой.
     
    unit DynamicTabSheetsUnit;
     
    interface
     
    uses
     
      Windows, Messages, SysUtils, Classes, Graphics, Controls,
      Forms, Dialogs, StdCtrls, Buttons;
     
    type
     
      TForm1 = class(TForm)
        Button1: TButton;
        procedure Button1Click(Sender: TObject);
        procedure TestMethod(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
     
      Form1: TForm1;
     
    implementation
     
    uses ComCtrls;
     
    {$R *.DFM}
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
     
      PageControl: TPageControl;
      TabSheet: TTabSheet;
    begin
     
      // Создаем PageControl
      PageControl := TPageControl.Create(Self);
      PageControl.Parent := Self;
     
      // Создаем первую страницу и связываем ее с PageControl
      TabSheet := TTabSheet.Create(Self);
      TabSheet.Caption := 'Закладка 1';
      TabSheet.PageControl := PageControl;
     
      // Создаем первую страницу
     
      with TButton.Create(Self) do
      begin
        Caption := 'Кнопка 1';
        OnClick := TestMethod; // Назначаем обработчик события
        Parent := TabSheet;
      end;
     
      // Создаем вторую страницу и связываем ее с PageControl
     
      TabSheet := TTabSheet.Create(Self);
      TabSheet.Caption := ' Закладка 2';
      TabSheet.PageControl := PageControl;
    end;
     
    procedure TForm1.TestMethod(Sender: TObject);
    begin
     
      ShowMessage('Привет');
    end;
     
    end.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
