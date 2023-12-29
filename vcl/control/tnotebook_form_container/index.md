---
Title: TNotebook как контейнер для форм
Author: Neil
Date: 01.01.2007
---


TNotebook как контейнер для форм
================================

::: {.date}
01.01.2007
:::

Автор: Neil

>...у меня происходит утечка памяти при изменениях страниц в закладках
NoteBook.

Вы не \"теряете\" ресурсы, вы их используете. Вы ИСПОЛЬЗУЕТЕ ресурсы на
каждой страницы начиная с первой, которая доступна для вашего
созерцания. Я упомянаю это потому, потому что проблема ПОТЕРИ ресурсов
относится к другому типу проблемы.

Недавно я работал над проблемой показа других *ФОРМ* в главной форме,
как если бы они были страницами NoteBook. Форма создается при
перелистывании на эту \"страницу\", и разрушается при ее покидании. Это
требует хранения неизменяемой информации, естественно, в главной форме,
но это чрезвычайно нетребовательно к ресурсам. Главное, что вы храните
поля индивидуальных данных в главной форме с именем \"Child\", а
инициализируете в обработчике события экземпляра TForm2 (или имеющего
другое имя, в зависимости от имени вашей первой дочерней формы)
OnCreate. Поместите закладки в нижней части формы, и при изменении
закладки освобождайте текущего \"ребенка\", а затем создавайте и делайте
ребенком другой соответствующий экземпляр формы.

Как заставить работать эту технологию: у каждой дочерней формы имеется
метод CreateParams, позволяющий сделать ее \"ребенком\" главной формы:

    procedure TPageForm.CreateParams(var Params: TCreateParams);
    begin
      inherited CreateParams(Params);
      with Params do
      begin
        WndParent := Application.MainForm.Handle;
        Parent := Application.MainForm;
        Style := WS_CHILD or WS_CLIPSIBLINGS or WS_CLIPCHILDREN;
        Align := alClient;
      end;
    end;

Код главной формы должен выглядеть примерно так:

    procedure TForm1.TabSet1Change(Sender: TObject; NewTab: Integer;
      var AllowChange: Boolean);
    begin
      LockWindowUpdate(Handle);
      Child.Free;
      case NewTab of
        0: Child := TForm2.Create(Application);
        1: Child := TForm3.Create(Application);
        2: Child := TForm4.Create(Application);
      end;
      Child.Show;
      LockWindowUpdate(0);
    end;

<https://delphiworld.narod.ru/>

DelphiWorld 6.0

 

------------------------------------------------------------------------

Автор: Ralph Friedman

Кто-нибудь может мне помочь в вопросе размещения подклассов форм на
страницах компонента TTabbedNotebook?

Я пробовал следующий код и он отлично работает с компонентами,
являющимися частью формы, содержащей TTabbedNotebook; тем не менее он не
работает с дочерними формами:

    ChildForml[i].Parent := TWinControl(BrowseTabNotebook.Pages.Objects[i]);

В дочерней форме должен быть следующий код:

    private
      { Private }
      procedure CreateParams(var Params: TCreateParams); override;
     
    ...
     
    procedure TChildForm1.CreateParams(var Params: TCreateParams);
    begin
      { сначала вызываем унаследованные методы. }
      inherited CreateParams(Params);
      with Params do
      begin
        WndParent := Application.Mainform.Handle;
        Style := (Style or WS_CHILD) and not WS_POPUP;
      end;
    end;
     

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
