---
Title: Как поместить картинку в заголовок TListView?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить картинку в заголовок TListView?
=============================================

Иногда бывает полезно в заголовке колонки показывать стрелочку, чтобы
информировать пользователя, по какой колонке идёт сортировка. Добавьте
следующий код в форму:

    procedure TForm1.SetColumnImage( List: TListView; Column, Image: Integer; 
                                     ShowImage: Boolean); 
    var 
      Align,hHeader: integer; 
      HD: HD_ITEM; 
     
    begin 
      hHeader := SendMessage(List.Handle, LVM_GETHEADER, 0, 0); 
      with HD do 
      begin     
        case List.Columns[Column].Alignment of 
          taLeftJustify:  Align := HDF_LEFT; 
          taCenter:       Align := HDF_CENTER; 
          taRightJustify: Align := HDF_RIGHT; 
        else 
          Align := HDF_LEFT; 
        end; 
     
        mask := HDI_IMAGE or HDI_FORMAT; 
     
        pszText := PChar(List.Columns[Column].Caption); 
     
        if ShowImage then 
          fmt := HDF_STRING or HDF_IMAGE or HDF_BITMAP_ON_RIGHT 
        else 
          fmt := HDF_STRING or Align; 
     
        iImage := Image; 
      end; 
      SendMessage(hHeader, HDM_SETITEM, Column, Integer(@HD)); 
    end; 

Картинки берутся из списка SmallImages. Вам надо будет вызвать эту
функцию для каждой колонки и установить ShowImage в TRUE для той
колонки, которую Вы будете сортировать. Сделать это можно в функции
OnColumnClick():

    procedure TForm1.ListView1ColumnClick(Sender: TObject; 
      Column: TListColumn); 
    var 
      i : integer; 
    begin 
      // Это Ваша собственная функция сортировки
      CustomSort( @CustomSortProc, Column.Index ); 
      // Этот цикл отображает иконку в выбранной колонке.
      for i := 0 to ListView1.Columns.Count-1 do 
        SetColumnImage( ListView1, i, 0, i = Column.Index ); 
    end; 

Проблема: Изменение размера колонки генерирует сообщение WM\_PAINT,
которое стирает картинку, поэтому Вам прийдётся переопределить WM\_PAINT
и вызвать SetColumnImage снова.

Использовался компонент TApplicationEvents в delphi 5.

