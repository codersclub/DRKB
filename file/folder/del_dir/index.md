---
Title: Удаление каталога с подкаталогами
Author: Baa
Date: 01.01.2007
Source: Vingrad.ru <https://forum.vingrad.ru>
---


Удаление каталога с подкаталогами
=================================

### Способ 1: проход по дереву каталогов

Функция для удаления каталогов,
взята из рассылки "Мастера DELPHI. Новости мира компонент, FAQ,
статьи..." - собственно код аналогичен написанному мной коду по
рекурсивному проходу каталогов [здесь](/file/folder/scan_dir/))

    Function MyRemoveDir(sDir : String) : Boolean;
    var
     iIndex : Integer;
     SearchRec : TSearchRec; 
     sFileName : String; 
    begin 
     Result := False; 
     sDir := sDir + '*.*'; 
     iIndex := FindFirst(sDir, faAnyFile, SearchRec); 
     while iIndex = 0 do 
     begin 
      sFileName := ExtractFileDir(sDir)+'\'+SearchRec.Name; 
      if SearchRec.Attr = faDirectory then 
      begin 
       if (SearchRec.Name <> '' ) and (SearchRec.Name <> '.') and (SearchRec.Name <> '..') then MyRemoveDir(sFileName); 
      end 
      else 
      begin 
       if SearchRec.Attr <> faArchive then FileSetAttr(sFileName, faArchive); 
       if NOT DeleteFile(sFileName) then ShowMessage('Could NOT delete ' + sFileName); 
      end; 
      iIndex := FindNext(SearchRec); 
     end; 
     FindClose(SearchRec); 
     RemoveDir(ExtractFileDir(sDir)); 
     Result := True; 
    end;


### Способ 2: Использование ShellApi


    uses ShellApi;
    ...
    var sh : SHFILEOPSTRUCT;
    begin
    ...
    sh.Wnd := Application.Handle;
    sh.wFunc := FO_DELETE;
    sh.pFrom := 'c:\\test\0';
    sh.pTo := nil;
    sh.fFlags := FOF_NOCONFIRMATION or FOF_SILENT;
    sh.hNameMappings := nil;
    sh.lpszProgressTitle := nil;
     
    SHFileOperation (sh);
    ... 
     

**Комментарий:**

Надо путь писать: c:\\\\test\\dfg

Чтобы вначале "\\\\" было... иначе не будет удалять диры из корня
