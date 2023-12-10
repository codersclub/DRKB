---
Title: Определение адреса во всех открытых Explorer
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
---


Определение адреса во всех открытых Explorer
============================================

::: {.date}
01.01.2007
:::

    uses SHDocVw;

     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      I: Integer;
      Explorer: IShellWindows;
    begin
      Explorer := CoShellWindows.Create;
      for I := 0 to Explorer.Count - 1 do
        Listbox1.Items.Add((Explorer.Item(I) as IWebbrowser2).LocationUrl);
    end;



Автор: Александр (Rouse\_) Багель

Взято из <https://forum.sources.ru>


