---
Title: Как вывести диалог «Обзор папок»
Author: Даниил Карапетян (delphi4all@narod.ru)
Date: 01.01.2007
---


Как вывести диалог «Обзор папок»
================================

Вариант 1:

Author: Даниил Карапетян (delphi4all@narod.ru)

Для вывода диалога "Обзор папок" существует функция SHBrowseForFolder.
Для выбора того, какие папки будут выведены в диалоге, используется
функция SHGetSpecialFolderLocation. В этой программе выводится рабочий
стол со всеми подпапками (папки рабочего стола, Мой компьютер, Корзина).
Для выбора папки в меню пуск используется CSIDL\_STARTMENU вместо
CSIDL\_DESKTOP.

    uses ShlObj;
     
    procedure CallBack(wnd: hWnd; uMsg: UINT; lParam, lpData: LParam) stdcall;
    begin
      SendMessage(wnd, BFFM_ENABLEOK, 0, 1);
    end;
     
    procedure TForm1.Button1Click(Sender: TObject);
    var
      bi: TBrowseInfo;
      s: PChar;
      PIDL, ResPIDL: PItemIDList;
    begin
      SHGetSpecialFolderLocation(Form1.Handle, CSIDL_DESKTOP, PIDL);
      s := StrAlloc(128);
      bi.hwndOwner := Form1.Handle;
      bi.pszDisplayName := s;
     
      bi.lpszTitle := 'Выбор прапки';
      bi.pidlRoot := PIDL;
      bi.lpfn := addr(CallBack);
      ResPidl := SHBrowseForFolder(BI);
      SHGetPathFromIDList(ResPidl, s);
      Form1.Caption := s;
    end;

Автор справки: Алексей Денисов (aleksey@sch103.krasnoyarsk.su)

------------------------------------------------------------------------

Вариант 2:

Author: Akella

Source: Vingrad.ru <https://forum.vingrad.ru>

    Uses ... ShlObj, ...
     
      private
        { Private declarations }
        sx:String;
    ...
     
    function TfmOptions.Selectdir(const str: string): string;
     
    function BrowseCallbackProc(hwnd: HWND; uMsg: UINT; lParam: LPARAM; lpData:LPARAM): integer; stdcall;
    begin
     Result := 0;
     if uMsg = BFFM_INITIALIZED then begin
     SendMessage(hwnd, BFFM_SETSELECTION, 1, LongInt(PChar(fmOptions.sx)))
     end;
    end;
     
    var
     TitleName : string;
     lpItemID : PItemIDList;
     BrowseInfo : TBrowseInfo;
     DisplayName : array[0..MAX_PATH] of char;
     TempPath : array[0..MAX_PATH] of char;
     begin
       Result:='';
       sx:=str;
       FillChar(BrowseInfo, sizeof(TBrowseInfo), #0);
       BrowseInfo.hwndOwner := Application.Handle;
       BrowseInfo.pszDisplayName := @DisplayName;
       TitleName := 'Выберите папку...';
       BrowseInfo.lpszTitle := PChar(TitleName);
       BrowseInfo.ulFlags := BIF_RETURNONLYFSDIRS or $0040 or BIF_EDITBOX or BIF_STATUSTEXT;
       BrowseInfo.lpfn := @BrowseCallbackProc;
       lpItemID := SHBrowseForFolder(BrowseInfo);
     
       if lpItemId <> nil then begin
         SHGetPathFromIDList(lpItemID, TempPath);
         Result:=StrPas(TempPath);
         GlobalFreePtr(lpItemID);
       end;
     {
      //////////////////////////////////////////////////////////////////////
      ---  bi.ulFlags флаги, которые задают режим отображения диалога:-----
      /////////////////////////////////////////////////////////////////////
     
      BIF_BROWSEFORCOMPUTER - Возвратить только компьютеры.
        Если пользователь выбрал что-то отличное от компьютеров, то кнопка OK останется серой.
     
      BIF_BROWSEFORPRINTER - Возвратить только принтеры. Если пользователь выбрал что-
         то отличное от принтеров, то кнопка OK останется серой.
     
      BIF_RETURNONLYFSDIRS - Возвратить только папки файловой системы.
         Если пользователь выберет папки, которые не являются частью файловой системы,
         то кнопка OK останется серой. Это необходимо для того если ваша программа не
         работает с виртуальными папками вроде "Панель управления".
     
      BIF_BROWSEINCLUDEFILES - Диалог просмотра будет отображать файлы вместе с директориями.
     
      BIF_DONTGOBELOWDOMAIN - Не включать сетевые папки Доменного уровня ниже,
         чем в TreeView контроле.
      BIF_RETURNFSANCESTORS - В качестве выбора допустимы только объекты,
         представленные в файловой системе.
      BIF_STATUSTEXT - Включает область статуса в блок диалога. Функция может
         установить текст посылая сообщения блоку диалога.
      BIF_EDITBOX - В диалоговом окне будет присутствовать строка редактирования,
        таким образом пользователь может набрать имя элемента.
      BIF_VALIDATE - Если пользователь введёт неверное имя в строке редактирования,
        то диалоговое окно вызовет функцию обратного вызова приложения по сообщению BFFM_VALIDATEFAILED.
     
      ResPidl := SHBrowseForFolder(BI);
    }
    end;
     
     
    //использование
    dbeArcSended.Text := IncludeTrailingPathDelimiter(Selectdir(ParamStr(0)));

