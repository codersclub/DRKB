---
Title: Получаем имена ODBC-источников
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Получаем имена ODBC-источников
==============================

    uses Registry; 
     
    procedure TForm1.GetDataSourceNames(System: Boolean); 
    var 
      reg: TRegistry; 
    begin 
      ListBox1.Items.Clear; 
     
      reg := TRegistry.Create; 
      try 
        if System then 
          reg.RootKey := HKEY_LOCAL_MACHINE 
        else 
          reg.RootKey := HKEY_CURRENT_USER; 
     
        if reg.OpenKey('\Software\ODBC\ODBC.INI\ODBC Data Sources', False) then 
        begin 
          reg.GetValueNames(ListBox1.Items); 
        end; 
     
      finally 
        reg.CloseKey; 
        FreeAndNil(reg); 
      end; 
    end; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    begin 
      //Системные DSNs 
      GetDataSourceNames(True); 
      //Пользовательские DSNs 
      GetDataSourceNames(False); 
    end;

