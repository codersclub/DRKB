---
Title: Hint на системных кнопках, Как это делается?
Author: Rouse\_
Date: 01.01.2007
---


Hint на системных кнопках, Как это делается?
=============================================

::: {.date}
01.01.2007
:::

Довольно сложный вопрос. Так просто не сделаешь. Нужно отлавливать
WM\_NCMOUSEMOVE и WM\_NCHITTEST в них блокировать системный хинт и
отрисовывать свой. Нет временипример делать. Но тут еще одно - если ты
их решил модифицировать, то тебе нужно еще и два системных меню
русифицировать. то которое в заголовке формы и то которое в тулбаре
внизу. Это на порядок проще и делается вот таким кодом:\

 

    unit Unit1;

     
    interface
     
    uses
      Windows, Messages, SysUtils, Classes, Graphics, Controls, Forms, Dialogs;
     
    type
      TForm1 = class(TForm)
        procedure FormCreate(Sender: TObject);
      end;
     
    var
      Form1: TForm1;
     
    implementation
     
    {$R *.dfm}
     
    procedure ChangeMenuLanguage(AHandle: THandle);
    const
      RusTranscriptionCount = 6;
      SysMenuID: array [0..RusTranscriptionCount - 1] of UINT =
        (SC_RESTORE, SC_MOVE, SC_SIZE, SC_MINIMIZE, SC_MAXIMIZE, SC_CLOSE);
      RusTranscription: array [0..RusTranscriptionCount - 1] of String =
        ( '&Восстановить', '&Переместить', '&Размер', '&Свернуть',
          'Р&азвернуть', '&Закрыть'#9'Alt+F4');
    var
      SysMenu: HMENU;
      MenuItem: TMenuItemInfo;
      ItemCount, I, A: Integer;
      MenuString: array [0..MAXCHAR - 1] of Char;
    begin
      SysMenu := GetSystemMenu(AHandle, False);
      if SysMenu <> 0 then
      begin
        ItemCount := GetMenuItemCount(SysMenu);
        for I := 0 to ItemCount - 1 do
        begin
          ZeroMemory(@MenuItem, SizeOf(TMenuItemInfo));
          MenuItem.cbSize := SizeOf(TMenuItemInfo);
          MenuItem.fMask := MIIM_ID or MIIM_STRING or MIIM_BITMAP;
          MenuItem.dwTypeData := MenuString;
          MenuItem.cch := MAXCHAR;
          if GetMenuItemInfo(SysMenu, I, True, MenuItem) then
            for A := 0 to RusTranscriptionCount - 1 do
              if SysMenuID[A] = MenuItem.wID then
              begin
                MenuItem.dwTypeData := PChar(RusTranscription[A]);
                MenuItem.cch := Length(RusTranscription[A]);
                if not SetMenuItemInfo(SysMenu, I, True, MenuItem) then RaiseLastOSError;
              end;
        end;
      end;
    end;
     
    procedure TForm1.FormCreate(Sender: TObject);
    begin
      ChangeMenuLanguage(Handle);
      ChangeMenuLanguage(Application.Handle);
    end;

Взято из <https://forum.sources.ru>

Автор: Rouse\_
