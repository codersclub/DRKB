---
Title: TDBGrid и множественный выбор
Date: 01.01.2007
---


TDBGrid и множественный выбор
=============================

::: {.date}
01.01.2007
:::

При включении флажка \[dgMultiSelect\] в свойстве-наборе Options
компонента DBGrid, вы добавляете к табличной сетке возможность
множественного выбора записей.

Выбранные вами записи представлены в виде закладок и храняться в
свойстве SelectedRows.

Свойство SelectedRows является объектом, имеющим тип TBookmarkList. Его
свойства и методы описаны ниже.

    // property SelectedRows: TBookmarkList read FBookmarks;
     
    //   TBookmarkList = class
    //   public
     
    {* Метод Clear освобождает все выбранные в DBGrid записи *}
    // procedure Clear;
     
    {* Метод Delete удаляет все выбранные строки из набора данных *}
    // procedure Delete;
     
    {* Метод Find определяет наличие закладки в выбранном списке. *}
    // function  Find(const Item: TBookmarkStr;
    //      var Index: Integer): Boolean;
     
    {* Метод IndexOf возвращает индекс закладки, расположенной в свойстве Items. *}
    // function IndexOf(const Item: TBookmarkStr): Integer;
     
    {* Метод Refresh возвращает логическую величину, уведомляющую о том, ч
    то в то время, пока в табличной сетке была выбрана запись, были добавлены
    (удалены) какие-то данные. Метод Refresh может быть использован для
    обновления списка выбранных записей для уменьшения возможности получения
    удаленной записи. *}
    // function Refresh: Boolean;  True = orphans found
     
    {* Свойство Count возвращает количество выбранных в настоящий
    момент элементов в DBGrid *}
    // property Count: Integer read GetCount;
     
    {* Свойство CurrentRowSelected содержит логическую величину,
    зависящую от того, выбрана текущая строка или нет. *}
    // property CurrentRowSelected: Boolean
    //      read GetCurrentRowSelected
    //      write SetCurrentRowSelected;
     
    {* Свойство Items - TStringList TBookmarkStr *}
    // property Items[Index: Integer]: TBookmarkStr
    //      read GetItem; default;
     
    //  end;
     
    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs,
      StdCtrls, Grids, DBGrids, DB, DBTables;
     
    type
      TForm1 = class(TForm)
        Table1: TTable;
        DBGrid1: TDBGrid;
        Count: TButton;
        Selected: TButton;
        Clear: TButton;
        Delete: TButton;
        Select: TButton;
        GetBookMark: TButton;
        Find: TButton;
        FreeBookmark: TButton;
        DataSource1: TDataSource;
        procedure CountClick(Sender: TObject);
        procedure SelectedClick(Sender: TObject);
        procedure ClearClick(Sender: TObject);
        procedure DeleteClick(Sender: TObject);
        procedure SelectClick(Sender: TObject);
        procedure GetBookMarkClick(Sender: TObject);
        procedure FindClick(Sender: TObject);
        procedure FreeBookmarkClick(Sender: TObject);
      private
        { Private declarations }
      public
        { Public declarations }
      end;
     
    var
      Form1: TForm1;
      Bookmark1: TBookmark;
      z: Integer;
     
    implementation
     
    {$R *.DFM}
     
    //Пример использования свойства Count
     
    procedure TForm1.CountClick(Sender: TObject);
    begin
      if DBgrid1.SelectedRows.Count > 0 then
      begin
        showmessage(inttostr(DBgrid1.SelectedRows.Count));
      end;
    end;
     
    //Пример использования свойства CurrentRowSelected
     
    procedure TForm1.SelectedClick(Sender: TObject);
    begin
      if DBgrid1.SelectedRows.CurrentRowSelected then
        showmessage('Выбрана');
    end;
     
    //Пример использования метода Clear
     
    procedure TForm1.ClearClick(Sender: TObject);
    begin
      dbgrid1.SelectedRows.Clear;
    end;
     
    //Пример использования метода Delete
     
    procedure TForm1.DeleteClick(Sender: TObject);
    begin
      DBgrid1.SelectedRows.Delete;
    end;
     
    {*
    Данные пример проходит в цикле все выбранные
    записи табличной сетки и отображает второе
    поле набора данных.
     
    Метод DisableControls используется в случае,
    когда необходимо запретить обновление DBGrid
    при изменении набора данных. Последняя позиция
    набора данных сохраняется как TBookmark.
     
    Метод IndexOf вызывается при необходимости
    проверить существование закладки.
    Решение использовать метод IndexOf, а не
    Refresh, должно приниматься исходя из
    специфики приложения.
    *}
     
    procedure TForm1.SelectClick(Sender: TObject);
    var
      x: word;
      TempBookmark: TBookMark;
    begin
      DBGrid1.Datasource.Dataset.DisableControls;
      with DBgrid1.SelectedRows do
        if Count > 0 then
        begin
          TempBookmark := DBGrid1.Datasource.Dataset.GetBookmark;
          for x := 0 to Count - 1 do
          begin
            if IndexOf(Items[x]) > -1 then
            begin
              DBGrid1.Datasource.Dataset.Bookmark := Items[x];
              showmessage(DBGrid1.Datasource.Dataset.Fields[1].AsString);
            end;
          end;
        end;
      DBGrid1.Datasource.Dataset.GotoBookmark(TempBookmark);
      DBGrid1.Datasource.Dataset.FreeBookmark(TempBookmark);
      DBGrid1.Datasource.Dataset.EnableControls;
    end;
     
    {*
    Данный пример позволит вам установить закладку и
    затем найти ее в списке выбранных записей
    компонента DBGrid.
    *}
     
    //Устанавливаем закдадку
     
    procedure TForm1.GetBookMarkClick(Sender: TObject);
    begin
      Bookmark1 := DBGrid1.Datasource.Dataset.GetBookmark;
    end;
     
    //Освобождаем закладку
     
    procedure TForm1.FreeBookmarkClick(Sender: TObject);
    begin
      if assigned(Bookmark1) then
      begin
        DBGrid1.Datasource.Dataset.FreeBookmark(Bookmark1);
        Bookmark1 := nil;
      end;
    end;
     
    //Испольуем метод Find для установления позиции
    //записи-закладки в списке выбранных записей компонента DBGrid
     
    procedure TForm1.FindClick(Sender: TObject);
    begin
      if assigned(Bookmark1) then
      begin
        if DBGrid1.SelectedRows.Find(TBookMarkStr(Bookmark1), z) then
          showmessage(inttostr(z));
      end;
    end;
     
    end.

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Данный пример позволяет производить множественный выбор записей

в табличной сетке и отображать второе поле

набора данных.

Метод DisableControls применяется для того, чтобы

DBGrid не обновлялся во время изменения набора данных.

Последняя позиция набора данных сохраняется как

TBookmark.

Метод IndexOf вызывается для проверки

существования закладки.

Решение использовать метод IndexOf, а не метод

Refresh должно определяться

спецификой приложения.

    procedure TForm1.SelectClick(Sender: TObject);
    var
      x: word;
      TempBookmark: TBookMark;
    begin
      DBGrid1.Datasource.Dataset.DisableControls;
      with DBgrid1.SelectedRows do
        if Count <> 0 then
        begin
          TempBookmark := DBGrid1.Datasource.Dataset.GetBookmark;
          for x := 0 to Count - 1 do
          begin
            if IndexOf(Items[x]) > -1 then
            begin
              DBGrid1.Datasource.Dataset.Bookmark := Items[x];
              showmessage(DBGrid1.Datasource.Dataset.Fields[1].AsString);
            end;
          end;
        end;
      DBGrid1.Datasource.Dataset.GotoBookmark(TempBookmark);
      DBGrid1.Datasource.Dataset.FreeBookmark(TempBookmark);
      DBGrid1.Datasource.Dataset.EnableControls;
    end;

Взято с <https://delphiworld.narod.ru>

------------------------------------------------------------------------

Существует одно свойство, не упомянутое в файлах помощи (оплошность,
господа программисты из Borland), имеющее имя SelectedRows, и вот как
его можно использовать:

    procedure TfrmGrid.Button1Click(Sender: TObject);
    var
      i: integer;
    begin
      For i := 0 to DBGrid1.SelectedRows.Count - 1 do
      begin
        Table1.GoToBookmark(TBookmark(DBGrid1.SelectedRows[i]));
        Table1.Delete;
      end;
    end;

Взято с <https://delphiworld.narod.ru>
