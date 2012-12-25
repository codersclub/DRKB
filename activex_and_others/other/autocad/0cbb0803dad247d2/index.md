---
Title: Получение текущего чертежа из AutoCAD в формате DXF
Date: 01.01.2007
---


Получение текущего чертежа из AutoCAD в формате DXF
===================================================

::: {.date}
01.01.2007
:::

    { **** UBPFD *********** by kladovka.net.ru ****
    >> Получение текущего чертежа из AutoCAD в формате DXF
     
    Функция импортирует активного чертёж из AutoCAD в формате DXF и записывает полученные данные в список List. В случае успешного завершения функция возвращает True. В случае ошибки (AutoCAD не загружен, cбой OLE и проч.) функция возвращает False не внося изменений в список строк
     
    Зависимости: Windows, SysUtils, ComObj, ActiveX
    Автор:       Dimka Maslov, mainbox@endimus.ru, ICQ:148442121, Санкт-Петербург
    Copyright:   Dimka Maslov
    Дата:        22 ноября 2002 г.
    ********************************************** }
     
    function GetAcadDXFText(List: TStrings): Boolean;
    var
     TempDir, FileName: string;
     ClassID: TGUID;
     Unknown: IUnknown;
     Dispatch: IDispatch;
     App, Doc, Sel: Variant;
     TempList: TStringList;
    const
     Ext = 'dxf';
     DotExt = '.'+Ext;
    begin
     SetLength(TempDir, MAX_PATH);
     GetTempPath(MAX_PATH, PChar(TempDir));
     SetLength(TempDir, StrLen(@TempDir[1]));
     TempDir:=IncludeTrailingBackslash(TempDir);
     repeat
      FileName:=TempDir+IntToHex(LoWord(GetTickCount), 4)+DotExt;
     until not FileExists(FileName);
     SetLength(FileName, Length(FileName)-Length(DotExt));
     Result:=True;
     try
      ClassID := ProgIDToClassID('AutoCAD.Application');
      if not Succeeded(GetActiveObject(ClassID, nil, Unknown)) then Abort;
      Unknown.QueryInterface(IDispatch, Dispatch);
      App:=Dispatch;
      try
       Doc:=App.ActiveDocument;
       try
        Sel:=Doc.SelectionSets.Add('TEMP');
        try
         Doc.Export(FileName, Ext, Sel);
        finally
         Sel:=Unassigned;
        end;
       finally
        Doc:=Unassigned;
       end;
      finally
       App:=Unassigned;
      end;
      FileName:=FileName+DotExt;
      TempList:=TStringList.Create;
      try
       TempList.LoadFromFile(FileName);
       List.Assign(TempList);
      finally
       TempList.Free;
      end;
     except
      Result:=False;
     end;
     if FileExists(FileName) then DeleteFile(FileName);
    end; 

Пример использования:

    if not GetAcadDXFText(Memo1.Lines) then
     ShowMessage('Невозможно получить данные от AutoCAD'); 
