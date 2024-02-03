---
Title: Перечислить ключи реестра
Date: 01.01.2007
---

Перечислить ключи реестра
=========================

::: {.date}
01.01.2007
:::

    { 
      This example demonstrates how to enumerate all registry keys from 
      a certain key (here: HKEY_CURRENT_USER) 
    }
     
     
     
     
     uses
       Registry;
     
     procedure TForm1.Button1Click(Sender: TObject);
     var
       indent: Integer;
     
          procedure EnumAllKeys(hkey: THandle);
       var
         l: TStringList;
         n: Integer;
       begin
         Inc(indent, 2);
         with TRegistry.Create do
           try
             RootKey := hkey;
             OpenKey(EmptyStr, False);
             l := TStringList.Create;
             try
               GetKeynames(l);
               CloseKey;
               for n := 0 to l.Count - 1 do
               begin
                 memo1.Lines.Add(StringOfChar(' ', indent) + l[n]);
                 if OpenKey(l[n], False) then
                 begin
                   EnumAllKeys(CurrentKey);
                   CloseKey;
                 end;
               end;
             finally
               l.Free
             end;
           finally
             Free;
           end;
         Dec(indent, 2);
       end;
     
     begin
       Memo1.Clear;
       Memo1.Lines.Add('Keys under HKEY_CURRENT_USER');
       indent := 0;
       Memo1.Lines.BeginUpdate;
       try
         EnumAllKEys(HKEY_CURRENT_USER);
       finally
         Memo1.Lines.EndUpdate;
       end;
     end;

Взято с сайта: <https://www.swissdelphicenter.ch>
