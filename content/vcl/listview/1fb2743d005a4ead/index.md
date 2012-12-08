---
Title: Как добавлять в TListView полноцветные иконки?
Author: alexanderm
Date: 01.01.2007
---


Как добавлять в TListView полноцветные иконки?
==============================================

::: {.date}
01.01.2007
:::

    procedure TForm1.FormCreate(Sender: TObject);
    var
      SysIL   : THandle;
      SysSIL  : THandle;
      SFI     : TSHFileInfo;
    begin
      SysImageList1 := TImageList.Create(self);
      with SysImageList1 do begin
          Width  := 16;
          Height := 16;
          SysSIL := SHGetFileInfo('', 0, SFI, SizeOf(SFI),
            SHGFI_SYSICONINDEX or SHGFI_SMALLICON);
          if SysSIL <> 0 then begin
            SysImageList1.Handle := SysSIL;
            ShareImages := True;
          end;
        end;
      SysImageList2 := TImageList.Create(self);
      with SysImageList2 do begin
          Width := 32;
          Height := 32;
          SysIL := SHGetFileInfo('', 0, SFI, SizeOf(SFI),
            SHGFI_SYSICONINDEX or SHGFI_LARGEICON);
          if SysIL <> 0 then begin
            SysImageList2.Handle := SysIL;
            ShareImages := True;
          end;
        end;
    end;
     
    function GetIconIndex(const AFile: string; Attrs: DWORD): integer;
    var
      SFI: TSHFileInfo;
    begin
      SHGetFileInfo(PChar(AFile), Attrs, SFI, SizeOf(TSHFileInfo),
        SHGFI_SYSICONINDEX or SHGFI_USEFILEATTRIBUTES);
      Result := SFI.iIcon;
    end;
    ....
    with ListView.Items.Add do begin
      Caption := FName;
      ImageIndex := GetIconIndex(Caption, FILE_ATTRIBUTE_NORMAL);
      SubItems.Add(FSize);  
      SubItems.Add(FType);
      SubItems.Add(FDateTime);
    end;

Взято из <https://forum.sources.ru>

Автор: alexanderm
