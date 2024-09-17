---
Title: Получить количество вложенных ключей и значений ветви реестра
Author: \_\_\_Nikolay
Date: 01.01.2007
Source: DelphiWorld 6.0 <https://delphiworld.narod.ru/>
---

Получить количество вложенных ключей и значений ветви реестра
=============================================================

    uses Registry;
     
    // Количество вложенных ключей и значений
    procedure TForm1.Button1Click(Sender: TObject);
    const
      sKey = '\SOFTWARE\Microsoft\Windows\CurrentVersion';
    var
      rReg: TRegistry;
      ki: TRegKeyInfo;
    begin
      rReg := TRegistry.Create;
      with rReg do
      begin
        RootKey := HKEY_LOCAL_MACHINE;
        if KeyExists(sKey) then
        begin
          OpenKey(sKey, false);
          GetKeyInfo(ki);
          CloseKey;
     
          lbSubkeys.Caption := IntToStr(ki.NumSubKeys);
          lbValues.Caption := IntToStr(ki.NumValues);
        end;
      end;
      rReg.Free;
    end;
index.md