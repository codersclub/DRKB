---
Title: Как проверить инсталлирован ли MS Word?
Date: 01.01.2007
---


Как проверить инсталлирован ли MS Word?
=======================================

Вариант 1:

    uses
      ..., Registry;
     
    function IsMicrosoftWordInstalled: Boolean;
    var
      Reg: TRegistry;
      S: string;
    begin
      Reg := TRegistry.Create;
      with Reg do
      begin
        RootKey := HKEY_CLASSES_ROOT;
        Result := KeyExists('Word.Application');
        Free;
      end;
    end;

------------------------------------------------------------------------
Вариант 2:

    function MSWordIsInstalled: Boolean;
    begin
      Result := AppIsInstalled('Word.Application');
    end;
     
    function AppIsInstalled(strOLEObject: string): Boolean;
    var
      ClassID: TCLSID;
    begin
      Result := (CLSIDFromProgID(PWideChar(WideString(strOLEObject)), ClassID) = S_OK)
    end;

Взято с Delphi Knowledge Base: <https://www.baltsoft.com/>

------------------------------------------------------------------------
Вариант 3:

Как определить установлен ли на компьютере Word, запустить его и
загрузить в него текст из программы?

Пример:

    var
     MsWord: Variant;
    ...
    try
     // Если Word уже запущен
     MsWord := GetActiveOleObject('Word.Application');
     // Взять ссылку на запущенный OLE объект
     except
      try
      // Word не запущен, запустить
      MsWord := CreateOleObject('Word.Application');
      // Создать ссылку на зарегистрированный OLE объект
      MsWord.Visible := True;
       except
        ShowMessage('Не могу запустить Microsoft Word');
        Exit;
       end;
      end;
     end;
    ...
    MSWord.Documents.Add; // Создать новый документ
    MsWord.Selection.Font.Bold := True; // Установить жирный шрифт
    MsWord.Selection.Font.Size := 12; // установить 12 кегль
    MsWord.Selection.TypeText('Текст');

Источник: <https://dmitry9.nm.ru/info/>
