---
Title: Получить путь к выделенному файлу в TShellListView
Date: 01.01.2007
Source: <https://www.swissdelphicenter.ch>
---


Получить путь к выделенному файлу в TShellListView
==================================================

    Label1.Caption := ShellListView1.Folders[ShellListView1.ItemIndex].PathName
     
    {**************************************************************}
     
    { 
      To retrieve full paths to each file selected files: 
    }
     
    var
      path: string;
    begin
      for i:=0 to ShellListView1.SelCount-1 do
      begin
        path := ShellListView1.Folders[ShellListView1.GetNextItem(ShellListView1.Selected,
                  sdAll,[isSelected]).Index+i-1].PathName;
        // ... 
      end;
    end

