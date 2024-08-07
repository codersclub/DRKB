---
Title: Как поместить TComboBox в ячейку TStringGrid?
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Как поместить TComboBox в ячейку TStringGrid?
=============================================

Вариант 1:

Следующий пример демонстрирует всплывающий ComboBox в качестве местного
редактора для компонента TStringGrid:

    procedure TForm1.FormCreate(Sender: TObject);
    begin
     {Высоту у combobox не получится установить, поэтому мы будем}
     {подгонять размер у грида под размер combobox!}
      StringGrid1.DefaultRowHeight := ComboBox1.Height;
     {Скрываем combobox}
      ComboBox1.Visible := False;
    end;
     
    procedure TForm1.ComboBox1Change(Sender: TObject);
    begin
     {Получаем выбранный элемент из ComboBox и помещаем его в грид}
      StringGrid1.Cells[StringGrid1.Col,
                        StringGrid1.Row] :=
        ComboBox1.Items[ComboBox1.ItemIndex];
      ComboBox1.Visible := False;
      StringGrid1.SetFocus;
    end;
     
    procedure TForm1.ComboBox1Exit(Sender: TObject);
    begin
     {Получаем выбранный элемент из ComboBox и помещаем его в грид}
      StringGrid1.Cells[StringGrid1.Col,
                        StringGrid1.Row] :=
        ComboBox1.Items[ComboBox1.ItemIndex];
      ComboBox1.Visible := False;
      StringGrid1.SetFocus;
    end;
     
    procedure TForm1.StringGrid1SelectCell(Sender: TObject; Col,
     Row: Integer;  var CanSelect: Boolean);
    var
      R: TRect;
    begin
      if ((Col = 3) AND
          (Row <> 0)) then begin
       {Размер и расположение combobox подгоняем под ячейку}
        R := StringGrid1.CellRect(Col, Row);
        R.Left := R.Left + StringGrid1.Left;
        R.Right := R.Right + StringGrid1.Left;
        R.Top := R.Top + StringGrid1.Top;
        R.Bottom := R.Bottom + StringGrid1.Top;
        ComboBox1.Left := R.Left + 1;
        ComboBox1.Top := R.Top + 1;
        ComboBox1.Width := (R.Right + 1) - R.Left;
        ComboBox1.Height := (R.Bottom + 1) - R.Top;
       {Показываем combobox}
        ComboBox1.Visible := True;
        ComboBox1.SetFocus;
      end;
      CanSelect := True;
    end;

------------------------------------------------------------------------

Вариант 2:

**Дополнение от Gugle**

Предлагаю немного дополнить статью "Как показывать встроенный редактор
ComboBox в ячейке StringGrid".

1. Дело в том, что в оригинальной статье при выделении какой-либо ячейки
в StrinGrid-е, в ComboBox ничего не передается. Это немного не верный
способ, т.к. сам ComboBox не переходит на позицию (ItemIndex) того
текста который находится в StgingGrid-е, а встает в позицию ноль и если
ничего не изменить в ComboBox, а просто выйти из ячейки, то значение в
StringGrid-е изменится на значение текста присвоенному нулевой позиции
(ItemIndex) ComboBox-а. С этим многие наверное сталкивались и исправить
это довольно легко. Поэтому предлогаю просто внести в статью еще одну
функцию, которая не просто передает значение из StringGrid-а в ComboBox,
а ставит ComboBox в необходимю позицию.

2. Поработав с такими вставками я пришел к выводу, что "помещать
выбранный элемент из ComboBox-а в Grid" стоит не в событии
ComboBox1Change, а в событии ComboBox1CloseUp. Это более верно, т.к.
Windows не будет путать где происходит прокрутка и где сейчас стоит
фокус!

3. Есть еще одна проблема со вставками компонентов в StringGrid, который
проявляется не на всех компьютерах. Если конкретно то это пропадание
объетов вставки при пользовании скрула в StringGrid-е. Что бы не
повторятся вот ссылка на вопрос --\> Исчезает ComboBox из StringGrid-а.
Видимо мало народу с ней сталкивалось. И все же проблему эту решить
оказалось проще некуда... Оказывается, если прокрутить роликом над
StringGrid-ом, то он принимает StayOnTop, а все компоненты,
соответственно, оказываются под ним. Следовательно, надо сделать
StringGrid-у SendToBack.

Дополненая статья:

    procedure TForm1.FormCreate(Sender: TObject); 
     
    begin 
     {Высоту у combobox не получится установить, поэтому мы будем} 
     {подгонять размер у грида под размер combobox!} 
      StringGrid1.DefaultRowHeight := ComboBox1.Height; 
     {Скрываем combobox} 
      ComboBox1.Visible := False; 
    end; 
     
    procedure TForm1.ComboBox1CloseUp(Sender: TObject); 
    begin 
     {Получаем выбранный элемент из ComboBox и помещаем его в грид} 
      StringGrid1.Cells[StringGrid1.Col, StringGrid1.Row] := ComboBox1.Items[ComboBox1.ItemIndex]; 
      ComboBox1.Visible := False; 
      StringGrid1.SetFocus; 
    end; 
     
    procedure TForm1.ComboBox1Exit(Sender: TObject); 
    begin 
     {Получаем выбранный элемент из ComboBox и помещаем его в грид} 
      StringGrid1.Cells[StringGrid1.Col, StringGrid1.Row] := ComboBox1.Items[ComboBox1.ItemIndex]; 
      ComboBox1.Visible := False; 
      StringGrid1.SetFocus; 
    end; 
     
    procedure TForm1.StringGrid1SelectCell(Sender: TObject; Col, 
     Row: Integer;  var CanSelect: Boolean); 
    var 
      R: TRect; 
    begin
      SGWriteRead.SendToBack;  
      if ((Col = 3) AND 
          (Row <> 0)) then begin 
       {Размер и расположение combobox подгоняем под ячейку} 
        R := StringGrid1.CellRect(Col, Row); 
        R.Left := R.Left + StringGrid1.Left; 
        R.Right := R.Right + StringGrid1.Left; 
        R.Top := R.Top + StringGrid1.Top; 
        R.Bottom := R.Bottom + StringGrid1.Top; 
        ComboBox1.Left := R.Left + 1; 
        ComboBox1.Top := R.Top + 1; 
        ComboBox1.Width := (R.Right + 1) - R.Left; 
        ComboBox1.Height := (R.Bottom + 1) - R.Top; 
        //Определяем индекс
        ComboBox1.ItemIndex := ComboBoxNumIndex(StringGrid1.Cells[3, ARow], ComboBox1.Items.Text); 
        //Показываем СomboBox
        ComboBox1.Visible := True; 
        ComboBox1.SetFocus; 
      end; 
      CanSelect := True; 
    end;
     
    // Ставим ComboBox в позицию текста который отбражен в StringGrid-е
    Function ComboBoxNumIndex(TextGrid, TextCombo : String): Integer;
    var
     NumIndex: Integer;
    begin
       NumIndex := 0;
       while Pos(#13#10, TextCombo) <> 0 do
       begin
          if Copy(TextCombo, 0, Pos(#13#10, TextCombo)-1) = TextGrid then break
          else
          begin
             NumIndex := NumIndex + 1;
             TextCombo := Copy(TextCombo, Pos(#13#10, TextCombo)+2, Length(TextCombo));
          end;
       end;
       ComboBoxNumIndex := NumIndex;
    end;

