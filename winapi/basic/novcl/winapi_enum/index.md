---
Title: Использование функций перечисления WinAPI
Date: 01.01.2007
---


Использование функций перечисления WinAPI
=========================================

::: {.date}
01.01.2007
:::

Для получения информации о множественных объектах Windows (окнах,
принтерах, шрифтах, настройках экрана и так далее - всего несколько
десятков вариантов) используются функции, начинающиеся с Enum. Эти
функции работают по принципу, аналогичному итератору
TCollection.FirstThat, то есть они вызывают функцию, переданную им в
качестве параметра для каждого перечисляемого объекта, передавая ей в
параметрах данные объекта и, в последнем параметре, указатель на
пользовательские данные, переданный функции EnumXXX. Перечисление
продолжается до тех пор, пока не будут перечислены все объекты.
Немедленно прекратить перечисление можно, возвратив False.

Ниже приведен
пример заполнения списка ListBox1 данными по всем окнам Windows в виде
\" класс - заголовок\" по нажатию кнопки Button1.

    function AddWinInfo(WinHandle: HWnd; List: TStringList): Boolean;
    stdcall;
    var
      WinCaption,WinClass: array[0..255] of Char;
    begin
      Result:=True;
      GetClassName(WinHandle,WinClass,SizeOf(WinClass));
      GetWindowText(WinHandle,WinCaption,SizeOf(WinCaption));
      List.Add(WinClass+' - '+WinCaption);
    end;
     
    procedure TfrmMain.Button1Click(Sender: TObject);
    begin
      with ListBox1,Items do
      begin
        Clear;
        EnumWindows(@AddWinInfo,LParam(Items));
      end;
    end;

Взято с <https://delphiworld.narod.ru>
