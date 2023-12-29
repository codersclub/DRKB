---
Title: Как добавить кнопку в панель инструментов IE?
Date: 01.01.2007
---


Как добавить кнопку в панель инструментов IE?
=============================================

::: {.date}
01.01.2007
:::

1\. ButtonText = Всплывающая подсказка к кнопке

2\. MenuText = Текст, который будет использован для пункта в меню
"Сервис"

3\. MenuStatusbar = *Ignore*

4\. CLSID = Ваш уникальный classID. Для создания нового CLSID (для каждой
кнопки) можно использовать GUIDTOSTRING.

5\. Default Visible := Показать ей.

6\. Exec := Путь к Вашей программе.

7\. Hoticon := иконка из shell32.dll когда мышка находится над кнопкой

8\. Icon := иконка из shell32.dll

    procedure CreateExplorerButton;
    const
      TagID = '\{10954C80-4F0F-11d3-B17C-00C0DFE39736}\';
    var
      Reg: TRegistry;
            ProgramPath: string;
      RegKeyPath: string;
    begin
     ProgramPath := 'c:\folder\exename.exe';
     Reg := TRegistry.Create;
     try
      with Reg do begin
       RootKey := HKEY_LOCAL_MACHINE;
       RegKeyPath := 'Software\Microsoft\Internet Explorer\Extensions';
       OpenKey(RegKeyPath + TagID, True);
       WriteString('ButtonText', 'Your program Button text');
       WriteString('MenuText', 'Your program Menu text');
       WriteString('MenuStatusBar', 'Run Script');
       WriteString('ClSid', '{1FBA04EE-3024-11d2-8F1F-0000F87ABD16}');
       WriteString('Default Visible', 'Yes'); 
       WriteString('Exec', ProgramPath);
       WriteString('HotIcon', ',4');
       WriteString('Icon', ',4');
      end
     finally
      Reg.CloseKey;
      Reg.Free;
     end;
    end;

После выполнения этого кода достаточно просто запустить IE.

Взято из <https://forum.sources.ru>
