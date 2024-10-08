---
Title: Получение информации о папках и файлах находящихся на данный момент в корзине
Author: Rouse_
Date: 01.01.2004
Source: <https://forum.sources.ru>
---

Получение информации о папках и файлах находящихся на данный момент в корзине
=============================================================================

    unit Unit1;
     
    interface
     
    uses
      Windows, Messages, SysUtils, Variants, Classes, Graphics, Controls, Forms,
      Dialogs, StdCtrls, ShellAPI, ShlObj, ActiveX, ComCtrls, Menus;
     
    // корзина отображает не всю информацию по удаленному элементу
    // а только 6 позиций.
    // в действительности этих позиций больше...
    const
      DETAIL_COUNT = 11;
     
    type
      TForm1 = class(TForm)
        Button1: TButton;
        ListView1: TListView;
        PopupMenu1: TPopupMenu;
        mnuRestore: TMenuItem;
        procedure Button1Click(Sender: TObject);
        procedure mnuRestoreClick(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    // Функция взята из QDialogs...
    function StrRetToString(PIDL: PItemIDList; StrRet: TStrRet;
      Flag: String = ''): String;
    var
      P: PChar;
    begin
      case StrRet.uType of
        STRRET_CSTR:
          SetString(Result, StrRet.cStr, lStrLen(StrRet.cStr));
        STRRET_OFFSET:
          begin
            P := @PIDL.mkid.abID[StrRet.uOffset - SizeOf(PIDL.mkid.cb)];
            SetString(Result, P, PIDL.mkid.cb - StrRet.uOffset);
          end;
        STRRET_WSTR:
          if Assigned(StrRet.pOleStr) then
            Result := StrRet.pOleStr
          else
            Result := '';
      end;
      { This is a hack bug fix to get around Windows Shell Controls returning
        spurious "?"s in date/time detail fields }
      if (Length(Result) > 1) and (Result[1] = '?') and (Result[2] in ['0'..'9']) then
        Result := StringReplace(Result, '?', '', [rfReplaceAll]);
    end;
     
    // Смотрим содержимое корзины...
    function ViewRecycleBin(const AHandle: THandle; LV: TListView): Boolean;
    var
      ppidl, Item: PItemIDList;
      Desktop: IShellFolder;
      RecycleBin: IShellFolder2;
      RecycleBinEnum: IEnumIDList;
      Fetched, I: Cardinal;
      Details: TShellDetails;
      Mallok: IMalloc;
      TmpStr: ShortString;
    begin
      Result := False;
      if LV = nil then Exit;
      LV.Clear;
      LV.Columns.Clear;
      LV.ViewStyle := vsReport;
      if SHGetMalloc(Mallok) = S_OK then
        if SHGetSpecialFolderLocation(AHandle, CSIDL_BITBUCKET, ppidl) = S_OK then
          if SHGetDesktopFolder(Desktop) = S_OK then
            if Desktop.BindToObject(ppidl, nil, IID_IShellFolder2, RecycleBin) = S_OK then
              if RecycleBin.EnumObjects(AHandle,
                SHCONTF_FOLDERS or SHCONTF_NONFOLDERS, RecycleBinEnum) = S_OK  then
              begin
                // Создаем колонки
                for I := 0 to DETAIL_COUNT - 1 do
                  if RecycleBin.GetDetailsOf(nil, I, Details) = S_OK then
                  try
                    with LV.Columns.Add do
                    begin
                      Caption := StrRetToString(Item, Details.str);
                      Width := LV.Canvas.TextWidth(Caption) + 24;
                    end;
                  finally
                    Mallok.Free(Details.str.pOleStr);
                  end;
                // Перечиляем содержимое корзины
                while True do
                begin
                  RecycleBinEnum.Next(1, Item, Fetched);
                  if Fetched = 0 then Break;
                  if RecycleBin.GetDetailsOf(Item, 0, Details) = S_OK then
                  begin
                    try
                      TmpStr := StrRetToString(Item, Details.str);
                    finally
                      Mallok.Free(Details.str.pOleStr);
                    end;
                    with LV.Items.Add do
                    begin
                      Caption := TmpStr;
                      for I := 1 to DETAIL_COUNT - 1 do
                        if RecycleBin.GetDetailsOf(Item, I, Details) = S_OK then
                        try
                          SubItems.Add(StrRetToString(Item, Details.str));
                        finally
                          Mallok.Free(Details.str.pOleStr);
                        end;
                    end;
                  end;
                end;
                Result := True;
              end;
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    begin
      ViewRecycleBin(Handle, ListView1);
    end;      
     
    end.

Пример работы с корзиной можно скачать здесь:

[rbin.zip](../rbin.zip) 2k

