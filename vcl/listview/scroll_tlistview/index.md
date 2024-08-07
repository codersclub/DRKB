---
Title: Прокрутка TListView
Date: 01.01.2007
---


Прокрутка TListView
===================

Существует довольно удобный способ прокрутки списков: если пользователь
водит курсором мыши по элементам списка с нажатой левой кнопкой, то
выделяется тот элемент, над которым находится курсор. А если курсор
оказывается выше или ниже списка, то начинается прокрутка. О том, как
такое сделать для ListView, мы сегодня и поговорим.

Во-первых, нужно сделать выделение элементов, над которыми находится
курсор мыши (при нажатой левой кнопке). Для нахождения элемента по
координатам курсора удобно использовать функцию GetItemAt. Чтобы сменить
выделение, нужно изменить свойства Selected и ItemFocused.

Чтобы отлавливать события мыши при выходе курсора за границы ListView
нужно "сказать" WIndows, что мышь сейчас "моя". Для этого
используется функция SetCapture (чтобы сказать, что "мышь мне больше не
нужна", используется функцией ReleaseCapture). Поскольку GetItemAt в
случае выхода курсора за границы ListView возвращает пустой элемент
(nil), дополнительно этот случай можно не проверять. Переменная d
принимает положительное значение, если прокрутка будет происходить вниз
и отрицательное в противном случае. Модуль d указывает на то, сколько
элементов за раз будет прокручиваться. Нужно это для изменения скорости
прокрутки (здесь скорость прокрутки зависит от того, насколько далеко
находится курсор от ListView).

Сама прокрутка осуществляется в процедуре Move. К номеру выделенного
элемента прибавляется d. Если новый номер выходит за рамки допустимого
значения, он устанавливается в 0 или Items.Count - 1. Далее происходит
проверка: если номер выделенного элемента совпадает в новым номером, то
делать ничего не нужно. В противном случае нужно изменить значение
Selected и ItemFocused, а также прокрутить список. Для последнего удобно
использовать процедуру MakeVisible. Она прокручивает список так, чтобы
указанный элемент оказался видным.

Чтобы список мог прокручиваться при неподвижной мыши, нужно сделать
Timer, который бы периодически вызывал Move. Если курсор снова
оказывается над ListView или пользователь отпускает левую кнопку мыши,
Timer выключается.

    var
      d: integer = 0;
     
    procedure Move;
    var
      NewIndex: integer;
    begin
      with Form1.ListView1 do if Assigned(Selected) then begin
        NewIndex := Selected.Index + d;
        if NewIndex < 0
          then NewIndex := 0
          else if NewIndex >= Items.Count
            then NewIndex := Items.Count - 1;
        if NewIndex <> Selected.Index then begin
          Selected := Items[NewIndex];
          ItemFocused := Selected;
          Selected.MakeVisible(true);
        end;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      i: integer;
      li: TListitem;
      lc: TListColumn;
    begin
      Timer1.Interval := 100;
      ListView1.ViewStyle := vsReport;
      lc := ListView1.Columns.Add;
      lc.Caption := 'Caption';
      lc.AutoSize := true;
      lc := ListView1.Columns.Add;
      lc.Caption := 'SubItem';
      lc.AutoSize := true;
      ListView1.Items.BeginUpdate;
      for i := 1 to 1000 do begin
        li := ListView1.Items.Add;
        li.Caption := 'Item ' + IntToStr(i);
        li.SubItems.Add('SubItem ' + IntToStr(i));
      end;
      ListView1.Items.EndUpdate;
    end;
     
    procedure TForm1.ListView1MouseDown(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      SetCapture(ListView1.Handle);
    end;
     
    procedure TForm1.ListView1MouseMove(Sender: TObject; Shift: TShiftState; X,
      Y: Integer);
    var
      li: TListItem;
    begin
      if ssLeft in Shift then with ListView1 do begin
        li := GetItemAt(10, Y);
        if Assigned(li) then begin
          Timer1.Enabled := false;
          Selected := li;
          ItemFocused := ListView1.Selected;
        end else begin
          if Y >= ListView1.ClientHeight
            then d := (Y - ListView1.ClientHeight) div 20 + 1
            else d := Y div 20 - 1;
          if Timer1.Enabled = false then begin
            Move;
            Timer1.Enabled := true;
          end;
        end;
      end;
    end;
     
    procedure TForm1.ListView1MouseUp(Sender: TObject; Button: TMouseButton;
      Shift: TShiftState; X, Y: Integer);
    begin
      Timer1.Enabled := false;
      ReleaseCapture;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    begin
      Move;
    end;
