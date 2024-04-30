---
Title: Оглавление файлов помощи (Contents)
Date: 01.01.2007
Source: <https://delphiworld.narod.ru>
---


Оглавление файлов помощи (Contents)
===================================

Используйте HELP\_FINDER, если "текущая закладка" не является
закладкой \'Index\' или \'Find\'. HELP\_FINDER открывает окно Help
Topics, но не меняет закладку с оглавлением (Contents), если текущая
закладка - \'Index\' или \'Find\'.

Попробуйте следующий код:

    Function L1InvokeHelpMacro(const i_strMacro: String;
                               const i_bForceFile: Boolean): Boolean;
    Begin
      if i_bForceFile then
        Application.HelpCommand(HELP_FORCEFILE, 0);
      Result:=Application.HelpCommand(HELP_COMMAND,
        Longint(PChar(i_strMacro)));
        //Приведение типа PChar здесь необязательно.
    End;

Ищем ассоциированный файл помощи, открываем его (если не открыт) и
переходим на закладку \'Index\':

    L1InvokeHelpMacro('Search()', True);

Ищем ассоциированный файл помощи, открываем его (если не открыт) и
переходим на закладку \'Contents\':

    L1InvokeHelpMacro('Contents()', True);

Ищем ассоциированный файл помощи, открываем его (если не открыт) и
переходим на закладку \'Find\' (только для WinHelp 4):

    L1InvokeHelpMacro('Find()', True);

