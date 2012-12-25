---
Title: Как добавить True Type шрифт в систему?
Date: 01.01.2007
---

Как добавить True Type шрифт в систему?
=======================================

::: {.date}
01.01.2007
:::

Чтобы установить шрифт в систему, необходимо скопировать файл шрифта в
\'Windows\\Fonts\' и добавить ключ в реестр:

\'Software\\Microsoft\\Windows\\CurrentVersion\\Fonts\'

Этот ключ указывает на файл шрифта. Далее запускаем API функцию
\'AddFontRecource\'. В заключении нужно уведомить систему
широковещательным сообщением.

    uses Registry; 
     
    procedure TForm1.Button1Click(Sender: TObject); 
    var 
      hReg: TRegistry; 
      hBool : bool; 
    begin 
      CopyFile('C:\DOWNLOAD\FP000100.TTF', 
               'C:\WINDOWS\FONTS\FP000100.TTF', hBool); 
      hReg := TRegistry.Create; 
      hReg.RootKey := HKEY_LOCAL_MACHINE; 
      hReg.LazyWrite := false; 
      hReg.OpenKey('Software\Microsoft\Windows\CurrentVersion\Fonts', 
                   false); 
      hReg.WriteString('TESTMICR (TrueType)','FP000100.TTF'); 
      hReg.CloseKey; 
      hReg.free; 
      //Добавляем ресурс шрифта
      AddFontResource('c:\windows\fonts\FP000100.TTF'); 
      SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0); 
      //Убираем блокировку ресурса
      RemoveFontResource('c:\windows\fonts\FP000100.TTF'); 
      SendMessage(HWND_BROADCAST, WM_FONTCHANGE, 0, 0); 
    end;

Взято с <https://delphiworld.narod.ru>
