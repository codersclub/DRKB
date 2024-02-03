---
Title: Поточность TreeView
Author: Mike Scott
Date: 01.01.2007
---


Поточность TreeView
===================

::: {.date}
01.01.2007
:::

Автор: Mike Scott

На пустой форме у меня располагается TTreeView. Затем я сохраняю это в
файле, используя WriteComponent. Это работает как положено; я могу из
DOS c помощью команды "type" посмотреть двоичный файл и увидеть его
содержимое, типа строк TTreeView и имя объекта. По крайней мере файл
записывается и создается впечатление его "наполненности".

Затем я освобождаю компонент TTreeView, открываю поток, делаю
ReadComponent и, затем, InsertControl. И получаю исключение "TreeView1
has no parent window" (TreeView1 не имеет родительского окна).

Это происходит из-за того, что при установке определенных свойств
TreeView требуется дескриптор окна элемента управления, а для этого
необходимо иметь родителя. Решение заключается в создании пустого
TreeView и передаче его в качестве параметра ReadComponent - вы
наверняка меня спросите, почему ReadComponent необходим параметр,
правильно? Смотрите дальше.

Попробуйте этот код:

    procedure TForm1.Button1Click(Sender: TObject);
    var 
      TreeView: TTreeView ;
    begin
      with TFileStream.Create( 'JUNK.STR', fmCreate ) do 
        try
          WriteComponent( TreeView1 ) ;
          TreeView1.Name := 'TreeView' ;
          Position := 0 ;
          TreeView := TTreeView.Create( Self ) ;
          TreeView.Visible := false ;
          TreeView.Parent := Self ;
          ReadComponent( TreeView ) ;
          TreeView.Top := TreeView1.Top + TreeView1.Height + 10 ;
          TreeView.Visible := true ;
        finally
          Free ;
        end ;
    end;

Два небольших замечания:

Убедитесь в отсутствии конфликта имен. Данный код делает форму
владельцем второго TreeView и при ее освобождении разрушает компонент. Я
просто переименовываю существующий TreeView перед загрузкой \'клона\'.

Я установил свойство visible в false перед установкой свойства parent,
этим я предотвратил показ только что созданного TreeView до момента
загрузки его из потока.

<https://delphiworld.narod.ru/>

DelphiWorld 6.0
