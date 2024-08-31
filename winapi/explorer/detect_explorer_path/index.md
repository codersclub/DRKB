---
Title: Определение адреса во всех открытых Explorer
Author: Александр (Rouse\_) Багель
Date: 01.01.2007
Source: <https://forum.sources.ru>
---


Определение адреса во всех открытых Explorer
============================================

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




