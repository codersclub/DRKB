Управление игрой FreeCell
=========================

::: {.date}
01.01.2007
:::

Если вы решили перепробовать ВСЕ номера игры FreeCell, вас можно
квалифицировать как законченного маньяка. В этом случае вас, возможно,
заинтересует эта маленькая программка. При ее запуске она загружает
FreeCell и начинает игру, следующую за той, которую вы не смогли
завершить в прошлый раз. А еще она отвечает на глупые вопросы типа \"Do
you really want to resign the game?\". После выигрыша программа изменяет
счетчик таким образом, чтобы при очередном запуске номер игры изменялся
на следующий автоматически.

Для создания программы расположите на новой форме таймер, установите ее
свойство WindowState на wsMinimized и используйте следующий код:

    ...
    private
      { Private declarations }
      InstHandle: Word;
      WndHandle: hWnd;
      NextGame: Word;
     
      function EnumFunc(H: HWnd): Word;
      procedure WMQUERYOPEN(var Msg: TWMQueryOpen); message WM_QUERYOPEN;
    ...
     
    interface
    USES
      ShellApi, IniFiles;
     
    const GWW_HINSTANCE = -6; 
    {$R *.DFM}
     
    procedure TForm1.FormCreate(Sender: TObject);
    var
      H, SubH: hMenu;
      NewGameID: Word;
      FreeCellPath: string;
    begin
      with TIniFile.Create(ChangeFileExt(Application.ExeName, '.INI')) do
      try
        FreeCellPath := ReadString('FreeCell', 'Path',
          'C:\WIN32APP\FREECELL\FREECELL.EXE') + #0;
        NextGame := ReadInteger('FreeCell', 'NextGame', 1);
      finally
        Free;
      end;
      InstHandle := ShellExecute(Handle, nil, @FreeCellPath[1],
        nil, nil, SW_SHOW);
      WndHandle := 0;
      if InstHandle >= 32 then
        EnumWindows(@TForm1.EnumFunc, LongInt(Self));
      if WndHandle <> 0 then
      begin
        {Вычисляем ID пункта меню "Select Game"}
        H := GetMenu(WndHandle);
        SubH := GetSubMenu(H, 0);
        NewGameID := GetMenuItemID(SubH, 1);
        Winprocs.SetFocus(WndHandle);
        {вызываем "Select Game"}
        PostMessage(WndHandle, WM_COMMAND, NewGameID, 0);
        Timer1.Enabled := True;
      end
      else
        Close;
    end;
     
    procedure TForm1.WMQUERYOPEN(var Msg: TWMQueryOpen);
    begin
      Msg.Result := 0;
    end;
     
    function TForm1.EnumFunc(H: HWnd): Word;
    begin
     
      if GetWindowWord(H, GWW_HINSTANCE) = InstHandle then
      begin
        WndHandle := H;
        Result := 0;
      end
      else
        Result := 1;
    end;
     
    procedure TForm1.Timer1Timer(Sender: TObject);
    var
      Buffer: array[0..10] of Char;
     
      DlgHandle: Word;
    begin
     
      {Если пользователь закрыл FreeCell, выходим!}
      if GetModuleUsage(InstHandle) = 0 then
      begin
        Close;
        Exit;
      end;
      {При необходимости укажите номер игры}
      DlgHandle := FindWindow('#32770', 'Game Number');
      if DlgHandle <> 0 then
      begin
        Str(NextGame, Buffer);
        SendDlgItemMessage(DlgHandle, $CB, WM_SETTEXT,
          0, LongInt(@Buffer));
        PostMessage(DlgHandle, WM_COMMAND, 1,
          MakeLong(GetDlgItem(DlgHandle, 1), BN_CLICKED));
      end;
      {Если игра окончена, увеличиваем счетчик}
      DlgHandle := FindWindow('#32770', 'Game Over');
      if DlgHandle <> 0 then
      begin
        Inc(NextGame);
        with TIniFile.Create(ChangeFileExt(Application.ExeName, '.INI')) do
        try
          WriteInteger('FreeCell', 'NextGame', NextGame);
        finally Free;
        end;
        PostMessage(DlgHandle, WM_COMMAND, 6,
          MakeLong(GetDlgItem(DlgHandle, 6), BN_CLICKED));
      end;
      {Если игра спрашивает, хотите ли вы выйти, отвечем соответственно yes или OK}
      DlgHandle := FindWindow('#32770', 'FreeCell');
      if DlgHandle <> 0 then
      begin
        if (not (GetDlgItemText(DlgHandle, 6, Buffer, 10) in [0, 10]))
          and (StrComp(Buffer, '&Yes') = 0) then
          PostMessage(DlgHandle, WM_COMMAND, 6,
            MakeLong(GetDlgItem(DlgHandle, 6), BN_CLICKED))
        else if (not (GetDlgItemText(DlgHandle, 2, Buffer, 10) in [0, 10]))
          and (StrComp(Buffer, 'Cancel') = 0) then
          PostMessage(DlgHandle, WM_COMMAND, 1,
            MakeLong(GetDlgItem(DlgHandle, 1), BN_CLICKED))
      end;
    end;

Взято с <https://delphiworld.narod.ru>
