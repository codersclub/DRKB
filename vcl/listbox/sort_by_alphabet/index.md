---
Title: Сортировать список по алфавиту
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Сортировать список по алфавиту
==============================

Вам нужны TListBox и TButton.
С несколькими изменениями вы можете использовать его с любой переменной, совместимой с TStringList.
Если вы измените оператор "<" на ">" в предложении "if" ниже, то порядок станет обратным.

    { 
     You need a TListBox and a TButton. 
     With a few modifications, you can use it with any variable 
     compatible with a TStringList. 
     If you change the operator "<"  for a ">" in the 'if' clause 
     below, the order will be reversed 
    }
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       i, x: Integer;
     begin
       for i := 0 to (ListBox1.Items.Count - 1) do
         for x := 0 to (ListBox1.Items.Count - 1) do
           if (ListBox1.Items[x] < ListBox1.Items[i]) and (x > i) then
           begin
             ListBox1.Items.Insert(i, ListBox1.Items[x]);
             ListBox1.Items.Delete(x + 1);
           end;
     end;


 
